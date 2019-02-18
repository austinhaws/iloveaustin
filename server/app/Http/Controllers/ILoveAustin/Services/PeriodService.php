<?php

namespace App\Http\Controllers\ILoveAustin\Services;

use App\Http\Controllers\ILoveAustin\Models\Period;

class PeriodService extends BaseService
{
    /**
     * @param Period $period
     * @return array
     */
    public function loadPeriods(Period $period)
    {
        $currentPeriod = new Period();
        return [
            'currentPeriod' => $currentPeriod,
            'period' => $period,
            'nextPeriod' => $period->nextPeriod(),
            'lastPeriod' => $period->previousPeriod(),
        ];
    }
}
