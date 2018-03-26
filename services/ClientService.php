<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/utility/DatabaseManager.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Company.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/'. explode("/", $_SERVER['PHP_SELF'])[1] .'/models/Contact.php');

class ClientService {

    private $databaseManager;
    private $connection;

    public function __construct() {
        $this->databaseManager = new DatabaseManager();
        $this->connection = $this->databaseManager->getConnection();
    }

    public function checkCompanyWebsite($companyWebsite) {
        $stmt = $this->connection->prepare("select * from client_companies where client_company_website = ?");
        $stmt->bind_param("s", $companyWebsite);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true; 
        }
    }

    public function checkCompanyWebsiteAllowSelf($companyWebsite, $originalCompanyWebsite) {
        if($companyWebsite === $originalCompanyWebsite) {
            return true;
        }
        $stmt = $this->connection->prepare("select * from client_companies where client_company_website = ?");
        $stmt->bind_param("s", $companyWebsite);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function saveCompany($company) {
        $companyName = $company->getName();
        $companyWebsite = $company->getWebsite();
        $companyAddress = $company->getAddress();
        $companyPhone = $company->getPhone();
        $companyEmail = $company->getEmail();
        $companyLinkedIn = $company->getLinkedIn();
        $assocManager = $company->getAssocManager();
        $this->connection->query("lock tables client_companies write");
        $stmt = $this->connection->prepare("insert into client_companies (client_company_name, client_company_website, client_company_address, client_company_phone, client_company_email, client_company_linkedin, assoc_manager_id) values (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssissi", $companyName, $companyWebsite, $companyAddress, $companyPhone, $companyEmail, $companyLinkedIn, $assocManager);
        $stmt->execute();
        $stmt->close();
        $query = $this->connection->query("select max(client_company_id) from client_companies");
        $this->connection->query("unlock tables");
        $max_client_company_id = $query->fetch_assoc()['max(client_company_id)'];
        return $max_client_company_id;
    }

    public function updateCompany($company) {
        $companyId = $company->getId();
        $companyName = $company->getName();
        $companyWebsite = $company->getWebsite();
        $companyAddress = $company->getAddress();
        $companyPhone = $company->getPhone();
        $companyEmail = $company->getEmail();
        $companyLinkedIn = $company->getLinkedIn();
        $stmt = $this->connection->prepare("update client_companies set client_company_name = ?, client_company_website = ?, client_company_address = ?, client_company_phone = ?, client_company_email = ?, client_company_linkedin = ? where client_company_id = ?");
        $stmt->bind_param("sssissi", $companyName, $companyWebsite, $companyAddress, $companyPhone, $companyEmail, $companyLinkedIn, $companyId);
        $stmt->execute();
        $stmt->close();
    }
    
    public function updateContact($contact) {
        $id = $contact->getId();
        $firstName = $contact->getFirstName();
        $lastName = $contact->getLastName();
        $email = $contact->getEmail();
        $category = $contact->getCategory();
        $designation = $contact->getDesignation();
        $mobile = $contact->getMobile();
        $city = $contact->getCity();
        $state = $contact->getState();
        $country = $contact->getCountry();
        $address = $contact->getAddress();
        $linkedIn = $contact->getLinkedIn();
        $facebook = $contact->getFacebook();
        $twitter = $contact->getTwitter();
        $stmt = $this->connection->prepare("update client_contacts set client_contact_first_name = ?, client_contact_last_name = ?, client_contact_email = ?, client_contact_category = ?, client_contact_designation = ?, client_contact_mobile = ?, city_id = ?, state_id = ?, country_id = ?, client_contact_address = ?, client_contact_linkedin = ?, client_contact_facebook = ?, client_contact_twitter = ? where client_contact_id = ?");
        $stmt->bind_param("sssssiiiissssi", $firstName, $lastName, $email, $category, $designation, $mobile, $city, $state, $country, $address, $linkedIn, $facebook, $twitter, $id);
        $stmt->execute();
        $stmt->close();
    }

    public function checkContactEmail($contactEmail) {
        $stmt = $this->connection->prepare("select client_contact_email from client_contacts where client_contact_email = ?");
        $stmt->bind_param("s", $contactEmail);
        $stmt->execute();
        $res = $stmt->get_result();
        $stmt->close();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function checkContactEmailAllowSelf($email, $originalEmail) {
        if($email === $originalEmail) {
            return true;
        }
        $stmt = $this->connection->prepare("select client_contact_email from client_contacts where client_contact_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $res = $stmt->get_result();
        if($res->num_rows > 0) {
            return false;
        } else {
            return true;
        }
    }

    public function saveContact($contact) {
        $firstName = $contact->getFirstName();
        $lastName = $contact->getLastName();
        $email = $contact->getEmail();
        $category = $contact->getCategory();
        $designation = $contact->getDesignation();
        $mobile = $contact->getMobile();
        $city = $contact->getCity();
        $state = $contact->getState();
        $country = $contact->getCountry();
        $address = $contact->getAddress();
        $linkedIn = $contact->getLinkedIn();
        $facebook = $contact->getFacebook();
        $twitter = $contact->getTwitter();
        $status = "NEW";
        $added = date("Y-m-d H:i:s");
        $companyId = $contact->getCompany();
        $assocManager = $contact->getAssocManager();
        $stmt = $this->connection->prepare("insert into client_contacts (client_contact_first_name, client_contact_last_name, client_contact_email, client_contact_category, client_contact_designation, client_contact_mobile, city_id, state_id, country_id, client_contact_address, client_contact_linkedin, client_contact_facebook, client_contact_twitter, client_contact_status, client_contact_added, client_company_id, assoc_manager_id) values (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssiiiissssssii", $firstName, $lastName, $email, $category, $designation, $mobile, $city, $state, $country, $address, $linkedIn, $facebook, $twitter, $status, $added, $companyId, $assocManager);
        $stmt->execute();
        $stmt->close();
    }

    public function getCompaniesByOffset($offset) {
        $limit = COMPANY_LIST_LIMIT;
        $stmt = $this->connection->prepare("select * from client_companies order by client_company_id desc limit ?,?");
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfCompanies = array();
        while($row = $res->fetch_assoc()) {
            $company = new Company();
            $company->setId($row['client_company_id']);
            $company->setName($row['client_company_name']);
            $company->setWebsite($row['client_company_website']);
            $company->setAddress($row['client_company_address']);
            $company->setPhone($row['client_company_phone']);
            $company->setEmail($row['client_company_email']);
            $company->setLinkedIn($row['client_company_linkedin']);
            array_push($listOfCompanies, $company);
        }
        $stmt->close();
        return $listOfCompanies;
    }

    public function getCompanyById($companyId) {
        $stmt = $this->connection->prepare("select * from client_companies where client_company_id = ?");
        $stmt->bind_param("i", $companyId);
        $stmt->execute();
        $res = $stmt->get_result();
        $company = new Company();
        if($row = $res->fetch_assoc()) {
            $company->setId($row['client_company_id']);
            $company->setName($row['client_company_name']);
            $company->setWebsite($row['client_company_website']);
            $company->setAddress($row['client_company_address']);
            $company->setPhone($row['client_company_phone']);
            $company->setEmail($row['client_company_email']);
            $company->setLinkedIn($row['client_company_linkedin']);
            $company->setAssocManager($row['assoc_manager_id']);
        }
        $stmt->close();
        return $company;
    }

    public function getContactsByOffset($offset) {
        $limit = CONTACT_LIST_LIMIT;
        $stmt = $this->connection->prepare("select * from client_contacts order by client_contact_id desc limit ?,?");
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfContacts = array();
        while($row = $res->fetch_assoc()) {
            $contact = new Contact();
            $contact->setId($row['client_contact_id']);
            $contact->setFirstName($row['client_contact_first_name']);
            $contact->setLastName($row['client_contact_last_name']);
            $contact->setEmail($row['client_contact_email']);
            $contact->setCategory($row['client_contact_category']);
            $contact->setDesignation($row['client_contact_designation']);
            $contact->setMobile($row['client_contact_mobile']);
            $contact->setCountry($row['country_id']);
            $contact->setState($row['state_id']);
            $contact->setCity($row['city_id']);
            $contact->setAddress($row['client_contact_address']);
            $contact->setLinkedIn($row['client_contact_linkedin']);
            $contact->setFacebook($row['client_contact_facebook']);
            $contact->setTwitter($row['client_contact_twitter']);
            $contact->setStatus($row['client_contact_status']);
            $contact->setAdded($row['client_contact_added']);
            $contact->setCompany($row['client_company_id']);
            array_push($listOfContacts, $contact);
        }
        $stmt->close();
        return $listOfContacts;
    }

    public function getContactsByCompanyId($companyId) {
        $stmt = $this->connection->prepare("select * from client_contacts where client_company_id = ? order by client_contact_id desc");
        $stmt->bind_param("i", $companyId);
        $stmt->execute();
        $res = $stmt->get_result();
        $listOfContacts = array();
        while($row = $res->fetch_assoc()) {
            $contact = new Contact();
            $contact->setId($row['client_contact_id']);
            $contact->setFirstName($row['client_contact_first_name']);
            $contact->setLastName($row['client_contact_last_name']);
            $contact->setEmail($row['client_contact_email']);
            $contact->setCategory($row['client_contact_category']);
            $contact->setDesignation($row['client_contact_designation']);
            $contact->setMobile($row['client_contact_mobile']);
            $contact->setCountry($row['country_id']);
            $contact->setState($row['state_id']);
            $contact->setCity($row['city_id']);
            $contact->setAddress($row['client_contact_address']);
            $contact->setLinkedIn($row['client_contact_linkedin']);
            $contact->setFacebook($row['client_contact_facebook']);
            $contact->setTwitter($row['client_contact_twitter']);
            $contact->setStatus($row['client_contact_status']);
            $contact->setAdded($row['client_contact_added']);
            $contact->setCompany($row['client_company_id']);
            array_push($listOfContacts, $contact);
        }
        $stmt->close();
        return $listOfContacts;
    }

    public function getContactById($contactId) {
        $stmt = $this->connection->prepare("select * from client_contacts where client_contact_id = ?");
        $stmt->bind_param("i", $contactId);
        $stmt->execute();
        $res = $stmt->get_result();
        $contact = new Contact();
        if($row = $res->fetch_assoc()) {
            $contact->setId($row['client_contact_id']);
            $contact->setFirstName($row['client_contact_first_name']);
            $contact->setLastName($row['client_contact_last_name']);
            $contact->setEmail($row['client_contact_email']);
            $contact->setCategory($row['client_contact_category']);
            $contact->setDesignation($row['client_contact_designation']);
            $contact->setMobile($row['client_contact_mobile']);
            $contact->setCountry($row['country_id']);
            $contact->setState($row['state_id']);
            $contact->setCity($row['city_id']);
            $contact->setAddress($row['client_contact_address']);
            $contact->setLinkedIn($row['client_contact_linkedin']);
            $contact->setFacebook($row['client_contact_facebook']);
            $contact->setTwitter($row['client_contact_twitter']);
            $contact->setStatus($row['client_contact_status']);
            $contact->setAdded($row['client_contact_added']);
            $contact->setCompany($row['client_company_id']);
        }
        $stmt->close();
        return $contact;
    }

    public function deleteContactById($contactId) {
        $stmt = $this->connection->prepare("delete from client_contacts where client_contact_id = ?");
        $stmt->bind_param("i", $contactId);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        return $affected_rows;
    }

    public function deleteCompanyByIdCascadeDeleteContacts($companyId) {
        $stmt = $this->connection->prepare("delete from client_contacts where client_company_id  = ?");
        $stmt->bind_param("i", $companyId);
        $stmt->execute();
        $affected_rows = $stmt->affected_rows;
        $stmt->close();
        $stmt = $this->connection->prepare("delete from client_companies where client_company_id = ?");
        $stmt->bind_param("i", $companyId);
        $stmt->execute();
        $affected_rows += $stmt->affected_rows;
        $stmt->close();
        return $affected_rows;
    }

}