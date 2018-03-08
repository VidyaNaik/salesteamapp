<?php
session_start();
/**
 * Admin Only Allowed
 */
if($_SESSION['role'] !== "ADMIN") {
    header("Location: ../../error/noaccess.php");
}

include_once($_SERVER['DOCUMENT_ROOT'].'/salesteamapp/config.php');
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
                    <h2 class="text-center">Add New Client</h2>
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-sm-offset-1 col-sm-10">
                            <form id="addClientForm" class="form-horizontal" action="" method="post">
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Company Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="companyName" id="companyName" placeholder="Enter Company Name" class="form-control" onfocusout="">
                                        <p id="companyNameErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Company Website</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="companyWebsite" id="companyWebsite" placeholder="Enter Company Website" class="form-control" onfocusout="">
                                        <p id="companyWebsiteErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Company Phone</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="companyPhone" id="companyPhone" placeholder="Enter Company Phone" class="form-control" onfocusout="">
                                        <p id="companyPhoneErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Company E-Mail</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="companyEmail" id="companyEmail" placeholder="Enter Company Email" class="form-control" onfocusout="">
                                        <p id="companyEmailErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Company LinkedIn</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="companyLinkedIn" id="companyLinkedIn" placeholder="Enter Company LinkedIn" class="form-control" onfocusout="">
                                        <p id="companyLinkedInErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Company Address</label>
                                    <div class="col-sm-9">
                                        <textarea name="companyAddress" id="companyAddress" placeholder="Enter Company Address" class="form-control" style="resize: none;" onfocusout=""></textarea>
                                        <p id="companyWebsiteErrMsg"></p>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod"> 
                                    <div class="col-sm-12 text-center">
                                        <button id="add-contact-btn" type="button" class="btn btn-default form-btn" onclick="">Add Contact</button>
                                        <button id="add-btn" type="button" class="btn btn-primary form-btn" onclick="addClientFormValidation()">Save</button>
                                        <button id="reset-btn" type="button" class="btn btn-warning form-btn" onclick="addClientFormReset()">Clear</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
</body>
</html>