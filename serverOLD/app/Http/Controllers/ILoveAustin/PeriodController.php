<?php

namespace App\Http\Controllers\ILoveAustin;

use App\Http\Controllers\ILoveAustin\Models\Period;

class PeriodController extends ControllerBase
{
    const PERIOD = 'period';

    public function getCurrentPeriods()
    {
        return $this->getRequestValue(null, null);
    }

    public function getPeriods($month = null, $year = null)
    {
        return $this->services->period->loadPeriods(new Period($month, $year));
    }

    // public function deleteSnapshot(\Illuminate\Http\Request $request)
    // {
    //     $this->services->snapshot->deleteSnapshot($this->getRequestValue($request, 'snapshotId'), $this->getRequestValue($request, 'token'));
    //     return 'deleted';
    // }
    //
    // public function saveSnapshot(\Illuminate\Http\Request $request)
    // {
    //     $this->services->snapshot->saveSnapshot(new Snapshot($request->json()), $this->getRequestValue($request, ControllerBase::TOKEN));
    //     return 'saved';
    // }
}
