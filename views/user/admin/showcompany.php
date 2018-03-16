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

$companyId = $_GET["companyId"];
$clientService = new ClientService();
$company = $clientService->getCompanyById($companyId);

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
                            <h2 class="text-center"><?php echo $company->getName(); ?></h2>
                        </div>
                        <div class="panel-body">
                            <div class="alert alert-info" role="alert">
                                <button class="btn btn-info action-btn btn-identical-dimension" onclick="showCompanyList()">Back</button>
                            </div>
                            <table class="table table-bordered app-table-theme">
                                <tr>
                                    <th>Company Name</th>
                                    <td><?php echo $company->getName(); ?></td>
                                </tr>
                                <tr>
                                    <th>Company Website</th>
                                    <td><?php echo $company->getWebsite(); ?></td>
                                </tr>
                                <tr>
                                    <th>Company Address</th>
                                    <td><?php echo $company->getAddress(); ?></td>
                                </tr>
                                <tr>
                                    <th>Company Phone</th>
                                    <td><?php echo $company->getPhone(); ?></td>
                                </tr>
                                <tr>
                                    <th>Company Email</th>
                                    <td><?php echo $company->getPhone(); ?></td>
                                </tr>
                                <tr>
                                    <th>Company Linkedin</th>
                                    <td><?php echo $company->getLinkedIn(); ?></td>
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
            window.location = 'clientcompanylist.php';
        }
    </script>
</body>
</html>