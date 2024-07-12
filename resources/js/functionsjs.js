$(document).ready(function () {
    
        $('#login_password').on('click', function() {
            var login_userid = $("#login_userid").val();
            if(login_userid ==  null){
            $(".login_form_userid").addClass("border border-danger")    
            alertify.set('notifier','position', 'top-center');
            alertify.error('Select Username');
            return false
        }
           
        });
        $('#login_userid').on('change', function() {
            var login_userid = $("#login_userid").val();
        
            // Remove error state when a value is selected
            if (login_userid != null) {
                $(".login_form_userid").removeClass("border border-danger");
                $("#login_userid_error").remove();
            }
        });


    $('#login_form').submit(function(e) {
        
        e.preventDefault();
        var login_userid = $("#login_userid").val();
        var login_password = $("#login_password").val();

    $("#login_userid_error").remove();    
    $("#login_password_error").remove();

if(login_userid == null){
    $(".login_form_userid").addClass("border border-danger");
    $(".login_form_userid").after("<p id='login_userid_error' class='text-danger login_userid_error'>Select Username</p>")
    alertify.set('notifier','position', 'top-center');
    alertify.error('Select Username');
    return false
}

if(login_password.length < 3){
    $(".login_form_password").addClass("border border-danger")
    alertify.set('notifier','position', 'top-center');
    alertify.error('Check Password');
    $(".login_form_password").after("<p  id='login_password_error' class='text-danger'>Check Password</p>")
    return false
}

        let formData = new FormData(this);
        
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            type: 'POST',
            url: '/employees/login',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === "success") {
                    
                    setTimeout(() => {
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.success(response.message);
                        window.location.href = "/admin/dashboard";
                    }, 1000);
                } else if (response.status === "error") {
                   
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error(response.message);
                    setTimeout(() => {
                        window.location.href = "/login";
                    }, 1000);
                }
            },
            error: function(response) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error('Something went wrong');
            }
        });
    });
    
    
    var register_clicked_button = null;

    $('button').on('click', function() {
        register_clicked_button = $(this).attr('id');
        // Optionally, you can submit the form here
        // $('#myForm').submit();
    });


        $('#register_employee_form').submit(function(e) {
            e.preventDefault();
    
            // Define validation function
            function validateInput(selector, errorMessage, customValidation = null, required = true) {
                var value = $(selector).val();
                if(value){
                    value=value.trim();
                }
                if ((required && !value) || (value && customValidation && !customValidation(value))) {
                    $(selector).addClass('is-invalid');
                    $(selector).next('.invalid-feedback').remove(); // Remove existing error message
                    $(selector).after('<div class="invalid-feedback">' + errorMessage + '</div>');

                    $(selector).on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });
                    return false;
                } else {
                    $(selector).removeClass('is-invalid');
                    $(selector).next('.invalid-feedback').remove();
                    return true;
                }
            }
    
            // Custom validation functions
            function validatePhone(value) {
                var phoneRegex = /^[0-9]{6,13}$/;
                return phoneRegex.test(value);
            }
    
            function validatePassword(value) {
                return value.length >= 3;
            }
    
            function validateEmail(value) {
                var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(value);
            }
    
            function validateRole(value) {
                return value !== null && value !== '';
            }
    
            // Validate each input field
            var isValidFirstName = validateInput("#register_first_name", "Enter First Name");
            var isValidMiddleName = validateInput("#register_middle_name", "Middle Name is required.", null, false);
            var isValidLastName = validateInput("#register_last_name", "Enter Last Name");
            var isValidIdNo = validateInput("#register_id_no", "Enter ID Number");
            var isValidIdNo = validateInput("#register_staff_no", "Enter Staff Number");
            var isValidPhone = validateInput("#register_phone", "Invalid Phone Number", validatePhone);
            var isValidEmail = validateInput("#register_email", "Invalid Email", validateEmail, false);
            var isValidPassword = validateInput("#register_password", "Check password", validatePassword);
            var isValidRoleId = validateInput("#register_role_id", "Select Role ID", validateRole, true);
           
            var isValidSecondPhone = validateInput("#register_second_phone", "Second Phone Number is invalid.", validatePhone, false);
            var isValidPhyAddress = validateInput("#register_phy_address", "Physical Address is required.", null, false);
          
            // If all fields are valid, submit the form or perform your desired action
            if (isValidFirstName && isValidMiddleName && isValidLastName && isValidIdNo && isValidPhone &&
                isValidSecondPhone && isValidEmail && isValidPhyAddress && isValidRoleId && isValidPassword) {
                // All fields are valid, proceed with form submission or other actions
                let formData = new FormData(this);
        
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: '/employee/register',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === "success") {
                            if(register_clicked_button=='register_save_view'){
                                setTimeout(() => {
                                alertify.set('notifier', 'position', 'top-center');
                                alertify.success(response.message);
                                window.location.href = "/employee/view";
                            }, 1000);}
                            else{
                                setTimeout(() => {
                                    alertify.set('notifier', 'position', 'top-center');
                                    alertify.success(response.message);
                                    window.location.href = "/employee/register";
                                }, 1000);
                            }
                        } else if (response.status === "error") {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.alert(response.message, function(){
                                    alertify.message('OK');
                                });
                            // setTimeout(() => {
                            //     window.location.href = "/dashboard";
                            // }, 1000);
                        }
                    },
                    error: function(response) {
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.error('Something went wrong');
                    }
                });
            }
        });
    
    

       
















});