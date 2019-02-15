<?php

namespace App\Http\Controllers\CityGen\Util;

use App\Http\Controllers\CityGen\Services\RandomCity\RandomService;

include __DIR__ . '/../../../../vendor/phpunit/phpunit/src/Framework/Assert/Functions.php';

class TestRandomService extends RandomService
{

    /** @var TestRoll[] */
    private $rolls = null;
    private $rollIndex = 0;

    /**
     * @param null $name
     * @return int
     */
    protected function mtRand($name)
    {
        return $this->nextRoll($name);
    }

    /**
     * @param string $name
     * @param int $min
     * @param int $max
     * @return int
     */
    private function nextRoll($name, $min = null, $max = null)
    {
        if (!$this->rolls || count($this->rolls) === 0) {
//var_dump(debug_backtrace());
            throw new \RuntimeException("\nError: There are no more rolls for '$name' : $min -> $max; Roll Index: {$this->rollIndex}\n");
        }

        $roll = array_shift($this->rolls);
        assertSame($roll->name, $name, "$name ($min->$max); Roll Index: {$this->rollIndex}");
        if ($roll->min !== TestRoll::ANY) {
            assertSame($roll->min, $min, "MIN: $name; Roll Index: {$this->rollIndex}");
        }
        if ($roll->max !== TestRoll::ANY) {
            assertSame($roll->max, $max, "MAX: $name; Roll Index: {$this->rollIndex}");
        }

        // allow random results
        if ($roll->result === TestRoll::RANDOM) {
            if ($roll->min === null || $roll->min === TestRoll::ANY) {
                $result = parent::mtRandRange($name, $min, $max);
            } else {
                $result = parent::mtRand($name);
            }
        } else {
            $result = $roll->result;
        }

        $this->rollIndex++;
        return $result;
    }

    /**
     * do anything random through this method
     * this will allow a test random service class to hijack rolling to provide reproduceable results
     *
     * @param null $name
     * @param null $min
     * @param null $max
     * @return int
     */
    protected function mtRandRange($name, $min, $max)
    {
        return $this->nextRoll($name, $min, $max);
    }

    /**
     * @param TestRoll[] $rolls
     */
    public function setRolls($rolls)
    {
        $this->rolls && assertSame(0, count($this->rolls), 'Previous existing rolls');
        $this->rolls = $rolls;
        $this->rollIndex = 0;
    }

    public function verifyRolls()
    {
        assertSame(0, count($this->rolls), 'all rolls accounted for');
    }
}
