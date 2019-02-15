<?php

namespace App\Http\Controllers\CityGen\Models\Service;

use App\Http\Controllers\CityGen\Constants\Table;
use App\Http\Controllers\CityGen\Constants\Ward;

class RandomWardMetaData
{
    /** @var int[] */
    public $wardCount;
    /** @var array which wards are required to exist */
    public $alreadyDone;
    /** @var float */
    public $acresPerWard;
    /** @var int */
    public $numGates;
    /** @var int how many wards are required to fulfill settings */
    public $requiredWards;
    /** @var int */
    public $acresToFill;

    public function __construct()
    {
        $tableWards = Table::getTable(Table::WARDS)->getTable();

        $this->wardCount = [];
        foreach ($tableWards as $ward) {
            $this->wardCount[$ward] = 0;
        }

        $this->alreadyDone = [
            Ward::ADMINISTRATION => false,
            Ward::CRAFTSMEN => false,
            Ward::GATE => false,
            Ward::MARKET => false,
            Ward::MERCHANT => false,
            Ward::MILITARY => false,
            Ward::ODORIFEROUS => false,
            Ward::PATRICIATE => false,
            Ward::RIVER => false,
            Ward::SEA => false,
            Ward::SHANTY => false,
            Ward::SLUM => false,
        ];
    }
}
