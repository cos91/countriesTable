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

        $arrayOfCountries = self::xmlToArray($xmlCountry);

        $arrayOfCountries = self::sortCountries($arrayOfCountries);


        if ($selectedRegion) {
            $arrayOfCountries = array_filter($arrayOfCountries, function ($var) use ($selectedRegion) {
                return ($var['@attributes']['zone'] == $selectedRegion || $selectedRegion == 'all');
            });
        }

        return $arrayOfCountries;
    }

    private static function xmlToArray($xmlCountry)
    {
        return json_decode(json_encode($xmlCountry), true);
    }

    private static function sortCountries($arrayOfCountries)
    {
        usort($arrayOfCountries, function ($a, $b): int {
            if ($a['@attributes']['zone'] === $b['@attributes']['zone']) {
                return $a['name'][0] <=> $b['name'][0];
            }
            return $a['@attributes']['zone'] <=> $b['@attributes']['zone'];
        });

        return $arrayOfCountries;
    }

}