<?php

namespace App\Http\Controllers\CityGen;

use App\Http\Controllers\CityGen\Services\ListsService;
use Laravel\Lumen\Routing\Controller as BaseController;

class CityGenController extends BaseController
{
	private $listsService;

	public function __construct(ListsService $listsService)
	{
		$this->listsService = $listsService;
	}

	public function getLists() {
		return $this->listsService->getLists();
    }

    public function generate(\Illuminate\Http\Request $request) {
var_dump($request->json()->all());
	    return 'got it';
    }
}
