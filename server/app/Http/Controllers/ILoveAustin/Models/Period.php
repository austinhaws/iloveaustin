<?php

namespace App\Http\Controllers\ILoveAustin\Models;

class Period
{
    /** @var int */
    public $month;
    /** @var int */
    public $year;

    public function __construct($month = null, $year = null)
    {
        // get current date if bad month or year
        if (!$month || !$year || $month <= 0 || $month >= 13 || strlen($year) != 4) {
            date_default_timezone_set('America/Denver');
            list($month, $year) = explode('/', date('m/Y', time()));
        }

        $this->month = intval($month);
        $this->year = intval($year);
    }

    public function previousPeriod() {
        return new Period(
            $this->month === 1 ? 12 : $this->month - 1,
            $this->month === 1 ? $this->year - 1 : $this->year
        );
    }

    public function nextPeriod() {
        return new Period(
            $this->month === 12 ? 1 : $this->month + 1,
            $this->month === 12 ? $this->year + 1 : $this->year
        );
    }
}
