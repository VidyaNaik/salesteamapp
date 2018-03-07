<?php
session_start();

include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/services/LocationService.php');

$locationService = new LocationService();
$query = $_POST['query'];
$listOfLocations = null;

if($query == "all-contries") {
    $listOfLocations = $locationService->getAllCountries();
}

if($query == "all-states-of-a-country") {
    $countryId = $_POST["countryId"];
    $listOfLocations = $locationService->getAllStatesByCountryId($countryId);
}

header('Content-Type: application/json');
echo json_encode($listOfLocations);

?>