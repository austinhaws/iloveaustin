<?php

namespace App\Http\Controllers\CityGen\Services;

use App\Http\Controllers\CityGen\Models\Post\PostData;
use App\Http\Controllers\CityGen\Models\Post\PostRaceRatio;

class PostDataService extends BaseService
{
    /**
     * @param array $post
     * @return PostData
     */
    public function createPostData(array $post)
    {
        $postData = new PostData();

        if ($post) {
            $postData->populationType = isset($post['populationType']) ? $post['populationType'] : null;
            $postData->hasSea = $this->services->random->randomBoolean($post, 'sea');
            $postData->hasMilitary = $this->services->random->randomBoolean($post, 'military');
            $postData->hasRiver = $this->services->random->randomBoolean($post, 'river');
            $postData->hasGates = $this->services->random->randomBoolean($post, 'gates');
            $postData->generateBuildings = $this->services->random->randomBoolean($post, 'buildings');
            $postData->racialMix = isset($post['racialMix']) ? $post['racialMix'] : [];
            if (isset($post['raceRatios'])) {
                $postData->raceRatio = array_map(function ($ratio) {
                    return new PostRaceRatio($ratio['race'], floatval($ratio['ratio']) / 100.0);
                }, $post['raceRatios']);
            }
        }

        return $postData;
    }
}
