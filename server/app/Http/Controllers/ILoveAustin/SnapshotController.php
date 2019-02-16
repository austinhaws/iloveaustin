<?php

namespace App\Http\Controllers\ILoveAustin;

use App\Http\Controllers\ILoveAustin\Models\Snapshot;

class SnapshotController extends ControllerBase
{
    public function listSnapshots(\Illuminate\Http\Request $request)
    {
        return $this->services->snapshot->selectSnapshots($this->getRequestValue($request, ControllerBase::TOKEN));
    }

    public function deleteSnapshot(\Illuminate\Http\Request $request)
    {
        $this->services->snapshot->deleteSnapshot($this->getRequestValue($request, 'snapshotId'), $this->getRequestValue($request, 'token'));
        return 'deleted';
    }

    public function saveSnapshot(\Illuminate\Http\Request $request)
    {
        $this->services->snapshot->saveSnapshot(new Snapshot($request->json()), $this->getRequestValue($request, ControllerBase::TOKEN));
        return 'saved';
    }
}
