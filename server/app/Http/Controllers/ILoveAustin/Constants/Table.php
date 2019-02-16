<?php

namespace App\Http\Controllers\ILoveAustin\Constants;

use App\Http\Controllers\ILoveAustin\Tables\BaseTable;

class Table extends BaseEnum
{
    const BUILDINGS = 'BuildingsTable';
    const BUILDINGS_SUBTYPES = 'BuildingSubTypesTable';
    const COMMODITIES = 'CommoditiesTable';
    const COMMODITY_COUNT = 'CommodityCountTable';
    const FAMOUS = 'FamousTable';
    const FAMOUS_OCCURRENCE = 'FamousOccurrenceTable';
    const GUILD_MODIFIERS = 'GuildModifiersTable';
    const GUILDS = 'GuildsTable';
    const INTEGRATION = 'IntegrationTable';
    const IS_CITY_SIZE_AT_LEAST = 'IsCitySizeAtLeastTable';
    const KING_INCOME = 'KingIncomeTable';
    const MAGIC_RESOURCES = 'MagicResourcesTable';
    const NAME_NUM_SYLLABLES = 'NameNumSyllablesTable';
    const NAME_NUM_WORDS = 'NameNumWordsTable';
    const NAME_PREFIXES = 'NamePrefixesTable';
    const NAME_SUFFIXES = 'NameSuffixesTable';
    const NAME_WORDS = 'NameWordsTable';
    const NAME_WORDS_COUNT = 'NameWordsCountTable';
    const NPC_CLASS_INFLUENCE = 'NPCClassInfluenceTable';
    const NPC_CLASS_RANDOM_CLASS = 'NPCClassRandomClassTable';
    const NPC_CLASSES_MAX_LEVEL = 'NPCClassesMaxLevelTable';
    const NPC_LEVEL_MODIFIERS = 'NPCLevelModifierTable';
    const POPULATION_ACRES = 'PopulationAcresTable';
    const POPULATION_CENTER_UNABSORBED = 'PopulationCenterUnabsorbedTable';
    const POPULATION_HAS_WALLS = 'PopulationHasWallsTable';
    const POPULATION_INFLUENCE_POINTS = 'PopulationInfluencePointsTable';
    const POPULATION_MILITARY = 'PopulationMilitaryTable';
    const POPULATION_NUM_STRUCTURES = 'PopulationNumStructuresTable';
    const POPULATION_NUM_WALLS = 'PopulationNumWallsTable';
    const POPULATION_POWER_CENTER = 'PopulationPowerCenterTable';
    const POPULATION_POWER_CENTER_MODIFIER = 'PopulationPowerCenterModifierTable';
    const POPULATION_SIZE = 'PopulationSizeTable';
    const POPULATION_TYPE = 'PopulationTypeTable';
    const POPULATION_WARD_DENSITY = 'PopulationWardDensityTable';
    const POPULATION_WEALTH = 'PopulationWealthTable';
    const POWER_CENTER_ALIGNMENT = 'PowerCenterAlignmentTable';
    const POWER_CENTER_TYPE = 'PowerCenterTypeTable';
    const PROFESSION = 'ProfessionTable';
    const PROFESSION_RATIO = 'ProfessionRatioTable';
    const RACES = 'RaceTable';
    const RACES_PERCENTS = 'RacePercentsTable';
    const RACES_RANDOM = 'RacesRandomTable';
    const SYLLABLES = 'SyllablesTable';
    const WARD_ACRES_USED = 'WardAcresUsedTable';
    const WARDS = 'WardsTable';

    private static $tables = [];

    /**
     * @param string $tableName
     * @return BaseTable
     */
    static public function getTable(string $tableName) {

        if (isset(Table::$tables[$tableName])) {
            $table = Table::$tables[$tableName];
        } else {
            $pathName = "App\Http\Controllers\CityGen\Tables\\$tableName";
            $table = new $pathName();
            Table::$tables[$tableName] = $table;
        }

        return $table;
    }
}
