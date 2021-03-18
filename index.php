<?php
include('utils.php');

const LATITUDE_PATTERN = '/@(\-?[0-9]+\.[0-9]+)/';
const LONGITUDE_PATTERN = '/,(\-?[0-9]+\.[0-9]+)/';

const REGION_FILTERS = [
    'all' => 'Choose',
    'western' => 'Western',
    'central' => 'Central',
    'eastern' => 'Eastern',
];

$selectedRegion = null;

if (isset($_GET['region'])) {
    $selectedRegion = $_GET['region'];
}

if (file_exists('countries.xml')) {
    $xml = simplexml_load_file('countries.xml');
    $xmlCountry = $xml->xpath('country');
    $xmlCountriesWithEuro = $xml->xpath('//country/currency[@code = "EUR"]/../name');

} else {
    exit('Failed to open countries.xml.');
}


$arrayOfCountries = Utils::getArrayOfCountries($xmlCountry, $selectedRegion);

$countriesWithEuroArrayList = Utils::getCountriesWithEuro($xmlCountriesWithEuro);


?>

<?php
include('header.php');
?>

<form action="" method="get">
    <select name="region" onchange="submit()">


        <?php
        foreach (REGION_FILTERS as $key => $value) { ?>
            <option <?php if ($key === $selectedRegion || $selectedRegion === null && $key === 'all') { ?> selected <?php } ?>
                    value="<?= $key ?>"><?= $value ?></option>
        <?php }
        ?>


    </select>


</form>

<div class="divTable" style="border: 2px solid #000;">
    <div class="divTableBody">
        <div class="divTableRow">
            <div class="divTableCell">Regiune</div>
            <div class="divTableCell">Țară</div>
            <div class="divTableCell">Limbă</div>
            <div class="divTableCell">Monedă</div>
            <div class="divTableCell">Latitudine</div>
            <div class="divTableCell">Longitudine</div>
        </div>

        <?php foreach ($arrayOfCountries as $country) { ?>
            <div class="divTableRow">
                <div class="divTableCell"><?= $country['@attributes']['zone'] ?></div>
                <div class="divTableCell"><?= $country['name'][0] ?> (<?= $country['name']['@attributes']['native'] ?>
                    )
                </div>
                <div class="divTableCell"><?= $country['language'][0] ?>
                    (<?= $country['language']['@attributes']['native'] ?>)
                </div>
                <div class="divTableCell"><?= $country['currency'][0] ?>
                    (<?= $country['currency']['@attributes']['code'] ?>)
                </div>
                <div class="divTableCell"><?php preg_match(LATITUDE_PATTERN, $country['map_url'], $match);
                    echo $match[1]; ?></div>
                <div class="divTableCell"><?php preg_match(LONGITUDE_PATTERN, $country['map_url'], $match);
                    echo $match[1]; ?></div>
            </div>
        <?php } ?>
    </div>
    <div class="divTableFoot">
        <h3>Tari care au adoptat moneda euro : <?= implode(', ', $countriesWithEuroArrayList) ?></h3>
    </div>
</div>
</body>
</html>