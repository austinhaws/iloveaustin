<?php

namespace App\Http\Controllers\CityGen\Services\RandomCity;

use App\Http\Controllers\CityGen\Constants\MinMax;
use App\Http\Controllers\CityGen\Constants\Table;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\City\CityNPCLevelCount;
use App\Http\Controllers\CityGen\Models\City\CityNPCs;
use App\Http\Controllers\CityGen\Models\City\CityPowerCenter;
use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Services\BaseService;

class RandomPowerCentersService extends BaseService
{
    private $powerCenterId = 1;

    /**
     * @param City $city
     * @param PostData $postData
     */
    public function determinePowerCenters(City $city, PostData $postData)
    {
        $powerLevelMinMax = $this->services->table->getTableResultIndex(Table::POPULATION_POWER_CENTER, $city->populationType);
        $powerLevel = $this->services->random->randMinMax('Power Level', $powerLevelMinMax);

        if ($powerLevel) {
            $influenceMinMax = $this->services->table->getTableResultIndex(Table::POPULATION_INFLUENCE_POINTS, $city->populationType);
            $influencePoints = $this->services->random->randMinMax('Influence points', $influenceMinMax);

            $percent = $this->services->table->getTableResultIndex(Table::POPULATION_CENTER_UNABSORBED, $city->populationType);

            $city->influencePointsUnabsorbed = $influencePoints * $percent;
            $influencePoints -= $city->influencePointsUnabsorbed;
            $totalInfluencePoints = $influencePoints;

            $averageInfluence = $influencePoints / $powerLevel;
            $offsetInfluence = $averageInfluence / 10.0;

            for ($i = 0; $i < $powerLevel; ++$i) {
                $type = $this->services->table->getTableResultRange(Table::POWER_CENTER_TYPE);

                if ($i == $powerLevel) {
                    // use the remainder of points
                    $influence = $influencePoints;
                } else {
                    // get random amount based on range of possibles
                    $influence = $this->services->random->randRangeInt('Influence', $averageInfluence - $offsetInfluence, $averageInfluence + $offsetInfluence);
                    $influencePoints = $influencePoints - $influence;
                }

                // power center's wealth is a matching ratio of city's wealth to influence points percentage
                $ratio = $influence / $totalInfluencePoints;
                $wealth = $ratio * $city->wealth;

                // nonstandard has a 5% chance of being monstrous
                $this->generatePowerCenter($city, $type, $influence, $wealth, $powerLevel);
            }
        }
    }

    /**
     * @param City $city
     * @param string $type
     * @param int $influencePoints
     * @param float $wealth
     * @param int $powerLevel
     */
    private function generatePowerCenter(City $city, string $type, int $influencePoints, float $wealth, int $powerLevel)
    {
        $powerCenter = new CityPowerCenter();
        $powerCenter->id = $this->powerCenterId++;
        $powerCenter->type = $type;
        $powerCenter->influencePoints = $influencePoints;
        $powerCenter->wealth = $wealth;
        $powerCenter->numberCenters = $powerLevel;
        $powerCenter->alignment = $this->services->table->getTableResultRange(Table::POWER_CENTER_ALIGNMENT);

        $city->powerCenters[] = $powerCenter;

        $this->random_npcs($powerCenter, $city);
    }

    /**
     * @param CityPowerCenter $powerCenter
     * @param City $city
     */
    private function random_npcs(CityPowerCenter $powerCenter, City $city)
    {
        /*
		• do class / level looping/run down for each power center
		• each class/level slot only has a 1 in # power centers chance of generating NPCs of the given level

		• this will divide the total number of NPCs across the # of power centers and will give each
		power center a differing splatter of NPCs yet could allow multiple power centers to have the
		same spattering

		• it will also make sure that all the possible influence points for the center are used for the center
		*/
        $modifier = $this->services->table->getTableResultIndex(Table::NPC_LEVEL_MODIFIERS, $city->populationType);

        $influenceLeft = $powerCenter->influencePoints;

        // how many times it failed to add (usually because it picked something too expensive)
        $notUsedCount = 0;

        // represents a row of npc levels all set to 0; each new npc class gets one of these rows
        $levelsPreFilled = array_map(function ($i) { return new CityNPCLevelCount($i, 0); }, range(1, 20));

        while ($influenceLeft && $notUsedCount < 5) {
            // randomly pick a class
            $class = $this->services->table->getTableResultRange(Table::NPC_CLASS_RANDOM_CLASS);

            // randomly pick level
            $maxLevel = $this->services->table->getTableResultIndex(Table::NPC_CLASSES_MAX_LEVEL, $class) + $modifier;
            $maxLevel = max(0, min(20, $maxLevel + $this->services->random->randRangeInt('NPC level bonus', 0, 1)));

            $num = 1;
            $notUsedFor = true;
            for ($level = $this->services->random->randRangeInt('NPC level', 1, $maxLevel); $level > 0; $level = $this->nextLevel($level)) {
                $influenceCost = $this->services->table->getTableResultIndex(Table::NPC_CLASS_INFLUENCE, $class);
                $notUsed = true;
                while ($num >= 1 && $notUsed) {
                    if (0 > $influenceLeft - ($influenceCost * $level * $num)) {
                        --$num;
                    } else {
                        $influenceLeft -= $influenceCost * $level * $num;
                        $found = false;
                        foreach ($powerCenter->npcs as $key => $npc) {
                            if ($npc->class == $class) {
                                $found = $key;
                                break;
                            }
                        }
                        if ($found === false) {
                            $powerCenter->npcs[] = new CityNPCs($class, $levelsPreFilled);
                            $found = count($powerCenter->npcs) - 1;
                        }
                        $foundLevel = false;
                        foreach ($powerCenter->npcs[$found]->levels as $keyLevelLoop => $levelLoop) {
                            if ($levelLoop->level == $level) {
                                $foundLevel = $keyLevelLoop;
                                break;
                            }
                        }
                        $powerCenter->npcs[$found]->levels[$foundLevel]->count += $num;
                        $powerCenter->npcsTotal += $num;
                        $notUsed = false;
                        $notUsedFor = false;
                    }
                }
                $num = max($num * 2, 1);
            }
            if ($notUsedFor) {
                ++$notUsedCount;
            }
        }

        usort($powerCenter->npcs, function ($a, $b) {
            return strcmp($a->class, $b->class);
        });
    }

    /**
     * @param $level
     * @return int
     */
    private function nextLevel($level)
    {
        if ($level === 1) {
            $result = 0;
        } else {
            $result = intval($level / 2) + ($level % 2) + ($this->services->random->randRangeInt('NPC Level Increase', 1, 10) == 1 ? 1 : 0);
        }
        return $result;
    }
}
