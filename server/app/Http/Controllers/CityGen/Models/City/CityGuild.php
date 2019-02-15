<?php

namespace App\Http\Controllers\CityGen\Models\City;

class CityGuild
{
    /** @var string GUILD_TABLE keys */
    public $guild;
    /** @var int */
    public $total;

    /**
     * CityGuild constructor.
     * @param string $guild GUILD_TABLE keys
     * @param int $total
     */
    public function __construct(string $guild, int $total)
    {
        $this->guild = $guild;
        $this->total = $total;
    }
}
