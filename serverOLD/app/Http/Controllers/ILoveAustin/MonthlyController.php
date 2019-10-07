<?php

namespace App\Http\Controllers\ILoveAustin;

class MonthlyController extends ControllerBase
{
    const PERIOD = 'period';

    public function listMonthlies(\Illuminate\Http\Request $request)
    {
        return $this->services->monthly->selectMonthlies($this->getRequestValue($request, ControllerBase::TOKEN), $this->getRequestValue($request, MonthlyController::PERIOD));
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
