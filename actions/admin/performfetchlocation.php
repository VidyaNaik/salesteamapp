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
    header('Content-Type: application/json');
    $listOfCountries = $locationService->getAllCountries();
    echo json_encode($listOfCountries);
    exit();
}

if($locationType == "state") {
    $countryId = $_POST["countryId"];
    header('Content-Type: application/json');
    $listOfStates = $locationService->getAllStatesByCountryId($countryId);
    echo json_encode($listOfStates);
    exit();
}

?>