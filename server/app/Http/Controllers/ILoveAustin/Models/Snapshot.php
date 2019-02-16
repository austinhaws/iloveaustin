<?php

namespace App\Http\Controllers\ILoveAustin\Models;

class Snapshot
{
    /** @var int */
    public $id;
    /** @var int */
    public $accountId;
    /** @var string */
    public $name;
    /** @var string */
    public $notes;
    /** @var int */
    public $goal;
    /** @var int */
    public $current;
    /** @var int */
    public $isTotalable;

    public function __construct(\Symfony\Component\HttpFoundation\ParameterBag $json)
    {
        $this->id = $json->get('id');
        $this->accountId = $json->get('account_id');
        $this->name = $json->get('name');
        $this->notes = $json->get('notes');
        $this->goal = $json->get('amt_goal');
        $this->current = $json->get('amt_current');
        $this->isTotalable = $json->get('is_totalable');
    }

}
