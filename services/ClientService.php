<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/utility/DatabaseManager.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/models/Company.php');

class ClientService {

    private $databaseManager;
    private $connection;

    public function __construct() {
        $this->databaseManager = new DatabaseManager();
        $this->connection = $this->databaseManager->getConnection();
    }

    public function checkWebsite($companyWebsite) {
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
        $this->connection->query("lock tables client_companies write");
        $stmt = $this->connection->prepare("insert into client_companies (client_company_name, client_company_website, client_company_address, client_company_phone, client_company_email, client_company_linkedin) values (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssiss", $companyName, $companyWebsite, $companyAddress, $companyPhone, $companyEmail, $companyLinkedIn);
        $stmt->execute();
        $stmt->close();
        $query = $this->connection->query("select max(client_company_id) from client_companies");
        $this->connection->query("unlock tables");
        $max_client_company_id = $query->fetch_assoc()['max(client_company_id)'];
        return $max_client_company_id;
    }

}