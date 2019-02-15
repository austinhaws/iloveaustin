<?php

namespace App\Http\Controllers\CityGen\Tables;

use App\Http\Controllers\CityGen\Constants\Profession;

class GuildsTable extends BaseTable
{
    function getTable()
    {
        return array(
            'Architects & Engineers' => array(
                Profession::ARCHITECTS,
                Profession::ENGINEERS,
            ),
            'Armorers & Locksmiths' => array(
                Profession::ARMORERS,
                Profession::LOCKSMITHS,
            ),
            'Artists' => array(
                Profession::ARTISTS,
                Profession::PAINTERS,
                Profession::SATIRISTS,
                Profession::SCULPTORS,
                Profession::WRITERS,
            ),
            'Bakers' => array(
                Profession::BAKERS,
                Profession::PASTRY_MAKERS,
            ),
            'Bookbinders & Paper Makers' => array(
                Profession::BOOKBINDERS,
                Profession::BOOKSELLERS,
                Profession::PAPER_PARCHMENT_MAKERS,
            ),
            'Bowyers & Fletchers' => array(
                Profession::BOWYER_FLETCHERS,
            ),
            'Brewers, Distillers, & Vintners' => array(
                Profession::BREWERS,
                Profession::DISTILLERS,
                Profession::VINTNER,
            ),
            'Brothel Keepers' => array(
                Profession::BATHERS,
                Profession::BROTHEL_KEEPERS,
            ),
            'Builders' => array(
                Profession::CARPENTERS,
                Profession::PLASTERERS,
                Profession::ROOFERS,
            ),
            'Butchers' => array(
                Profession::BUTCHERS,
            ),
            'Casters' => array(
                Profession::BELL_MAKERS,
                Profession::ENGRAVERS,
                Profession::GOLDSMITHS,
                Profession::SILVERSMITHS,
            ),
            'Chandliers' => array(
                Profession::CHANDLERS,
                Profession::SOAP_MAKERS,
            ),
            'Clay & Stone Workers' => array(
                Profession::BRICKLAYERS,
                Profession::MASONS,
                Profession::POTTERS,
                Profession::TILERS,
            ),
            'Clerks & Scribes' => array(
                Profession::COPYISTS,
                Profession::ILLUMINATORS,
            ),
            'Clothing & Accessories' => array(
                Profession::GIRDLERS,
                Profession::GLOVE_MAKERS,
                Profession::MERCERS,
                Profession::PERFUMER,
                Profession::PURSE_MAKERS,
                Profession::TAILORS,
                Profession::VESTMENT_MAKERS,
            ),
            'Cobblers' => array(
                Profession::COBBLERS,
            ),
            'Coopers' => array(
                Profession::COOPERS,
            ),
            'Cordwainers' => array(
                Profession::LEATHER_WORKERS,
            ),
            'Dyers & Weavers' => array(
                Profession::BLEACHERS,
                Profession::DRAPERS,
                Profession::DYE_MAKERS,
                Profession::FULLERS,
                Profession::RUG_MAKERS,
                Profession::WEAVERS,
            ),
            'Financial Transactions' => array(
                Profession::BANKERS,
                Profession::MONEYCHANGERS,
                Profession::PAWNBROKER,
                Profession::TAX_COLLECTORS,
            ),
            'Fishmongers' => array(
                Profession::FISHERS,
                Profession::FISHMONGERS,
            ),
            'Forgers & Smiths' => array(
                Profession::BLACKSMITHS,
                Profession::BUCKLE_MAKERS,
                Profession::CUTLERS,
                Profession::SCABBARD_MAKERS,
                Profession::WEAPON_SMITHS,
            ),
            'Furriers' => array(
                Profession::FURRIERS,
            ),
            'Glass Workers' => array(
                Profession::GLASS_MAKERS,
                Profession::GLAZIERS,
            ),
            'Harness Makers & Saddlers' => array(
                Profession::HARNESS_MAKERS,
                Profession::SADDLERS_SPURRIERS,
            ),
            'Hostliers' => array(
                Profession::INN_KEEPERS,
                Profession::RESTAURANTIERS,
                Profession::TAVERN_KEEPERS,
            ),
            'Jewelers' => array(
                Profession::GOLDSMITHS,
                Profession::JEWELERS,
                Profession::SILVERSMITHS,
            ),
            'Launderers' => array(
                Profession::LAUNDERERS,
            ),
            'Magic' => array(
                Profession::ALCHEMISTS,
                Profession::ASTROLOGERS,
                Profession::MAGIC_MERCHANTS,
                Profession::POTION_MAKERS,
            ),
            'Map Makers & Surveyors' => array(
                Profession::CARTOGRAPHERS,
            ),
            'Mariners' => array(
                Profession::NAVIGATORS_PATHFINDERS,
                Profession::NAVEL_OUTFITTERS,
                Profession::ROPE_MAKERS,
            ),
            'Medical' => array(
                Profession::BARBERS,
                Profession::DENTISTS,
                Profession::DOCTORS_UNLICENSED,
                Profession::HERBALISTS,
                Profession::MIDWIVES,
            ),
            'Merchants' => array(
                Profession::BEER_MERCHANTS,
                Profession::BOOKSELLERS,
                Profession::CLOTHIERS_USED,
                Profession::DAIRY_SELLERS,
                Profession::FLOWER_SELLERS,
                Profession::GRAIN_MERCHANTS,
                Profession::GROCERS,
                Profession::HABERDASHERS,
                Profession::HAY_MERCHANTS,
                Profession::LIVESTOCK_MERCHANTS,
                Profession::MAGIC_MERCHANTS,
                Profession::MILLERS,
                Profession::PERFUMER,
                Profession::RELIGIOUS_SOUVENIR_SELLERS,
                Profession::SLAVERS,
                Profession::SPICE_MERCHANTS,
                Profession::TOBACCO_MERCHANTS,
                Profession::WINE_MERCHANTS,
                Profession::WOOD_SELLERS,
                Profession::WOOL_MERCHANTS,
            ),
            'Music & Performers' => array(
                Profession::ACROBATS_TUMBLERS,
                Profession::INSTRUMENT_MAKERS,
                Profession::JESTERS,
                Profession::JONGLEURS,
                Profession::MINSTRELS,
                Profession::STORYTELLERS,
            ),
            'Professional Guilds' => array(
                Profession::ADVOCATES_LAWYERS,
                Profession::DOCTORS_LICENSED,
                Profession::JUDGES,
                Profession::LIBRARIANS,
                Profession::PROFESSORS,
                Profession::TEACHERS,
            ),
            'Scholastic' => array(
                Profession::HISTORIANS,
                Profession::PROFESSORS,
                Profession::SAGE_SCHOLAR,
            ),
            'Shipwrights' => array(
                Profession::SHIP_MAKERS,
            ),
            'Skinners & Tanners' => array(
                Profession::LEATHER_WORKERS,
                Profession::SKINNERS,
                Profession::TANNERS,
                Profession::TAXIDERMISTS,
            ),
            'Stable Keepers' => array(
                Profession::GROOMS,
            ),
            'Tinkerers' => array(
                Profession::CLOCK_MAKERS,
                Profession::INVENTORS,
                Profession::TOY_MAKERS,
            ),
            'Water Men' => array(
                Profession::WATER_CARRIERS,
            ),
            'Wheel Wrights' => array(
                Profession::WHEELWRIGHTS,
            ),
            'Wicker Workers' => array(
                Profession::BASKET_MAKERS,
                Profession::FURNITURE_MAKERS,
            ),
            'Wood Workers' => array(
                Profession::FURNITURE_MAKERS,
                Profession::WOODCARVERS,
            ),
        );
    }
}
