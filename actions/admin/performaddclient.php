<?php
session_start();
if(!isset($_SESSION["email"])) {
    header("Location:../login.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/services/ClientService.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/models/Company.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/models/Contact.php');

$clientService = new ClientService();
$company = new Company();
$contacts = array();
$errContacts= array();

$companyName = $_POST["companyName"];
$companyWebsite = $_POST["companyWebsite"];
$companyAddress = $_POST["companyAddress"];
$companyPhone = $_POST["companyPhone"];
$companyEmail = $_POST["companyEmail"];
$companyLinkedIn = $_POST["companyLinkedIn"];
$clientTotalContacts = $_POST["clientTotalContacts"];
setCompanyDetails();

if(validateCompanyDetails()) {
    global $clientTotalContacts;
    if($clientService->checkCompanyWebsite($companyWebsite)) {
        $max_client_company_id = $clientService->saveCompany($company);
        if($clientTotalContacts > 0) {
            setContactDetails($max_client_company_id); 
            saveContactDetails();
            if(count($errContacts) > 0) {
                $_SESSION['serverMsg'] = "Client Added Successfully But Some Contacts Were Not Added!";
                $_SESSION['serverData'] = $errContacts;
                header("Location:../../views/user/admin/failedcontacts.php");
                exit;
            }
        }
        $_SESSION['serverMsg'] = "Client Added Successfully!";
        header("Location:../../views/user/admin/clientlist.php");
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

function validateCompanyDetails() {
    global $company;
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
        $contact->setCompany($client_company_id);
        array_push($contacts, $contact);
    }
}

function saveContactDetails() {
    global $clientTotalContacts, $contacts, $errContacts, $clientService;
    for($i = 0; $i < $clientTotalContacts; $i++) {
        $contactValidityStatus = validateContactDetails($contacts[$i]);
        if($contactValidityStatus === true) {
            if($clientService->checkContactEmail($contacts[$i]->getEmail())) {
                $clientService->saveContact($contacts[$i]);
            } else {
                array_push($errContacts, array("errContact"=>$contacts[$i], "errMsg"=>ERR_CONTACT_EXISTS));
            }
        } else {
            array_push($errContacts, array("errContact"=>$contacts[$i], "errMsg"=>$contactValidityStatus));
        }   
    }
}

function validateContactDetails($contact) {
    if($contact->getFirstName() == "" || $contact->getLastName() == "" || $contact->getEmail() == "" || 
        $contact->getCategory() == "" || $contact->getDesignation() == "" || $contact->getMobile() == "" || 
            $contact->getCity() == "" || $contact->getState() == "" || $contact->getCountry() == "" || 
                $contact->getAddress() == "" || $contact->getLinkedIn() == "" || $contact->getFacebook() == "" || 
                    $contact->getTwitter() == "") {
                        return ERR_BLANK;
                    }
                    return true;
}

?>