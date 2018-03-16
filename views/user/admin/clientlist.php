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
                    <h2 class="text-center">Client List</h2>
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">Client Companies</div>
                                <div class="panel-body">
                                    <div id="company-div" class="data-list-wrapper">
                                        <table class="table table-striped table-hover table-bordered">
                                            <thead>
                                                <tr class="info">
                                                    <th>Name</th>
                                                    <th>Website</th>
                                                </tr>
                                            </thead>
                                            <tbody id="company-list"></tbody>
                                        </table>
                                    </div>
                                    <div class="text-center" id="company-options-div">
                                        <button id="load-more-btn" class="btn btn-default text-center" onclick="showMoreCompanies()">Show More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="panel panel-default">
                                <div class="panel-heading">Client Contacts</div>
                                <div class="panel-body">
                                    <div id="contact-div" class="data-list-wrapper">
                                        <table class="table table-striped table-hover table-bordered">
                                            <thead>
                                                <tr class="info">
                                                    <th>First Name</th>
                                                    <th>Last Name</th>
                                                    <th>Email</th>
                                                </tr>
                                            </thead>
                                            <tbody id="contact-list"></tbody>
                                        </table>
                                    </div>
                                    <div class="text-center" id="contact-options-div">
                                        <button id="load-more-btn" class="btn btn-default text-center" onclick="showMoreContacts()">Show More</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <?php include 'footer.php';?>
    <script>
        $(document).ready(function() {
            loadCompaniesByLimit();
            loadContactsByLimit();
        });

        function loadCompaniesByLimit() {
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performfetchcompanylist.php",
                data: {
                    offset: 0
                },
                success: function(response) {
                    var companyListBuilder = "";
                    if(response.length == 0) {
                        $("#company-div").html("<h4 class='text-center'>No Companies Are Available!</h4>");
                        return;
                    }
                    for(var i=0; i<response.length; i++) {
                        companyListBuilder += "<tr>";
                        companyListBuilder += "<td>" + response[i].name + "</td>";
                        companyListBuilder += "<td>" + response[i].website + "</td>";
                        companyListBuilder += "</tr>";
                    }
                    $("#company-list").append(companyListBuilder);
                },
                error: function(response) {
                    $("#company-div").html("<h4 class='text-center'>Something Went Wrong!</h4>");
                    $("#company-options-div").html("<button id='load-more-btn' class='btn btn-default text-center' onclick='location.reload()'>Reload Page</button>");
                }
            });
        }

        function loadContactsByLimit() {
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performfetchcontactlist.php",
                data: {
                    offset: 0
                },
                success: function(response) {
                    var contactListBuilder = "";
                    if(response.length == 0) {
                        $("#contact-div").html("<h4 class='text-center'>No Contacts Are Available!</h4>");
                        return;
                    }
                    for(var i=0; i<response.length; i++) {
                        contactListBuilder += "<tr>";
                        contactListBuilder += "<td>" + response[i].firstName + "</td>";
                        contactListBuilder += "<td>" + response[i].lastName + "</td>";
                        contactListBuilder += "<td>" + response[i].email + "</td>";
                        contactListBuilder += "</tr>";
                    }
                    $("#contact-list").append(contactListBuilder);
                },
                error: function(response) {
                    $("#contact-div").html("<h4 class='text-center'>Something Went Wrong!</h4>");
                    $("#contact-options-div").html("<button id='load-more-btn' class='btn btn-default text-center' onclick='location.reload()'>Reload Page</button>");
                }
            });
        }

        function showMoreCompanies() {
            window.location = 'clientcompanylist.php';
        }

        function showMoreContacts() {
            window.location = 'clientcontactlist.php';
        }

    </script>
</body>
</html>