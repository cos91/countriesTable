<?php


class Utils
{
    public static function getCountriesWithEuro($xmlCountriesWithEuro)
    {
        $countriesWithEuroArrayList = [];

        foreach ($xmlCountriesWithEuro as $item) {
            $countriesWithEuroArrayList[] = $item[0];
        }

        return $countriesWithEuroArrayList;
    }

    public static function getArrayOfCountries($xmlCountry, $selectedRegion)
    {


        $arrayOfCountries = self::sortCountries($xmlCountry);


        if ($selectedRegion) {
            $arrayOfCountries = array_filter($arrayOfCountries, function ($var) use ($selectedRegion) {
                return ($var['zone'] == $selectedRegion || $selectedRegion == 'all');
            });
        }

        return $arrayOfCountries;
    }


    private static function sortCountries($arrayOfCountries)
    {

        usort($arrayOfCountries, function ($a, $b): int {
            if ((string)$a['zone'] === (string)$b['zone']) {
                return (string)$a->name <=> (string)$b->name;
            }
            return (string)$a['zone'] <=> (string)$b['zone'];
        });

        return $arrayOfCountries;
    }

}
