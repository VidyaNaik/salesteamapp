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
$userId = $_POST['userId'];

$affected_rows = $bdeService->deleteById($userId);
if($affected_rows == 0) {
    $_SESSION['serverMsg'] = "BDE was not deleted!";
    return;
}
$_SESSION['serverMsg'] = "BDE was deleted Successfully!";

?>