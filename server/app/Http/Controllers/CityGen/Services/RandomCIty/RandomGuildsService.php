<?php

namespace App\Http\Controllers\CityGen\Services\RandomCity;

use App\Http\Controllers\CityGen\Constants\MinMax;
use App\Http\Controllers\CityGen\Constants\Table;
use App\Http\Controllers\CityGen\Models\City\City;
use App\Http\Controllers\CityGen\Models\City\CityGuild;
use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Services\BaseService;

class RandomGuildsService extends BaseService
{

    /**
     *
     * @param City $city
     * @param PostData $postData
     */
    public function determineGuilds(City $city, PostData $postData)
    {
        $modifierMinMax = $this->services->table->getTableResultIndex(Table::GUILD_MODIFIERS, $city->populationType);
        $modifier = 50 + $this->services->random->randMinMax('Guild Modifier', $modifierMinMax);

        // loop through each guild
        foreach (Table::getTable(Table::GUILDS)->getTable() as $guild => $professions) {
            // count up number of $this->professions for each guild profession from table
            $count = 0;
            foreach ($professions as $profession) {
                $found = false;
                foreach ($city->professions as $cityProfession) {
                    if ($cityProfession->profession === $profession) {
                        $found = $cityProfession;
                        break;
                    }
                }
                if ($found) {
                    $count += $found->total;
                }

                // divide by (50 +/- offset) to get # of guilds of this type in this city
            }

            $number = intval($count / $modifier);
            if ($number) {
                $city->guilds[] = new CityGuild($guild, $number);
            }
        }
    }

}
