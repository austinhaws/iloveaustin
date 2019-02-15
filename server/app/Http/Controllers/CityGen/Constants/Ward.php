<?php

namespace App\Http\Controllers\CityGen\Constants;

use http\Exception\RuntimeException;

class Ward extends BaseEnum
{
    const ADMINISTRATION = 'Administration';
    const CRAFTSMEN = 'Craftsmen';
    const GATE = 'Gate';
    const MARKET = 'Market';
    const MERCHANT = 'Merchant';
    const MILITARY = 'Military';
    const ODORIFEROUS = 'Odoriferous';
    const PATRICIATE = 'Patriciate';
    const RIVER = 'River';
    const SEA = 'Sea';
    const SHANTY = 'Shanty';
    const SLUM = 'Slum';

    /**
     * @param string $ward
     *
     * @return array
     */
    public static function buildingsForWard(string $ward)
    {
        $buildings = null;

        switch ($ward) {
            case Ward::ADMINISTRATION:
                $buildings = [
                    Building::ADMIN,
                    Building::ASYLUM,
                    Building::BATH_HOUSE,
                    Building::BATH,
                    Building::CEMETERY,
                    Building::CISTERN,
                    Building::FOUNTAIN,
                    Building::GRAINERY,
                    Building::GUILD_HALL,
                    Building::HOSPITAL,
                    Building::HOUSE,
                    Building::INN,
                    Building::LIBRARY,
                    Building::OFFICE,
                    Building::PLAZA,
                    Building::PRISON,
                    Building::RELIGIOUS,
                    Building::SHOP,
                    Building::STABLE,
                    Building::TAVERN,
                    Building::WAREHOUSE,
                    Building::WELL,
                    Building::WORKSHOP,
                ];
                break;

            case Ward::CRAFTSMEN:
                $buildings = [
                    Building::ADMIN,
                    Building::BATH_HOUSE,
                    Building::BATH,
                    Building::CISTERN,
                    Building::FOUNTAIN,
                    Building::GUILD_HALL,
                    Building::HOSPITAL,
                    Building::HOUSE,
                    Building::RELIGIOUS,
                    Building::SHOP,
                    Building::TAVERN,
                    Building::TENEMENT,
                    Building::THEATER,
                    Building::WAREHOUSE,
                    Building::WELL,
                    Building::WORKSHOP,
                ];
                break;

            case Ward::GATE:
                $buildings = [
                    Building::ADMIN,
                    Building::BATH_HOUSE,
                    Building::BATH,
                    Building::CORRAL,
                    Building::FOUNTAIN,
                    Building::HOSPITAL,
                    Building::HOUSE,
                    Building::INN,
                    Building::OFFICE,
                    Building::RELIGIOUS,
                    Building::SHOP,
                    Building::STABLE,
                    Building::TAVERN,
                    Building::WAREHOUSE,
                    Building::WELL,
                    Building::WORKSHOP,
                ];
                break;

            case Ward::MARKET:
                $buildings = [
                    Building::ADMIN,
                    Building::BATH,
                    Building::CISTERN,
                    Building::FOUNTAIN,
                    Building::GRAINERY,
                    Building::GUILD_HALL,
                    Building::HOUSE,
                    Building::INN,
                    Building::OFFICE,
                    Building::PLAZA,
                    Building::RELIGIOUS,
                    Building::SHOP,
                    Building::STABLE,
                    Building::TAVERN,
                    Building::WAREHOUSE,
                    Building::WELL,
                ];
                break;

            case Ward::MERCHANT:
                $buildings = [
                    Building::ADMIN,
                    Building::BATH_HOUSE,
                    Building::BATH,
                    Building::CEMETERY,
                    Building::CISTERN,
                    Building::FOUNTAIN,
                    Building::GARDEN,
                    Building::GRAINERY,
                    Building::GUILD_HALL,
                    Building::HOSPITAL,
                    Building::HOUSE,
                    Building::INN,
                    Building::LIBRARY,
                    Building::OFFICE,
                    Building::PLAZA,
                    Building::RELIGIOUS,
                    Building::REST,
                    Building::SHOP,
                    Building::STABLE,
                    Building::TAVERN,
                    Building::UNIVERSITY,
                    Building::WAREHOUSE,
                    Building::WELL,
                    Building::WORKSHOP,
                ];
                break;

            case Ward::MILITARY:
                $buildings = [
                    Building::ADMIN,
                    Building::BARRACK,
                    Building::BATH,
                    Building::COLISEUM,
                    Building::CORRAL,
                    Building::FOUNTAIN,
                    Building::GRAINERY,
                    Building::HOUSE,
                    Building::INFIRMARY,
                    Building::PRISON,
                    Building::RELIGIOUS,
                    Building::SHOP,
                    Building::STABLE,
                    Building::TAVERN,
                    Building::WAREHOUSE,
                    Building::WELL,
                    Building::WORKSHOP,
                ];
                break;

            case Ward::ODORIFEROUS:
                $buildings = [
                    Building::ADMIN,
                    Building::BATH,
                    Building::CEMETERY,
                    Building::CORRAL,
                    Building::FOUNTAIN,
                    Building::HOSPITAL,
                    Building::HOUSE,
                    Building::INN,
                    Building::RELIGIOUS,
                    Building::SHOP,
                    Building::TAVERN,
                    Building::TENEMENT,
                    Building::WAREHOUSE,
                    Building::WELL,
                    Building::WORKSHOP,
                ];
                break;

            case Ward::PATRICIATE:
                $buildings = [
                    Building::ADMIN,
                    Building::BATH_HOUSE,
                    Building::BATH,
                    Building::CEMETERY,
                    Building::CISTERN,
                    Building::FOUNTAIN,
                    Building::GARDEN,
                    Building::GRAINERY,
                    Building::HOSPITAL,
                    Building::HOUSE,
                    Building::INN,
                    Building::LIBRARY,
                    Building::OFFICE,
                    Building::PLAZA,
                    Building::RELIGIOUS,
                    Building::RESTAURANT,
                    Building::SHOP,
                    Building::STABLE,
                    Building::TAVERN,
                    Building::UNIVERSITY,
                    Building::WAREHOUSE,
                    Building::WELL,
                ];
                break;

            case Ward::RIVER:
            case Ward::SEA:
                $buildings = [
                    Building::ADMIN,
                    Building::BATH_HOUSE,
                    Building::BATH,
                    Building::CORRAL,
                    Building::FOUNTAIN,
                    Building::GRAINERY,
                    Building::HOUSE,
                    Building::INN,
                    Building::MILL,
                    Building::OFFICE,
                    Building::RELIGIOUS,
                    Building::SHOP,
                    Building::TENEMENT,
                    Building::WELL,
                    Building::WORKSHOP,
                ];
                break;

            case Ward::SHANTY:
                $buildings = [
                    Building::FOUNTAIN,
                    Building::HOUSE,
                    Building::TAVERN,
                    Building::WELL,
                    Building::WORKSHOP,
                ];
                break;

            case Ward::SLUM:
                $buildings = [
                    Building::ADMIN,
                    Building::BATH,
                    Building::CEMETERY,
                    Building::FOUNTAIN,
                    Building::HOSPITAL,
                    Building::HOUSE,
                    Building::INN,
                    Building::RELIGIOUS,
                    Building::SHOP,
                    Building::TAVERN,
                    Building::TENEMENT,
                    Building::WAREHOUSE,
                    Building::WELL,
                    Building::WORKSHOP,
                ];
                break;

            default:
                throw new RuntimeException('Unknown Ward: ' . $ward);
        }

        return $buildings;
    }
}
