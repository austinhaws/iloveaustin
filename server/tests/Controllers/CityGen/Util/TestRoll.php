<?php

namespace App\Http\Controllers\ILoveAustin\Util;

class TestRoll
{
    /** @var string  */
    public $name;
    /** @var int|string  */
    public $min;
    /** @var int|string  */
    public $max;
    /** @var int|string  */
    public $result;

    const ANY = 'any';
    const RANDOM = 'random';

    /**
     * TestRoll constructor.
     * @param string $name
     * @param int|string $min
     * @param int|string $max
     * @param int|string $result
     */
    public function __construct(string $name, $result, $min = null, $max = null)
    {
        $this->name = $name;
        $this->result = $result;
        $this->min = $min;
        $this->max = $max;
    }
}
