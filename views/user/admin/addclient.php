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
                                    <label class="control-label col-sm-3">Contacts</label>
                                    <div class="col-sm-9">
                                        <div id="client-contact-pool" class="client-contact-pool">
                                            <button id="add-contact-btn" type="button" class="btn btn-default form-btn" onclick="showContactForm()"><span class="glyphicon glyphicon-plus"></span> Add Contact</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group form-group-mod"> 
                                    <div class="col-sm-12 text-center">
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
    <div id="contactModal" class="modal fade" role="dialog" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-mod">
            <div class="modal-content">
                <div class="modal-header modal-header-mod">
                    <h4 class="modal-title">Add Contact <span id="number-of-contact"></span></h4>
                </div>
                <div class="modal-body">
                    <form id="addContactForm" class="form-horizontal">
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="contact-first-name-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">First Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter First Name" class="form-control" onfocusout="">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="contact-last-name-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Last Name</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter Last Name" class="form-control" onfocusout="">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="contact-email-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">E-Mail</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter E-Mail Address" class="form-control" onfocusout="">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="contact-category-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Category</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter Category" class="form-control" onfocusout="">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="contact-designation-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Designation</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter Designation" class="form-control" onfocusout="">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="contact-mobile-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Mobile</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter Mobile" class="form-control" onfocusout="">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="contact-country-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Country</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter Country" class="form-control" onfocusout="">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="contact-state-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">State</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter State" class="form-control" onfocusout="">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="contact-city-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">City</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter City" class="form-control" onfocusout="">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="contact-linkedin-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">LinkedIn</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter LinkedIn" class="form-control" onfocusout="">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="contact-facebook-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Facebook</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter Facebook" class="form-control" onfocusout="">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div id="contact-twitter-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Twitter</label>
                                    <div class="col-sm-9">
                                        <input type="text" placeholder="Enter Twitter" class="form-control" onfocusout="">
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div id="contact-address-div" class="form-group form-group-mod">
                                    <label class="control-label col-sm-3">Address</label>
                                    <div class="col-sm-9">
                                        <textarea placeholder="Enter Address" class="form-control" style="resize: none;" onfocusout=""></textarea>
                                        <p></p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">

                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer modal-footer-mod">
                    <button type="button" class="btn btn-primary action-btn btn-identical-dimension" onclick="addContactFieldsToMainForm()">Add</button>
                    <button type="button" class="btn btn-danger action-btn btn-identical-dimension" onclick="cancelContact()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php';?>
    <script>
        var contactId = 0;

        function showContactForm() {
            contactId++;
            $("#number-of-contact").html("#" + contactId);
            setContactAttributes(contactId);
            $("#contactModal").modal();
        }

        function setContactAttributes(contactId) {
            /**
            Set First Name Attributes
            */
            $("#contact-first-name-div input").attr('id', 'contact_' + contactId + '_firstName');
            $("#contact-first-name-div input").attr('name', 'contact_' + contactId + '_firstName');
            $("#contact-first-name-div p").attr('id', 'contact_' + contactId + '_firstNameErrMsg');

            /**
            Set Last Name Attributes
            */
            $("#contact-last-name-div input").attr('id', 'contact_' + contactId + '_lastName');
            $("#contact-last-name-div input").attr('name', 'contact_' + contactId + '_lastName');
            $("#contact-last-name-div p").attr('id', 'contact_' + contactId + '_lastNameErrMsg');

            /**
            Set Email Attributes
            */
            $("#contact-email-div input").attr('id', 'contact_' + contactId + '_email');
            $("#contact-email-div input").attr('name', 'contact_' + contactId + '_email');
            $("#contact-email-div p").attr('id', 'contact_' + contactId + '_emailErrMsg');

            /**
            Set Category Attributes
            */
            $("#contact-category-div input").attr('id', 'contact_' + contactId + '_category');
            $("#contact-category-div input").attr('name', 'contact_' + contactId + '_category');
            $("#contact-category-div p").attr('id', 'contact_' + contactId + '_categoryErrMsg');

            /**
            Set Designation Attributes
            */
            $("#contact-designation-div input").attr('id', 'contact_' + contactId + '_designation');
            $("#contact-designation-div input").attr('name', 'contact_' + contactId + '_designation');
            $("#contact-designation-div p").attr('id', 'contact_' + contactId + '_designationErrMsg');

            /**
            Set Mobile Attributes
            */
            $("#contact-mobile-div input").attr('id', 'contact_' + contactId + '_mobile');
            $("#contact-mobile-div input").attr('name', 'contact_' + contactId + '_mobile');
            $("#contact-mobile-div p").attr('id', 'contact_' + contactId + '_mobileErrMsg');
            
            /**
            Set Country Attributes 
            */
            $("#contact-country-div input").attr('id', 'contact_' + contactId + '_country');
            $("#contact-country-div input").attr('name', 'contact_' + contactId + '_country');
            $("#contact-country-div p").attr('id', 'contact_' + contactId + '_countryErrMsg');

            /**
            Set State Attributes
            */
            $("#contact-state-div input").attr('id', 'contact_' + contactId + '_state');
            $("#contact-state-div input").attr('name', 'contact_' + contactId + '_state');
            $("#contact-state-div p").attr('id', 'contact_' + contactId + '_stateErrMsg');

            /**
            Set City Attributes 
            */
            $("#contact-city-div input").attr('id', 'contact_' + contactId + '_city');
            $("#contact-city-div input").attr('name', 'contact_' + contactId + '_city');
            $("#contact-city-div p").attr('id', 'contact_' + contactId + '_cityErrMsg');
            
            /**
            Set LinkedIn Attributes
            */
            $("#contact-linkedin-div input").attr('id', 'contact_' + contactId + '_linkedin');
            $("#contact-linkedin-div input").attr('name', 'contact_' + contactId + '_linkedin');
            $("#contact-linkedin-div p").attr('id', 'contact_' + contactId + '_linkedinErrMsg');

            /**
            Set Facebook Attributes 
            */
            $("#contact-facebook-div input").attr('id', 'contact_' + contactId + '_facebook');
            $("#contact-facebook-div input").attr('name', 'contact_' + contactId + '_facebook');
            $("#contact-facebook-div p").attr('id', 'contact_' + contactId + '_facebookErrMsg');

            /**
            Set Twitter Attributes 
            */
            $("#contact-twitter-div input").attr('id', 'contact_' + contactId + '_twitter');
            $("#contact-twitter-div input").attr('name', 'contact_' + contactId + '_twitter');
            $("#contact-twitter-div p").attr('id', 'contact_' + contactId + '_twitterErrMsg');

            /**
            Set Address Attributes 
            */
            $("#contact-address-div textarea").attr('id', 'contact_' + contactId + '_address');
            $("#contact-address-div textarea").attr('name', 'contact_' + contactId + '_address');
            $("#contact-address-div p").attr('id', 'contact_' + contactId + '_addressErrMsg');
        }

        function cancelContact() {
            resetContactForm();
            contactId--;
        }

        function resetContactForm() {
            $("#contact-first-name-div input").val('');
            $("#contact-last-name-div input").val('');
            $("#contact-email-div input").val('');
            $("#contact-category-div input").val('');
            $("#contact-designation-div input").val('');
            $("#contact-mobile-div input").val('');
            $("#contact-country-div input").val('');
            $("#contact-state-div input").val('');
            $("#contact-city-div input").val('');
            $("#contact-linkedin-div input").val('');
            $("#contact-facebook-div input").val('');
            $("#contact-twitter-div input").val('');
            $("#contact-address-div textarea").val('');
            $('#contactModal').modal('toggle');
        }

        /**
        Note: Main form is addClientForm 
        */
        function addContactFieldsToMainForm() {
            $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_firstName'  name='contact_form_" + contactId + "_firstName' value='" + $("#contact-first-name-div input").val() + "'>");
            $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_lastName' name='contact_form_" + contactId + "_lastName' value='" + $("#contact-last-name-div input").val() + "'>");
            $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_email' name='contact_form_" + contactId + "_email' value='" + $("#contact-email-div input").val() + "'>");
            $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_category' name='contact_form_" + contactId + "_category' value='" + $("#contact-category-div input").val() + "'>");
            $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_designation' name='contact_form_" + contactId + "_designation' value='" + $("#contact-designation-div input").val() + "'>");
            $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_mobile' name='contact_form_" + contactId + "_mobile' value='" + $("#contact-mobile-div input").val() + "'>");
            $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_country' name='contact_form_" + contactId + "_country' value='" + $("#contact-country-div input").val() + "'>");
            $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_state' name='contact_form_" + contactId + "_state' value='" + $("#contact-state-div input").val() + "'>");
            $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_city' name='contact_form_" + contactId + "_city' value='" + $("#contact-city-div input").val() + "'>");
            $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_linkedin' name='contact_form_" + contactId + "_linkedin' value='" + $("#contact-linkedin-div input").val() + "'>");
            $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_facebook' name='contact_form_" + contactId + "_facebook' value='" + $("#contact-facebook-div input").val() + "'>");
            $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_twitter' name='contact_form_" + contactId + "_twitter' value='" + $("#contact-twitter-div input").val() + "'>");
            $('#addClientForm').append("<input type='hidden' id='contact_form_" + contactId + "_address' name='contact_form_" + contactId + "_address' value='" + $("#contact-address-div input").val() + "'>");
            $('#client-contact-pool').append("<div class='cmplx-btn btn btn-success form-btn'><div title='Edit Contact' class='cmplx-btn-wrapper' onclick='editContact(" + contactId + ")'>" + $("#contact-first-name-div input").val() + "</div><div class='cmplx-options-wrapper'><span title='Remove Contact' class='glyphicon glyphicon-remove' onclick='deleteContact(" + contactId + ")'></span></div></div>");
            resetContactForm();
        }

        function editContact(contactId) {
            $('#contactModal').modal();
            repopulateModal(contactId);
        }

        function deleteContact(contactId) {
            alert("delete");
        }

        function repopulateModal(contactId) {
            $("#contact-first-name-div input").val($("#contact_form_" + contactId + "_firstName").val());
            $("#contact-last-name-div input").val($("#contact_form_" + contactId + "_lastName").val());
        }
        
    </script>
</body>
</html>