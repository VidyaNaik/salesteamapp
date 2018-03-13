<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/services/LocationService.php');

$locationService = new LocationService();
$locationType = $_POST["locationType"];

if($locationType == "country") {
    $listOfCountries = $locationService->getAllCountries();
    header('Content-Type: application/json');
    echo json_encode($listOfCountries);
    exit();
}

if($locationType == "state") {
    $countryId = $_POST["countryId"];
    $listOfStates = $locationService->getAllStatesByCountryId($countryId);
    header('Content-Type: application/json');
    echo json_encode($listOfStates);
    exit();
}

if($locationType == "city") {
    $stateId = $_POST["stateId"];
    $listOfCities = $locationService->getAllCitiesByStateId($stateId);
    header('Content-Type: application/json');
    echo json_encode($listOfCities);
    exit();
}

?>