<?php

namespace App\Http\Controllers\CityGen\Models\City;

use App\Http\Controllers\CityGen\Constants\BooleanRandom;

class City
{
    /** @var int */
    public $populationSize = null;
    /** @var string PopulationType:: */
    public $populationType = null;
    /** @var string */
    public $name = '';
    /** @var int int */
    public $numStructures = 0;
    /** @var float  */
    public $acres = 0.0;
    /** @var bool BooleanRandom:: */
    public $hasSea = BooleanRandom::FALSE;
    /** @var bool BooleanRandom:: */
    public $hasMilitary = BooleanRandom::FALSE;
    /** @var bool BooleanRandom:: */
    public $hasRiver = BooleanRandom::FALSE;
    // todo rename to numGates
    /** @var int */
    public $gates = 0;
    /** @var CityWard[] */
    public $wards = [];
    /** @var CityProfession[] */
    public $professions = [];
    /** @var int */
    public $influencePointsUnabsorbed = 0;

    /** @var float */
    public $wealth;
    /** @var int */
    public $goldPieceLimit;
    /** @var float */
    public $magicResources;
    /** @var float */
    public $kingIncome;

    /** @var array CityPowerCenter[] */
    public $powerCenters = [];

    /** @var string Race:: */
    public $majorityRace;
    /** @var CityRace[] */
    public $races;

    /** @var CityGuild[] */
    public $guilds = [];

    /** @var string[] */
    public $commoditiesExport = [];
    /** @var string[] */
    public $commoditiesImport = [];

    /** @var string[] */
    public $famous = [];
    /** @var string[] */
    public $infamous = [];

    public $population_density = 0.0;
//	public $layout = new Layout_CityMapClass();
    // outputs for json (sorry, hacky)
    public $races_output = false; // the races formatted for output
    public $gold_piece_limit_output = false;
    public $wealth_output = false;
    public $king_income_output = false;
    public $magic_resources_output = false;
    public $famous_famous = false;
    public $famous_infamous = false;
    public $buildings_total = false;

//	public function generate_map() {
//		$this->layout->generate($this);
//	}

    public function random_name()
    {
        global $table_syllables, $table_name_num_words, $table_name_num_syllables;

        // do conversion to other languages using dictionary
        switch ($this->majority_race) {
            case kRace_Elf:
                $dictionary = 'Elf';
                break;

            case kRace_Gnome:
            case kRace_Dwarf:
                $dictionary = 'Goblin';
                break;

            case kRace_HalfElf:
                // split 50/50 human or elf
                if (rand_range(1, 100) > 50) {
                    $dictionary = 'Elf';
                } else {
                    $dictionary = '';
                }
                break;

            case kRace_HalfOrc:
                // split 50/50 orc or elf
                if (rand_range(1, 100) > 50) {
                    $dictionary = 'Tolkien Black Speech';
                } else {
                    $dictionary = '';
                }
                break;

            case kRace_Halfling:
            case kRace_Human:
            case kRace_Other:
                $dictionary = '';
                break;

            default:
                exit('Oops, bad majority race: ' . $this->majority_race);
        }

        if (!$dictionary && rand_range(1, 100) > 50) {
            global $table_name_prefixes, $table_name_suffixes, $table_name_words, $table_name_words_count;

            $parts = array();
            $count = get_table_result_range($table_name_num_words, rand_range(1, 100));
            while ($count-- > 0) {
                // each word has the possibility of being one or two words combined
                if (rand_range(1, 100) > 75) {
                    $part = get_table_result_random($table_name_words) . get_table_result_random($table_name_words);
                } else {
                    $part = get_table_result_random($table_name_words);
                }
                if (rand_range(1, 100) > 90) {
                    $part = get_table_result_random($table_name_prefixes) . $part;
                }
                if (rand_range(1, 100) > 90) {
                    $part .= get_table_result_random($table_name_suffixes);
                }
                $parts[] = $part;
            }
            $this->name = implode(' ', $parts);

        } else {
            $num_words = get_table_result_range($table_name_num_words, rand_range(1, 100));
            for ($i = 0; $i < $num_words; ++$i) {
                $parts = array();
                $num_syllables = get_table_result_range($table_name_num_syllables, rand_range(1, 55));
                for ($j = 0; $j < $num_syllables; ++$j) {
                    $parts[] = get_table_result_range($table_syllables, rand_range(1, 650));
                }
                if ($this->name) {
                    $this->name .= ' ';
                }
                $this->name .= implode('', $parts);
            }
            if ($dictionary) {
                $content = file_get_contents("http://strategerygames.com/dictionary/remote.php?dictionary=" . urlencode($dictionary) . '&shuffle=0&text=' . urlencode($this->name));
                $content = mb_convert_encoding($content, 'UTF-8', mb_detect_encoding($content, 'UTF-8, ISO-8859-1', true));
                $this->name = $content;
            }
        }

        $this->name = ucwords($this->name);
    }

    // todo: remove this - but is it used?
    public function wards_count($ward_type)
    {
        $count = 0;
        foreach ($this->wards as $ward) {
            if ($ward->type() == $ward_type) {
                $count++;
            }
        }
        return $count;
    }
}
