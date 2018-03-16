<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/config.php');
include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/services/ClientService.php');

$contactId = $_GET["contactId"];
$clientService = new ClientService();
$contact = $clientService->getContactById($contactId);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sales Team Application</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASEURL; ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="<?php echo BASEURL; ?>assets/css/styles.css" />
    <script src="<?php echo BASEURL; ?>assets/js/jquery.min.js"></script>
    <script src="<?php echo BASEURL; ?>assets/js/bootstrap.min.js"></script>
</head>
<body>
    <?php include 'navbar.php';?>
    <div class="content-view">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-3">
                    <?php include("sidemenu.php"); ?>
                </div>
                <div class="col-sm-9">
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="text-center"><?php echo $contact->getFirstName()." ".$contact->getLastName(); ?></h2>
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-info" role="alert">
                                <button class="btn btn-info action-btn btn-identical-dimension" onclick="showCompanyList()">Back</button>
                            </div>
                            <table class="table table-bordered app-table-theme">
                                <tr>
                                    <th>First Name</th>
                                    <td><?php echo $contact->getFirstName(); ?></td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td><?php echo $contact->getLastName(); ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td><?php echo $contact->getEmail(); ?></td>
                                </tr>
                                <tr>
                                    <th>Category</th>
                                    <td><?php echo $contact->getCategory(); ?></td>
                                </tr>
                                <tr>
                                    <th>Designation</th>
                                    <td><?php echo $contact->getDesignation(); ?></td>
                                </tr>
                                <tr>
                                    <th>Mobile</th>
                                    <td><?php echo $contact->getMobile(); ?></td>
                                </tr>
                                <tr>
                                    <th>Country</th>
                                    <td><?php echo $contact->getCountry(); ?></td>
                                </tr>
                                <tr>
                                    <th>State</th>
                                    <td><?php echo $contact->getState(); ?></td>
                                </tr>
                                <tr>
                                    <th>City</th>
                                    <td><?php echo $contact->getCity(); ?></td>
                                </tr>
                                <tr>
                                    <th>Address</th>
                                    <td><?php echo $contact->getAddress(); ?></td>
                                </tr>
                                <tr>
                                    <th>LinkedIn</th>
                                    <td><?php echo $contact->getLinkedIn(); ?></td>
                                </tr>
                                <tr>
                                    <th>Facebook</th>
                                    <td><?php echo $contact->getFacebook(); ?></td>
                                </tr>
                                <tr>
                                    <th>Twitter</th>
                                    <td><?php echo $contact->getTwitter(); ?></td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td><?php echo $contact->getStatus(); ?></td>
                                </tr>
                                <tr>
                                    <th>Added</th>
                                    <td><?php echo $contact->getAdded(); ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>
        function showCompanyList() {
            window.location = 'clientcontactlist.php';
        }
    </script>
</body>
</html>