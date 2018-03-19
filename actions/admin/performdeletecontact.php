<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/services/ClientService.php');

$clientService = new ClientService();
$contactId = $_POST['contactId'];

$affected_rows = $clientService->deleteContactById($contactId);
if($affected_rows == 0) {
    $_SESSION['serverMsg'] = "Contact was not deleted!";
    return;
}
$_SESSION['serverMsg'] = "Contact was deleted Successfully!";

?>