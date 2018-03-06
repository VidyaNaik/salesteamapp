<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/services/BdeService.php');

$bdeService = new BdeService();
$bdeId = $_POST['bdeId'];

$bdeService->unassignBde($bdeId);
$_SESSION['serverMsg'] = "BDE Was Unassigned Successfully!";

?>