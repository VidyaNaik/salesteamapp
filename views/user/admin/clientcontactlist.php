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
                    <h2 class="text-center">Client Contact List</h2>
                    <div class="server-message" id="server-message">
                        <?php
                            if(isset($_SESSION["serverMsg"])) {
                                echo "<p class='text-center'>" . $_SESSION["serverMsg"] . "</p>";
                                unset($_SESSION['serverMsg']);
                            }
                        ?>
                    </div>
                    <div class="alert alert-info" role="alert">
                        <button class="btn btn-info action-btn btn-identical-dimension" onclick="showClientList()">Back</button>
                    </div>
                    <div id="contact-div">
                        <table class="table table-striped table-hover table-bordered">
                            <thead>
                                <tr class="info">
                                    <th>First Name</th>
                                    <th>Last Name</th>
                                    <th>Email</th>
                                    <th>Company</th>
                                    <th>Category</th>
                                    <th>Designation</th>
                                    <th>Mobile</th>
                                    <th>Country</th>
                                    <th>State</th>
                                    <th>City</th>
                                    <th>Address</th>
                                    <th>LinkedIn</th>
                                    <th>Facebook</th>
                                    <th>Twitter</th>
                                    <th>Added</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody id="contact-list"></tbody>
                        </table>
                    </div>
                    <div class="text-center" id="options-div">
                        <button id="load-more-btn" class="btn btn-default text-center" onclick="loadByLimit()">Load More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>
    var updateOffset = 0;
    var isUpdateOffsetPristine = true;

    $(document).ready(function() {
        loadByLimit();
    });

    function loadByLimit() {
        $("#load-more-btn").prop('disabled', true);
        $.ajax({
            type: "POST",
            url: "<?php echo BASEURL ?>actions/admin/performfetchcontactlist.php",
            data: {
                offset: updateOffset
            },
            success: function(response) {
                var contactListBuilder = "";
                if(response.length == 0 && isUpdateOffsetPristine == true) {
                    $("#contact-div").html("<h4 class='text-center'>No Contacts Are Available!</h4>");
                    $("#load-more-btn").hide();
                    return;
                } else if(response.length == 0 && isUpdateOffsetPristine == false) {
                    $("#contact-div").append("<h4 class='text-center'>No More Contacts Are Available!</h4>");
                    $("#load-more-btn").hide();
                    return;
                }
                if(response.length == 0) {
                    $("#contact-div").html("<h4 class='text-center'>No Contacts Are Available!</h4>");
                    return;
                }
                for(var i=0; i<response.length; i++) {
                    contactListBuilder += "<tr>";
                    contactListBuilder += "<td>" + response[i] + "</td>";
                    contactListBuilder += "</tr>";
                }
                $("#contact-list").append(contactListBuilder);
                updateOffset += <?php echo CONTACT_LIST_LIMIT; ?>;
                isUpdateOffsetPristine = false;
                $("#load-more-btn").prop('disabled', false);
            },
            error: function(response) {
                $("#contact-div").html("<h4 class='text-center'>Something Went Wrong!</h4>");
                $("#options-div").html("<button id='load-more-btn' class='btn btn-default text-center' onclick='location.reload()'>Reload Page</button>");
            }
        });
    }

    function showClientList() {
        window.location = 'clientlist.php';
    }

    </script>
</body>
</html>