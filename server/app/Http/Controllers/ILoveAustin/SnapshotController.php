<?php

namespace App\Http\Controllers\ILoveAustin;

class SnapshotController extends ControllerBase
{
    public function listSnapshots(\Illuminate\Http\Request $request)
    {
        return $this->services->snapshot->selectSnapshots($this->getRequestValue($request, 'token'));
    }

    public function deleteSnapshot(\Illuminate\Http\Request $request)
    {
        $this->services->snapshot->deleteSnapshot($this->getRequestValue($request, 'token'), $this->getRequestValue($request, 'snapshotId'));
        return 'deleted';
    }
}
