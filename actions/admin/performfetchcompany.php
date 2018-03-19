<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../views/error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/services/ClientService.php');

$clientService = new ClientService();
$companyId = $_POST['companyId'];
$company = $clientService->getCompanyById($companyId);
header('Content-Type: application/json');
echo json_encode($company);


?>