<?php
session_start();
if(!isset($_SESSION["email"])) {
    header("Location:../login.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/services/ClientService.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/models/Company.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/models/Contact.php');

$clientService = new ClientService();
$company = new Company();
$contacts = array();

$companyName = $_POST["companyName"];
$companyWebsite = $_POST["companyWebsite"];
$companyAddress = $_POST["companyAddress"];
$companyPhone = $_POST["companyPhone"];
$companyEmail = $_POST["companyEmail"];
$companyLinkedIn = $_POST["companyLinkedIn"];
$clientTotalContacts = $_POST["clientTotalContacts"];
setCompanyDetails();

if(validateDetails($company)) {
    global $clientTotalContacts;
    if($clientService->checkWebsite($companyWebsite)) {
        $max_client_company_id = $clientService->saveCompany($company);
        if($clientTotalContacts > 0) {
            setContactDetails($max_client_company_id); 
            saveContactDetails();
        }
        $_SESSION['serverMsg'] = "Client Added Successfully!";
        header("Location:../../views/user/clientlist.php");
    } else {
        $_SESSION['serverMsg'] = "Client With This Website Is Already Uploaded";
        header("Location:../../views/user/admin/addclient.php");
    }
} else {
    header("Location:../../views/user/admin/addclient.php");
}

/**
 * Company Ops
 */
function setCompanyDetails() {
    global $company;
    $company->setName($GLOBALS['companyName']);
    $company->setWebsite($GLOBALS['companyWebsite']);
    $company->setAddress($GLOBALS['companyAddress']);
    $company->setPhone($GLOBALS['companyPhone']);
    $company->setEmail($GLOBALS['companyEmail']);
    $company->setLinkedin($GLOBALS['companyLinkedIn']);
}

function validateDetails($company) {
    if($company->getName() == "" || $company->getWebsite() == "" || 
        $company->getAddress() == "" || $company->getPhone() == "" || 
            $company->getEmail() == "" || $company->getLinkedIn() == "") {
        $_SESSION['serverMsg'] = "One Or More Fields Are Blank!";
        return false;
    } else if((strrpos($company->getName()," ") !== false) || (strrpos($company->getWebsite()," ") !== false) || 
        (strrpos($company->getAddress()," ") !== false) || (strrpos($company->getPhone()," ") !== false) ||
        (strrpos($company->getEmail()," ") !== false) || (strrpos($company->getLinkedIn()," ") !== false)) {
        $_SESSION['serverMsg'] = "Whitespaces Are Not Allowed!";
        return false;
    }
    return true;
}

/**
 * Contact Ops
 */
function setContactDetails($client_company_id) {
    global $clientTotalContacts, $contacts;
    for($i = 1; $i <= $clientTotalContacts; $i++) {
        $contact = new Contact();
        $contact->setFirstName($_POST['contact_form_'.$i.'_firstName']);
        $contact->setLastName($_POST['contact_form_'.$i.'_lastName']);
        $contact->setEmail($_POST['contact_form_'.$i.'_email']);
        $contact->setCategory($_POST['contact_form_'.$i.'_category']);
        $contact->setDesignation($_POST['contact_form_'.$i.'_designation']);
        $contact->setMobile($_POST['contact_form_'.$i.'_mobile']);
        $contact->setCountry($_POST['contact_form_'.$i.'_country']);
        $contact->setState($_POST['contact_form_'.$i.'_state']);
        $contact->setCity($_POST['contact_form_'.$i.'_city']);
        $contact->setAddress($_POST['contact_form_'.$i.'_address']);
        $contact->setLinkedIn($_POST['contact_form_'.$i.'_linkedin']);
        $contact->setFacebook($_POST['contact_form_'.$i.'_facebook']);
        $contact->setTwitter($_POST['contact_form_'.$i.'_twitter']);
        $contact->setStatus("NEW");
        $contact->setAdded(date("Y-m-d H:i:s"));
        $contact->setCompany($client_company_id);
        array_push($contacts, $contact);
    }
}

function saveContactDetails() {
    global $contacts;
}

?>