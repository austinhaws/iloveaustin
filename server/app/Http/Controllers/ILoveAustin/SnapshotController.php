<?php

namespace App\Http\Controllers\ILoveAustin;

class SnapshotController extends ControllerBase
{
    public function listSnapshots(\Illuminate\Http\Request $request)
    {
        return $this->services->snapshot->selectSnapshots($request->json()->get('token'));
    }
}
