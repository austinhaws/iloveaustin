<?php

namespace App\Http\Controllers\CityGen\Tables;

class NameSuffixesTable extends BaseTable
{
    function getTable()
    {
        return array(
            'ist',
            'er',
            'or',
            'ant',
            'ment',
            'age',
            'tion',
            'sion',
            'ing',
            'ful',
            'al',
            'ive',
            'ing',
            'ness',
        );
    }
}
