<?php

namespace Test\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\BooleanRandom;
use App\Http\Controllers\CityGen\Constants\Integration;
use App\Http\Controllers\CityGen\Constants\PopulationType;
use App\Http\Controllers\CityGen\Constants\Race;
use Test\Controllers\CityGen\Util\BaseTestCase;

final class PostDataServiceTest extends BaseTestCase
{

    public function testCreatePostData()
    {
        $postData = $this->services->postData->createPostData([
            'populationType' => PopulationType::LARGE_CITY,
            'sea' => BooleanRandom::TRUE,
            'military' => BooleanRandom::FALSE,
            'river' => BooleanRandom::RANDOM,
            'gates' => null,
        ]);

        $this->assertSame(BooleanRandom::TRUE, $postData->hasSea);
        $this->assertSame(BooleanRandom::FALSE, $postData->hasMilitary);
        $this->assertSame(BooleanRandom::RANDOM, $postData->hasRiver);
        $this->assertSame(BooleanRandom::RANDOM, $postData->hasGates);
    }

    public function testCreatePostData_BooleanRandom()
    {
        $postData = $this->services->postData->createPostData([
            'sea' => BooleanRandom::TRUE,
            'river' => BooleanRandom::RANDOM,
            'gates' => 'somethingunknown',
        ]);

        $this->assertSame(BooleanRandom::TRUE, $postData->hasSea);
        $this->assertSame(BooleanRandom::RANDOM, $postData->hasMilitary);
        $this->assertSame(BooleanRandom::RANDOM, $postData->hasRiver);
        $this->assertSame(BooleanRandom::RANDOM, $postData->hasGates);
    }

    public function testRaceRatios()
    {
        $postData = $this->services->postData->createPostData([
            'racialMix' => Integration::INTEGRATED,
            'raceRatios' => [
                ['race' => Race::DWARF, 'ratio' => 45.2],
                ['race' => Race::HUMAN, 'ratio' => 31.1],
            ]
        ]);

        $this->assertSame(Integration::INTEGRATED, $postData->racialMix);
        $this->assertSame(2, count($postData->raceRatio));
        $this->assertSame(Race::DWARF, $postData->raceRatio[0]->race);
        $this->assertSame(.452, $postData->raceRatio[0]->ratio);
        $this->assertSame(Race::HUMAN, $postData->raceRatio[1]->race);
        $this->assertSame(.311, $postData->raceRatio[1]->ratio);
    }
}
