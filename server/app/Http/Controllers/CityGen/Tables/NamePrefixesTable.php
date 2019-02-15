<?php

namespace App\Http\Controllers\CityGen\Tables;

class NamePrefixesTable extends BaseTable
{
    function getTable()
    {
        return array(
            'anti',
            'dis',
            'pro',
            're',
            'self',
            'un',
        );
    }
}
