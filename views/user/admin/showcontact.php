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
                    <div class="alert alert-info" role="alert">
                        <button class="btn btn-info action-btn btn-identical-dimension" onclick="showCompanyList()">Back</button>
                        <button id="edit-btn" class="btn btn-warning action-btn btn-identical-dimension" onclick="editContact()">Edit</button>
                        <button id="save-btn" class="btn btn-success action-btn btn-identical-dimension" onclick="saveContact()">Save</button>
                        <button id="reset-btn" class="btn btn-danger action-btn btn-identical-dimension" onclick="resetContact()">Cancel</button>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h2 class="text-center">Contact ""</h2>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered app-table-theme">
                                <tr id="contact-first-name-tr">
                                    <th>First Name</th>
                                    <td id="contact-first-name-td"></td>
                                </tr>
                                <tr id="contact-last-name-tr">
                                    <th>Last Name</th>
                                    <td id="contact-last-name-td"></td>
                                </tr>
                                <tr id="contact-email-tr">
                                    <th>Email</th>
                                    <td id="contact-email-td"></td>
                                </tr>
                                <tr id="contact-category-tr">
                                    <th>Category</th>
                                    <td id="contact-category-td"></td>
                                </tr>
                                <tr id="contact-designation-tr">
                                    <th>Designation</th>
                                    <td id="contact-designation-td"></td>
                                </tr>
                                <tr id="contact-mobile-tr">
                                    <th>Mobile</th>
                                    <td id="contact-mobile-td"></td>
                                </tr>
                                <tr id="contact-country-tr">
                                    <th>Country</th>
                                    <td id="contact-country-td"></td>
                                </tr>
                                <tr id="contact-state-tr">
                                    <th>State</th>
                                    <td id="contact-state-td"></td>
                                </tr>
                                <tr id="contact-city-tr">
                                    <th>City</th>
                                    <td id="contact-city-td"></td>
                                </tr>
                                <tr id="contact-address-tr">
                                    <th>Address</th>
                                    <td id="contact-address-td"></td>
                                </tr>
                                <tr id="contact-linkedin-tr">
                                    <th>LinkedIn</th>
                                    <td id="contact-linkedin-td"></td>
                                </tr>
                                <tr id="contact-facebook-tr">
                                    <th>Facebook</th>
                                    <td id="contact-facebook-td"></td>
                                </tr>
                                <tr id="contact-twitter-tr">
                                    <th>Twitter</th>
                                    <td id="contact-twitter-td"></td>
                                </tr>
                                <tr id="contact-status-tr">
                                    <th>Status</th>
                                    <td id="contact-status-td"></td>
                                </tr>
                                <tr id="contact-added-tr">
                                    <th>Added</th>
                                    <td id="contact-added-td"></td>
                                </tr>
                            </table>
                            <div id="options-div">
                                <button class="btn btn-primary action-btn" onclick="showCompany()">Show Company</button>
                            </div>
                            <table class="table table-bordered app-table-theme">
                                <tbody id="company-table-tbody"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>

        var contactCountry ="";
        var countries = [];
        var contactState = "";
        var states = [];
        var contactCity ="";
        var cities = [];
        var companyId;

        $(document).ready(function() {
            $("#edit-btn").hide();
            $("#reset-btn").hide();
            $("#save-btn").hide();
            loadContact("<?php echo $contactId; ?>");
        });

        function loadContact(contactId) {
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performfetchcontact.php",
                data: {
                    contactId: contactId
                },
                success: function(contactResponse) {
                    $("#contact-first-name-td").text(contactResponse.firstName);
                    $("#contact-last-name-td").text(contactResponse.lastName);
                    $("#contact-email-td").text(contactResponse.email);
                    $("#contact-category-td").text(contactResponse.category);
                    $("#contact-designation-td").text(contactResponse.designation);
                    $("#contact-mobile-td").text(contactResponse.mobile);
                    $("#contact-address-td").text(contactResponse.address);
                    $("#contact-linkedin-td").text(contactResponse.linkedIn);
                    $("#contact-facebook-td").text(contactResponse.facebook);
                    $("#contact-twitter-td").text(contactResponse.twitter);
                    $("#contact-status-td").text(contactResponse.status);
                    $("#contact-added-td").text(contactResponse.added);
                    companyId = contactResponse.company;
                    fetchAllLocationsAndLoadIntoDOM(contactResponse);
                }
            });
        }

        function fetchAllLocationsAndLoadIntoDOM(contactResponse) {
            var locationTypes = ["country-all", "state-all", "city-all"];
            $.each(locationTypes, function(index, value) {
                $.ajax({
                    type: "post",
                    url: "<?php echo BASEURL ?>actions/admin/performfetchlocation.php",
                    data: {
                        locationType: value
                    },
                    success: function(locationResponse) {
                        if(locationResponse.locationType === locationTypes[0]) {
                            countries = locationResponse.data;
                            setLocation(locationTypes[0], contactResponse);
                            return;
                        }
                        if(locationResponse.locationType === locationTypes[1]) {
                            states = locationResponse.data;
                            setLocation(locationTypes[1], contactResponse);
                            return;
                        }
                        if(locationResponse.locationType === locationTypes[2]) {
                            cities = locationResponse.data;
                            setLocation(locationTypes[2], contactResponse);
                            return;
                        }
                    }
                });
            });
        }

        function setLocation(locationType, contactResponse) {
            $("#edit-btn").show();
            if(locationType === "country-all") {
                $.each(countries, function(index, value) {
                    if(value.id == contactResponse.country) {
                        contactCountry = value.id;
                        $("#contact-country-td").text(value.name);
                        return false
                    }
                });
                return;
            }
            if(locationType === "state-all") {
                $.each(states, function(index, value) {
                    if(value.id == contactResponse.state) {
                        contactState = value.id;
                        $("#contact-state-td").text(value.name);
                        return false
                    }
                });
                return;
            }
            if(locationType === "city-all") {
                $.each(cities, function(index, value) {
                    if(value.id == contactResponse.city) {
                        contactCity = value.id;
                        $("#contact-city-td").text(value.name);
                        return false
                    }
                });
                return;
            }
        }

        function showCompanyList() {
            window.location = 'clientcontactlist.php';
        }

        function editContact() {
            $("#edit-btn").hide();
            buildAllInputFields();
            buildCountryDropDown();
            buildStateDropDown();
            buildCityDropDown();
            $("#save-btn").show();
            $("#reset-btn").show();
        }

        function buildAllInputFields() {
            $("#contact-first-name-td").html("<input type='text' class='form-control inline-form-control' value='" + $("#contact-first-name-td").text() + "'>");
            $("#contact-last-name-td").html("<input type='text' class='form-control inline-form-control' value='" + $("#contact-last-name-td").text() + "'>");
            $("#contact-email-td").html("<input type='text' class='form-control inline-form-control' value='" + $("#contact-email-td").text() + "'>");
            $("#contact-category-td").html("<input type='text' class='form-control inline-form-control' value='" + $("#contact-category-td").text() + "'>");
            $("#contact-designation-td").html("<input type='text' class='form-control inline-form-control' value='" + $("#contact-designation-td").text() + "'>");
            $("#contact-mobile-td").html("<input type='text' class='form-control inline-form-control' value='" + $("#contact-mobile-td").text() + "'>");
            $("#contact-address-td").html("<textarea class='form-control' style='resize: none;'>" + $("#contact-address-td").text() + "</textarea>");
            $("#contact-linkedin-td").html("<input type='text' class='form-control inline-form-control' value='" + $("#contact-linkedin-td").text() + "'>");
            $("#contact-facebook-td").html("<input type='text' class='form-control inline-form-control' value='" + $("#contact-facebook-td").text() + "'>");
            $("#contact-twitter-td").html("<input type='text' class='form-control inline-form-control' value='" + $("#contact-twitter-td").text() + "'>");
        }

        function buildCountryDropDown() {
            var countryBuilder = "";
            countryBuilder += "<select class='form-control'>"
            countryBuilder += "<option value=''>Select Country</option>"
            for(var i=0; i<countries.length; i++) {
                countryBuilder += "<option value='" + countries[i].id + "'>" + countries[i].name + "</option>"
            }
            countryBuilder += "</select>"
            $("#contact-country-td").html(countryBuilder);
            $("#contact-country-td select").val(contactCountry);
        }

        function buildStateDropDown() {
            var countryStates = [];
            for(var i=0; i<states.length; i++) {
                if(contactCountry === states[i].country) {
                    countryStates.push(jQuery.extend(true, {}, states[i]));
                }
            }
            var stateBuilder = "";
            stateBuilder += "<select class='form-control'>";
            stateBuilder += "<option value=''>Select State</option>";
            for(var i=0; i<countryStates.length; i++) {
                stateBuilder += "<option value='" + countryStates[i].id + "'>" + countryStates[i].name + "</option>"
            }
            stateBuilder += "</select>"
            $("#contact-state-td").html(stateBuilder);
            $("#contact-state-td select").val(contactState);
        }

        function buildCityDropDown() {
            var stateCities = [];
            for(var i=0; i<cities.length; i++) {
                if(contactState === cities[i].state) {
                    stateCities.push(jQuery.extend(true, {}, cities[i]));
                }
            }
            var cityBuilder = "";
            cityBuilder += "<select class='form-control'>";
            cityBuilder += "<option value=''>Select City</option>";
            for(var i=0; i<stateCities.length; i++) {
                cityBuilder += "<option value='" + stateCities[i].id + "'>" + stateCities[i].name + "</option>"
            }
            cityBuilder += "</select>"
            $("#contact-city-td").html(cityBuilder);
            $("#contact-city-td select").val(contactCity);
        }

        function showCompany() {
            $.ajax({
                type: "POST",
                url: "<?php echo BASEURL ?>actions/admin/performfetchcompany.php",
                data: {
                    companyId: companyId 
                },
                success: function(response) {
                    var companyTableBuilder = "";
                    companyTableBuilder += "<tr>";
                    companyTableBuilder += "<th>Company Name</th>";
                    companyTableBuilder += "<td>" + response.name + "</td>";
                    companyTableBuilder += "</tr>";
                    companyTableBuilder += "<tr>";
                    companyTableBuilder += "<th>Company Website</th>";
                    companyTableBuilder += "<td>" + response.website + "</td>";
                    companyTableBuilder += "</tr>";
                    companyTableBuilder += "<tr>";
                    companyTableBuilder += "<th>Company Address</th>";
                    companyTableBuilder += "<td>" + response.address + "</td>";
                    companyTableBuilder += "</tr>";
                    companyTableBuilder += "<tr>";
                    companyTableBuilder += "<th>Company Phone</th>";
                    companyTableBuilder += "<td>" + response.phone + "</td>";
                    companyTableBuilder += "</tr>";
                    companyTableBuilder += "<tr>";
                    companyTableBuilder += "<th>Company Email</th>";
                    companyTableBuilder += "<td>" + response.email + "</td>";
                    companyTableBuilder += "</tr>";
                    companyTableBuilder += "<tr>";
                    companyTableBuilder += "<th>Company Linkedin</th>";
                    companyTableBuilder += "<td>" + response.linkedin + "</td>";
                    companyTableBuilder += "</tr>";
                    $("#company-table-tbody").html(companyTableBuilder);
                    $("#options-div").html("<h3>Company:</h3>");
                }
            });
        }

        function resetContact() {
            window.location.reload();
        }

    </script>
</body>
</html>