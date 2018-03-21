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
$companyId = $_POST['companyId'];

$affected_rows = $clientService->deleteCompanyByIdCascadeDeleteContacts($companyId);
if($affected_rows == 0) {
    $_SESSION['serverMsg'] = "Company was not deleted!";
    return;
}
$_SESSION['serverMsg'] = "Company and it's associated contact was deleted Successfully!";

?>