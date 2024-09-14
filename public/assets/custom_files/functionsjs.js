// import $ from 'jquery';
// window.$ = window.jQuery = $; 

$(function() {
    let url_query_string = window.location.search;
    const getPath = window.location.pathname;
    const view_supplier_path = "/suppliers/view/";
    if (getPath.startsWith(view_supplier_path)) {
        var encoded_supplier_id = getPath.substring(view_supplier_path.length);
    var urlQuery = "?Query=" + encoded_supplier_id;
    url_query_string = urlQuery;
    } 
    const getIdURL = window.location.href;
    const url_batch_id =getIdURL.split('/').pop();

    var submitButton = document.querySelector('button[type="submit"]');
    var adminLoginUrlClickCount = 0;

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
          
            $.get('/user-role/'+login_userid, function (data) {
                if(data.user_role_id != 1){
                   
                $('#remember_me_class').hide();
            }

            });
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
                    sessionStorage.setItem('successMessage', response.message);
                        window.location.href = response.intendedUrl;
                } else if (response.status === "error") {
                   
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error(response.message);
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
            var isValidIdNo = validateInput("#register_id_no", "Enter ID Number",null, false);
            var isValidStaffNo = validateInput("#register_staff_no", "Staff number is required.", null, false);
            var isValidPhone = validateInput("#register_phone", "Invalid Phone Number", validatePhone);
            var isValidEmail = validateInput("#register_email", "Invalid Email", validateEmail, false);
            var isValidPassword = validateInput("#register_password", "Check password", validatePassword);
            var isValidRoleId = validateInput("#register_role_id", "Select Permission Level 1", validateRole, true);
           
            var isValidSecondPhone = validateInput("#register_second_phone", "Second Phone Number is invalid.", validatePhone, false);
            var isValidPhyAddress = validateInput("#register_phy_address", "Physical Address is required.", null, false);
          
            // If all fields are valid, submit the form or perform your desired action
            if (isValidFirstName && isValidMiddleName && isValidLastName && isValidIdNo && isValidPhone &&
                isValidSecondPhone && isValidEmail && isValidPhyAddress && isValidRoleId && isValidPassword && isValidStaffNo) {
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
                            sessionStorage.setItem('successMessage', response.message);
                            if(register_clicked_button=='register_save_view'){
                                
                                    window.location.href = "/employee/view/"+btoa(response.user_id);
                           
                        }
                            else{
                               
                                    window.location.reload();
                               
                            }
                        } 
                        else if (response.status === "error") {
                            printErrorMsg(response.message);
                            
                        }
                    },
                    error: function(response) {
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.error('Something went wrong');
                    }
                });

                
            }
        });

        $('#update_employee_form').submit(function(e) {
            e.preventDefault();
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
            var isValidIdNo = validateInput("#register_id_no", "Enter ID Number", null, false);
            var isValidStaffNo = validateInput("#register_staff_no", "Staff number is required.", null, false);
            var isValidPhone = validateInput("#register_phone", "Invalid Phone Number", validatePhone);
            var isValidEmail = validateInput("#register_email", "Invalid Email", validateEmail, false);
            var isValidSecondPhone = validateInput("#register_second_phone", "Second Phone Number is invalid.", validatePhone, false);
            var isValidPhyAddress = validateInput("#register_phy_address", "Physical Address is required.", null, false);
          
            // If all fields are valid, submit the form or perform your desired action
            if (isValidFirstName && isValidMiddleName && isValidLastName && isValidIdNo && isValidPhone &&
                isValidSecondPhone && isValidEmail && isValidPhyAddress && isValidStaffNo) {
                // All fields are valid, proceed with form submission or other actions
                let formData = new FormData(this);
        
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: '/employee/update',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === "success") {
                            sessionStorage.setItem('successMessage', response.message);
                                window.location.reload();
                        } 
                        else if (response.status === "error") {
                            printErrorMsg(response.message);
                        }
                    },
                    error: function(response) {
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.error('Something went wrong');
                    }
                });

                
            }
        });

       
            var table = $('#active_employees_table').DataTable({
                processing: true,
                serverSide: true,
                "order": [] ,
                "pageLength": 500, 
                ajax: "/employee/list-active",
               
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    {data: 'full_name', name: 'full_name'},
                    {data: 'details', name: 'details'},
                    {data: 'role_name', name: 'role_name'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
               
          });

          var table = $('#deleted_employees_table').DataTable({
            processing: true,
            serverSide: true,
            "order": [] ,
            "pageLength": 500,
            ajax: "/employee/list-deleted",
           
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                {data: 'full_name', name: 'full_name'},
                {data: 'details', name: 'details'},
                {data: 'role_name', name: 'role_name'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
           
      });
       

          $('body').on('click', '#update_employees_details', function () {
           
            $('#update_employees_modal').modal('show');
            var user_id = $(this).data('id');
            var action_url= $('#action_url').val(); 
           
            $.get('/employee/update/'+user_id, function (data) {
               
                $('#update_employees_modal').modal('show');
                $('#update_user_id').val(data.id);
                $('#register_first_name').val(data.first_name);
                $('#register_middle_name').val(data.middle_name);
                $('#register_last_name').val(data.last_name);
                $('#register_staff_no').val(data.staff_no);
                $('#register_phone').val(data.phone);
                $('#register_second_phone').val(data.second_phone);
                $('#register_role_id').val(data.role_id);
                $('#register_id_no').val(data.id_no);
                $('#register_email').val(data.email);
                $('#register_phy_address').val(data.phy_address);
                
            })
           
          });
          $('body').on('click', '#update_permission_level_button', function () {
           
            var user_id = $(this).data('id');
           
            $.get('/edit-permission-level/'+user_id, function (data) {
                $('#user_id').val(user_id);
                $('#update_user_role_modal').modal('show');
                var roleSelect = $('#register_role_id');
                roleSelect.empty(); 
                $.each(data.roles, function(value, label) {
                var isSelected = data.userRole === label ? 'selected' : '';
                var optionHtml = `<option value="${value}" ${isSelected}>${label}</option>`;
                roleSelect.append(optionHtml);
            });
                
            })
           
          });

          $('#update_role_form').submit(function(e) {
       
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
            var isValidName = validateInput("#role_name", "Enter Role Name");
           
           
            
            // If all fields are valid, submit the form or perform your desired action
            if (isValidName) {
                // All fields are valid, proceed with form submission or other actions
                let formData = new FormData(this);
        
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: '/update-role',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === "success") {
                            sessionStorage.setItem('successMessage', response.message);
                                window.location.href = "/show-role/"+btoa(response.role_id);
                           
                        } 
                        else if (response.status === "error") {
                           
                            printRolesErrorMsg(response.message);
                            
                        }
                    },
                    error: function(response) {
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.error('Something went wrong');
                    }
                });
    
                
            }
        }); 

          function printErrorMsg (msg) {
            $.each( msg, function( key, value ) {

                if (isWordPresent(value, 'email')){
                    $("#register_email").addClass('is-invalid');
                    $("#register_email").next('.invalid-feedback').remove(); 
                    $("#register_email").after('<div class="invalid-feedback">' + value + '</div>');
                    $("#register_email").on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });
                    
                }
                else if (isWordPresent(value, 'phone')){
                    $("#register_phone").addClass('is-invalid');
                    $("#register_phone").next('.invalid-feedback').remove(); 
                    $("#register_phone").after('<div class="invalid-feedback">' + value + '</div>');
                    $("#register_phone").on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });}
                else if (isWordPresent(value, 'id')){
                    $("#register_id_no").addClass('is-invalid');
                    $("#register_id_no").next('.invalid-feedback').remove(); 
                    $("#register_id_no").after('<div class="invalid-feedback">' + value + '</div>');
                    $("#register_id_no").on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });}
                else if (isWordPresent(value, 'staff no')){
                    $("#register_staff_no").addClass('is-invalid');
                    $("#register_staff_no").next('.invalid-feedback').remove(); 
                    $("#register_staff_no").after('<div class="invalid-feedback">' + value + '</div>');
                    $("#register_staff_no").on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });}
                else if (isWordPresent(value, 'name')){
                    $("#register_first_name").addClass('is-invalid');
                    $("#register_first_name").next('.invalid-feedback').remove(); 
                    $("#register_first_name").after('<div class="invalid-feedback">' + value + '</div>');
                    $("#register_first_name").on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });
                    $("#register_last_name").addClass('is-invalid');
                    $("#register_last_name").next('.invalid-feedback').remove(); 
                    $("#register_last_name").after('<div class="invalid-feedback">' + value + '</div>');
                    $("#register_last_name").on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });}
                else if (isWordPresent(value, 'password')){
                    $("#register_password").addClass('is-invalid');
                    $("#register_password").next('.invalid-feedback').remove(); 
                    $("#register_password").after('<div class="invalid-feedback">' + value + '</div>');
                    $("#register_password").on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });} 
                    else{
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.error(value);
                    }
                
               
            });
           
          }

         
          $('#back_button').on('click',function(e){
            e.preventDefault();
            window.history.back();
          });

          $('#clear_error').on('click',function(e){
            e.preventDefault();
            
            $(".print-error-msg").css('display','none');
          });

            $('#delete_user').on('click',function(e){
                    e.preventDefault();
                   
                var user_id = $('#delete_user_id').val();
                $.ajax({
                    type: "get",
                        url: "/employee/delete/"+user_id,
                    success: function (response) {
                        if (response.status === "success") {
                            sessionStorage.setItem('successMessage', response.message);
                             window.location.reload();
                    } 
                    else if (response.status === "error") {
                        alertify.set('notifier', 'position', 'top-center');
                            alertify.error(response.message);
                    }
                    },
                    error: function (response) {
                        alertify.set('notifier', 'position', 'top-center');
                            alertify.error('An error occurred please try again later');
                    }
                });

          });

          $('#activate_user').on('click',function(e){
            e.preventDefault();
           
        var user_id = $('#activate_user_id').val();
        $.ajax({
            type: "get",
                url: "/employee/activate/"+user_id,
            success: function (response) {
                if (response.status === "success") {
                    sessionStorage.setItem('successMessage', response.message);
                        window.location.reload();
            } 
            else if (response.status === "error") {
                alertify.set('notifier', 'position', 'top-center');
                    alertify.error(response.message);
            }
            },
            error: function (response) {
                alertify.set('notifier', 'position', 'top-center');
                    alertify.error('An error occurred please try again later');
            }
        });

  });


          $('body').on('click', '#delete_user_button',function(e){
            e.preventDefault();
            var user_id = $(this).data('id');

          $('#delete_user_modal').modal('show');
          $('#delete_user_id').val(user_id);
        });

        $('body').on('click', '#activate_user_button',function(e){
            e.preventDefault();
            var user_id = $(this).data('id');
          $('#activate_user_modal').modal('show');
          $('#activate_user_id').val(user_id);
        });


        function isWordPresent(sentence, word)
        {
            let s = sentence.split(" ");
            for ( let temp=0;temp<s.length;temp++)
            {
                if (s[temp] == (word) )
                {
                    return true;
                }
            }
            return false;
        }

        
            $('#import_and_view_form').submit(function(e) {
                e.preventDefault(); // Prevent the default form submission
                var file_upload = $("#file_name").val();
        
                // Validate file upload
                if (file_upload.length < 1) {
                    $("#file_name").addClass('is-invalid');
                    $("#file_name").next('.invalid-feedback').remove(); // Remove existing error message
                    $("#file_name").after('<div class="invalid-feedback">Select file</div>');
                    $('#file_name').on('change', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });
                    return false;
                }
        
                // Validate file type
                var allowedFiles = [".csv"];
                var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
                if (!regex.test(file_upload.toLowerCase())) {
                    $("#file_name").addClass('is-invalid');
                    $("#file_name").next('.invalid-feedback').remove(); // Remove existing error message
                    $("#file_name").after('<div class="invalid-feedback">Kindly enter a valid CSV file</div>');
        
                    $("#file_name").off('keyup').on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });
                    return false;
                }
                $('#loading_gif').show();
                let formData = new FormData(this);
        
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: '/import-and-view',
                    data: formData,
                    
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        $('#loading_gif').hide();
                        if (response.status === "success") {
                          
                            sessionStorage.setItem('successMessage', response.message);
                            window.location.href = '/import-and-view';
                           
                        } else if (response.status === "error") {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.error(response.message);
                        }
                    },
                    error: function(response) {
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.error('Something went wrong');
                    }
                });

                
            });

            
        $('#purchaseOrdersTable').DataTable({
            "order": [] ,
            "pageLength": 500,
        });

            $('#save_and_view_with_prices').on('click', function() {
                
              var with_prices = 'Yes'; 
              saveAndView(with_prices)
            });

            $('#save_and_view_with_no_prices').on('click', function() {
                
              var with_prices = 'No'; 
              saveAndView(with_prices)
            });

            $('#save_and_view').on('click', function() {
                var with_prices = 'Table'; 
                saveAndView(with_prices)
              });
           function saveAndView(with_prices){
            var batch_details = {
                'batch_name':$('#upload_and_view_batch_name').val(),
                'supplier_id':$('#upload_and_view_supplier_id').val(),
                'order_no':$('#upload_and_view_order_number').val(),
            };
            var tableData = [];
            
            $('#purchaseOrdersTable tbody tr').each(function(row, tr) {
                var rowData = {
                    
                    'product_name': $(tr).find('#product_name').val(),
                    'quantity': $(tr).find('#quantity').val(),
                    'price': $(tr).find('#price').val(),
                    
                    
                };
                tableData.push(rowData);
            });
          
            // Example AJAX submission
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'POST',
                url: '/save-and-view', // Adjust the route as needed
                data: {
                    '_token': $('meta[name="csrf-token"]').attr('content'),
                    'data': tableData,
                    'batch_details':batch_details
                },
                success: function(response) {
                    
                    if (response.status === "success") {
                        sessionStorage.setItem('successMessage', response.message);
                       
                        if(with_prices == 'Table'){
                            window.location.href = "/view/batch/" + response.batch_id;
                        }
                        else if(with_prices == 'Yes'){
                            window.location.href =  "/orders/pdf/" + response.batch_id;
                        }else{
                            window.location.href = "/orders/no-cost-pdf/" + response.batch_id;
                        }
                    } else if (response.status === "error") {
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.error(response.message);
                    }
                },
                error: function(response) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Something went wrong');
                }
            });

            }
            $('#save_and_send').on('click', function() {
                saveAndSend('Yes')
            });

            $('#save_and_send_with_no_prices').on('click', function() {
              
                saveAndSend('No')

            });
            
           
               function saveAndSend(with_prices){
                var batch_details = {
                    'batch_name':$('#upload_and_view_batch_name').val(),
                    'supplier_id':$('#upload_and_view_supplier_id').val(),
                    'order_no':$('#upload_and_view_order_number').val(),
                };
                var tableData = [];
                
                $('#purchaseOrdersTable tbody tr').each(function(row, tr) {
                    var rowData = {
                        
                        'product_name': $(tr).find('#product_name').val(),
                        'quantity': $(tr).find('#quantity').val(),
                        'price': $(tr).find('#price').val(),
                        
                        
                    };
                    tableData.push(rowData);
                });
              
                // Example AJAX submission
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    url: '/save-and-view', 
                    data: {
                        '_token': $('meta[name="csrf-token"]').attr('content'),
                        'data': tableData,
                        'batch_details':batch_details
                    },
                    success: function(response) {
                       
                        if (response.status === "success") {
                            sessionStorage.setItem('successMessage', response.message);
                            var url = "/make-orders/" + response.batch_id;

                            url += "?Query=" + encodeURIComponent(btoa(with_prices));
                            
                            window.location.href = url;
                             
                        } else if (response.status === "error") {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.error(response.message);
                        }
                    },
                    error: function(response) {
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.error('Something went wrong');
                    }
                });
           
            }

                var table = $('#view_batch_table').DataTable({
                    processing: true,
                    serverSide: true,
                    "order": [] ,
                    "pageLength": 500,
                    ajax: {
                        url: "/view/batch/" + $('#saved_batch_id').val(),
                        dataSrc: function(json) {
                            // Append the 'Total' row to the data
                            json.data.push({
                                DT_RowClass: 'text-end fw-bold',
                                DT_RowIndex: '',
                                sub_total:  `${json.sub_total_sum}`,
                                product_name: '', 
                                quantity: '',
                                price_quantity: '<strong>Total (KSH):</strong>',
                                
                            });
                            return json.data;
                        }
                       
                    },
                    columns: [
                        { data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            className: 'text-nowrap',
                            width: '50px', },
                        { 
                            data: 'quantity', 
                            name: 'quantity',
                            className: 'text-nowrap',
                            width: '100px',
                        },
                        { 
                            data: 'product_name', 
                            name: 'product_name',
                            className: 'text-wrap w-auto',
                            
                        },
                        { 
                            data: 'price_quantity', 
                            name: 'price_quantity',
                            className: 'text-end text-nowrap',
                            width: '100px',
                        },
                        {
                            data: 'sub_total',
                            name: 'sub_total',
                            className: 'text-end',
                            width: '100px',
                            render: $.fn.dataTable.render.number(',', '.', 0, '')
                        }
                    ],
                   
                });
            
                var table = $('#view_batch_table_no_cost').DataTable({
                    processing: true,
                    serverSide: true,
                    "order": [] ,
                    "pageLength": 500,
                    ajax: {
                        url: "/view/batch/" + $('#saved_batch_id').val(),
                       
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'quantity', name: 'quantity' },
                        { data: 'product_name', name: 'product_name' },
                       
                        

                    ],
                   
                });
            
                function appendTotalRowPurchaseOrdersTable() {
                    const totalRow = `
                        <tr>
                            <td class="no-border" style="width: 25px;"></td> 
                            <td class="no-border"></td> 
                            <td class="no-border"></td> 
                            <td><b>Total(KSH)</b></td> 
                            <td id="total" class="text-end fw-bold"><b><input type='text' id='total1' name='total1'></b></td>
                        </tr>
                    `;
                    $('#purchaseOrdersTable tbody').append(totalRow);
                }
                
                function updateSubtotalPurchaseOrdersTable($row) {
                    const quantity = parseFloat($row.find('#quantity').val()) || 0;
                    const price = parseFloat($row.find('#price').val()) || 0;
                    const subtotal = quantity * price;
                
                    // Format subtotal without decimal places and add thousand separators
                    const formattedSubtotal = subtotal.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
                    $row.find('.subtotal').html(formattedSubtotal);
                    
                    updateTotalPurchaseOrdersTable();
                }
                
                
                function updateTotalPurchaseOrdersTable() {
                    let total = 0;
                    $('.subtotal').each(function() {
                        total += parseFloat($(this).text().replace(/,/g, '')) || 0;
                    });
                
                    // Format total without decimal places and add thousand separators
                    const formattedTotal = total.toLocaleString('en-US', { minimumFractionDigits: 0, maximumFractionDigits: 0 });
                    $('#total').html(  formattedTotal );
                }
       
           appendTotalRowPurchaseOrdersTable();
        
           updateTotalPurchaseOrdersTable();


       $('#purchaseOrdersTable').on('keyup', 'input', function () {
        
        var row = $(this).closest('tr');
        var total = 0;
        updateSubtotalPurchaseOrdersTable(row)
        
    });

    $('#create_supplier_form').submit(function(e) {
       
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

       

        function validateEmail(value) {
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(value);
        }

       

        // Validate each input field
        var isValidName = validateInput("#create_supplier_name", "Enter Suppliers Name");
        var isValidKra = validateInput("#create_supplier_kra", "Enter Suppliers KRA PIN", null, false);
        var isValidNumber = validateInput("#create_supplier_number", "Enter Suppliers Number", null, false);
        var isValidPhone = validateInput("#create_supplier_phone", "Invalid Phone Number", validatePhone);
        var isValidEmail = validateInput("#create_supplier_email", "Invalid Email", validateEmail);
       
        var isValidSecondPhone = validateInput("#create_supplier_second_phone", "Second Phone Number is invalid.", validatePhone, false);
        var isValidPhyAddress = validateInput("#create_supplier_phy_address", "Physical Address is required.", null, false);
      
        // If all fields are valid, submit the form or perform your desired action
        if (isValidName && isValidPhone && isValidSecondPhone && isValidEmail && isValidPhyAddress && isValidKra && isValidNumber) {
            // All fields are valid, proceed with form submission or other actions
            let formData = new FormData(this);
    
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                type: 'POST',
                url: '/supplier/create',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === "success") {
                        sessionStorage.setItem('successMessage', response.message);
                        if(register_clicked_button=='register_save_view'){
                            
                            window.location.href = "/suppliers/view/"+btoa(response.supplier_id);
                       
                    }
                        else{
                          
                                window.location.reload();
                           
                        }
                    } 
                    else if (response.status === "error") {
                       
                        printSupplierErrorMsg(response.message);
                        
                    }
                },
                error: function(response) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Something went wrong');
                }
            });

            
        }
    });

    function printSupplierErrorMsg (msg) {
        $.each( msg, function( key, value ) {
            if (isWordPresent(value, 'email')){
                $("#create_supplier_email").addClass('is-invalid');
                $("#create_supplier_email").next('.invalid-feedback').remove(); 
                $("#create_supplier_email").after('<div class="invalid-feedback">' + value + '</div>');
                $("#create_supplier_email").on('keyup', function() {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                });
                
            } 
            else if (isWordPresent(value, 'number')){
                $("#create_supplier_number").addClass('is-invalid');
                $("#create_supplier_number").next('.invalid-feedback').remove(); 
                $("#create_supplier_number").after('<div class="invalid-feedback">' + value + '</div>');
                $("#create_supplier_number").on('keyup', function() {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                });}
            else if (isWordPresent(value, 'phone')){
                $("#create_supplier_phone").addClass('is-invalid');
                $("#create_supplier_phone").next('.invalid-feedback').remove(); 
                $("#create_supplier_phone").after('<div class="invalid-feedback">' + value + '</div>');
                $("#create_supplier_phone").on('keyup', function() {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                });}
            else if (isWordPresent(value, 'kra')){
                $("#create_supplier_kra").addClass('is-invalid');
                $("#create_supplier_kra").next('.invalid-feedback').remove(); 
                $("#create_supplier_kra").after('<div class="invalid-feedback">' + value + '</div>');
                $("#create_supplier_kra").on('keyup', function() {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                });}
            else if (isWordPresent(value, 'staff no')){
                $("#register_staff_no").addClass('is-invalid');
                $("#register_staff_no").next('.invalid-feedback').remove(); 
                $("#register_staff_no").after('<div class="invalid-feedback">' + value + '</div>');
                $("#register_staff_no").on('keyup', function() {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                });}
            else if (isWordPresent(value, 'name')){
                $("#create_supplier_name").addClass('is-invalid');
                $("#create_supplier_name").next('.invalid-feedback').remove(); 
                $("#create_supplier_name").after('<div class="invalid-feedback">' + value + '</div>');
                $("#create_supplier_name").on('keyup', function() {
                    $(this).removeClass('is-invalid');
                    $(this).next('.invalid-feedback').remove();
                });
               }
               else{
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(value);
            }
        });
      }

      var table = $('#active_suppliers_table').DataTable({
        processing: true,
        serverSide: true,
        "order": [] ,
        "pageLength": 500,
        ajax: "/suppliers/list-active",
       
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            {data: 'supplier_name', name: 'supplier_name'},
            {data: 'supplier_phone', name: 'supplier_phone'},
            {data: 'supplier_email', name: 'supplier_email'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
       
  });

  $('#update_supplier_form').submit(function(e) {
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
    var isValidName = validateInput("#create_supplier_name", "Enter Suppliers Name");
    var isValidKra = validateInput("#create_supplier_kra", "Enter Suppliers KRA PIN", null, false);
    var isValidPhone = validateInput("#create_supplier_phone", "Invalid Phone Number", validatePhone);
    var isValidEmail = validateInput("#create_supplier_email", "Invalid Email", validateEmail);
   
    var isValidSecondPhone = validateInput("#create_supplier_second_phone", "Second Phone Number is invalid.", validatePhone, false);
    var isValidPhyAddress = validateInput("#create_supplier_phy_address", "Physical Address is required.", null, false);
  
    // If all fields are valid, submit the form or perform your desired action
    if (isValidName && isValidPhone && isValidSecondPhone && isValidEmail && isValidPhyAddress && isValidKra) {
        // All fields are valid, proceed with form submission or other actions
        let formData = new FormData(this);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            type: 'POST',
            url: '/supplier/update',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === "success") {
                    sessionStorage.setItem('successMessage', response.message);
                        window.location.reload();
                  
                } 
                else if (response.status === "error") {
                    printSupplierErrorMsg(response.message);
                    
                }
            },
            error: function(response) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error('Something went wrong');
            }
        });

        
    }
});

$('body').on('click', '#update_suppliers_details', function () {
    var supplier_id = $(this).data('id');
    var action_url= $('#action_url').val();
    $('#update_supplier_modal').modal('show'); 
    $.get('/suppliers/update/'+supplier_id, function (data) {
        $('#update_supplier_id').val(data.id);
        $('#create_supplier_name').val(data.supplier_name);
        $('#create_supplier_number').val(data.supplier_number);
        $('#create_supplier_phone').val(data.supplier_phone);
        $('#create_supplier_kra').val(data.supplier_second_phone);
        $('#create_supplier_second_phone').val(data.supplier_second_phone);
        $('#create_supplier_email').val(data.supplier_email);
        $('#create_supplier_phy_address').val(data.supplier_phy_address);
        
    })
   
  });

  $('#delete_supplier').on('click',function(e){
    e.preventDefault();
   
var supplier_id = $('#delete_supplier_id').val();
$.ajax({
    type: "get",
        url: "/supplier/delete/"+supplier_id,
    success: function (response) {
        if (response.status === "success") {
            sessionStorage.setItem('successMessage', response.message);
            window.location.reload();
    } 
    else if (response.status === "error") {
        sessionStorage.setItem('errorMessage', response.message);
        window.location.reload();
       
    }
    },
    error: function (response) {
        alertify.set('notifier', 'position', 'top-center');
            alertify.error('An error occurred please try again later');
    }
});

});
 
$('body').on('click', '#delete_supplier_button',function(e){
    e.preventDefault();
    var supplier_id = $(this).data('id');

  $('#delete_supplier_modal').modal('show');
  $('#delete_supplier_id').val(supplier_id);
});

var table = $('#deleted_suppliers_table').DataTable({
    processing: true,
    serverSide: true,
    "order": [] ,
    "pageLength": 500,
    ajax: "/suppliers/list-deleted",
   
    columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
        {data: 'supplier_name', name: 'supplier_name'},
        {data: 'supplier_phone', name: 'supplier_phone'},
        {data: 'supplier_email', name: 'supplier_email'},
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
   
});

$('body').on('click', '#activate_supplier_button',function(e){
    e.preventDefault();
    var supplier_id = $(this).data('id');
  $('#activate_supplier_modal').modal('show');
  $('#activate_supplier_id').val(supplier_id);
});

$('#activate_supplier').on('click',function(e){
    e.preventDefault();
   
var supplier_id = $('#activate_supplier_id').val();
$.ajax({
    type: "get",
        url: "/supplier/activate/"+supplier_id,
    success: function (response) {
        if (response.status === "success") {
            sessionStorage.setItem('successMessage', response.message);
            window.location.reload();
    } 
    else if (response.status === "error") {
        sessionStorage.setItem('errorMessage', response.message);
            window.location.reload();
         
    }
    },
    error: function (response) {
        alertify.set('notifier', 'position', 'top-center');
            alertify.error('An error occurred please try again later');
    }
});

});

var imported_batches_url = "/orders/list-imported-batches";
 if (url_query_string) {
    imported_batches_url += url_query_string;
 }
var table = $('#imported_batches_table').DataTable({
    processing: true,
    serverSide: true,
    "order": [] ,
    "pageLength": 500,
    ajax: imported_batches_url,
   "order": [] ,
    columns: [
        {data: 'id', name: 'id'},
        {data: 'created_date', name: 'created_date'},
        {data: 'order_no', name: 'order_no'},
        {data: 'supplier_name', name: 'supplier_name'},
        {data: 'order_count', name: 'order_count'},
       
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
   
});

var ordered_batches_url = '/orders/list-ordered-batches'
if (url_query_string) {
    ordered_batches_url += url_query_string;
 }
var table = $('#ordered_batches_table').DataTable({
    processing: true,
    serverSide: true,
    "order": [] ,
    "pageLength": 500,
    ajax: ordered_batches_url,
    columns: [
        {data: 'send_batch_id', name: 'send_batch_id'},
        {data: 'created_date', name: 'created_date'},
        {data: 'order_no', name: 'order_no'},
        {data: 'supplier_name', name: 'supplier_name'},
        {data: 'order_count', name: 'order_count'},
       
        {data: 'action', name: 'action', orderable: false, searchable: false},
    ]
   
});

$('#update_batch_button').on('click', function() {
    updateAndView('Table') 
});
$('#update_and_view_with_price').on('click', function() {
    updateAndView('Yes') 
});
$('#update_and_view_no_price').on('click', function() {
   
    updateAndView('No') 
});
function updateAndView(with_prices){
        var batch_details = {
            'batch_id':$('#upload_and_view_batch_id').val(),
            'batch_name':$('#upload_and_view_batch_name').val(),
            'supplier_id':$('#upload_and_view_supplier_id').val(),
            'order_no':$('#upload_and_view_order_number').val(),
        };
        var tableData = [];
        
        $('#purchaseOrdersTable tbody tr').each(function(row, tr) {
            var rowData = {
                'product_name': $(tr).find('#product_name').val(),
                'quantity': $(tr).find('#quantity').val(),
                'price': $(tr).find('#price').val(),
                
            };
            tableData.push(rowData);
        });
      
        // Example AJAX submission
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            url: '/orders/update-batch', // Adjust the route as needed
            data: {
                '_token': $('meta[name="csrf-token"]').attr('content'),
                'data': tableData,
                'batch_details':batch_details
            },
            success: function(response) {
                
                if (response.status === "success") {
                    sessionStorage.setItem('successMessage', response.message);

                    if(with_prices == 'Table'){

                        window.location.href = "/view/batch/" + response.batch_id;
                         }
                        else if(with_prices == 'Yes'){
                            window.location.href =  "/orders/pdf/" + response.batch_id;
                        }else{
                            window.location.href = "/orders/no-cost-pdf/" + response.batch_id;
                        }
                  
                } else if (response.status === "error") {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error(response.message);
                }
            },
            error: function(response) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error('Something went wrong');
            }
        });
}

$('#update_and_make_order_button').on('click', function() {
          
    updateAndSend('Yes')


});

$('#update_and_make_order_with_no_prices_button').on('click', function() {
  
    updateAndSend('No')

});

function updateAndSend(with_prices){
    var batch_details = {
        'batch_id':$('#upload_and_view_batch_id').val(),
        'batch_name':$('#upload_and_view_batch_name').val(),
        'supplier_id':$('#upload_and_view_supplier_id').val(),
        'order_no':$('#upload_and_view_order_number').val(),
    };
    var tableData = [];
    
    $('#purchaseOrdersTable tbody tr').each(function(row, tr) {
        var rowData = {
            
            'product_name': $(tr).find('#product_name').val(),
            'quantity': $(tr).find('#quantity').val(),
            'price': $(tr).find('#price').val(),
            
            
        };
        tableData.push(rowData);
    });
  
    // Example AJAX submission
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: '/orders/update-batch', // Adjust the route as needed
        data: {
            '_token': $('meta[name="csrf-token"]').attr('content'),
            'data': tableData,
            'batch_details':batch_details
        },
        success: function(response) {
            
            if (response.status === "success") {
                sessionStorage.setItem('successMessage', response.message);
                var url = "/make-orders/" + response.batch_id;

                url += "?Query=" + encodeURIComponent(btoa(with_prices));
                
                window.location.href = url;
               
            } else if (response.status === "error") {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(response.message);
            }
        },
        error: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Something went wrong');
        }
    });
}

$('body').on('click', '#delete_batch_order_button',function(e){
    e.preventDefault();
    var batch_id = $(this).data('id');

  $('#delete_batch_order_modal').modal('show');
  $('#delete_batch_id').val(batch_id);
});

$('#delete_batch_order').on('click',function(e){
    e.preventDefault();
   
var batch_id = $('#delete_batch_id').val();
$.ajax({
    type: "get",
        url: "/order-batch/delete/"+batch_id,
    success: function (response) {
        if (response.status === "success") {
            sessionStorage.setItem('successMessage', response.message);
            window.location.href = '/orders/list-imported-batches';
    } 
    else if (response.status === "error") {
        sessionStorage.setItem('errorMessage', response.message);
        window.location.reload();
    }
    },
    error: function (response) {
        alertify.set('notifier', 'position', 'top-center');
            alertify.error('An error occurred please try again later');
    }
});

});
 
$('body').on('click', '#make_order_modal_button', function(e) {
    e.preventDefault();
    let form = $('#make_order_form')[0]; // Get the form element
    let formData = new FormData(form); 
    $('#loading_gif').show(); 
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        type: 'POST',
        url: '/make-orders',
        data: formData,
       
        contentType: false,
        processData: false,
        success: function(response) {

            if (response.status === "success") {
                sessionStorage.setItem('successMessage', response.message);
                window.location.href = '/order-batch/view-send-order/' + response.batch_id;                
               $('#loading_gif').hide();
            } else if (response.status === "error") {

            $('#loading_gif').hide();
                alertify.set('notifier', 'position', 'top-center');
                alertify.error(response.message);

            }


        },
        error: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.error('Something went wrong');
        }
    });
});


$('body').on('click', '#make_order',function(e){
    e.preventDefault();
    
    var order_batch_id = $(this).data('id');
  $('#make_order_modal').modal('show');
  $('#delete_batch_id').val(order_batch_id);
});



$('#update_business_details_button').on('click',function(e){
    e.preventDefault();
  $('#update_business_details_modal').modal('show');
});

$('#update_email_content_button').on('click',function(e){
    e.preventDefault();
  $('#update_email_content_modal').modal('show');
});

$('#update_email_content_form').submit(function(e) {
    e.preventDefault();

    
        let formData = new FormData(this);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            type: 'POST',
            url: '/email-content/update',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === "success") {
                    sessionStorage.setItem('successMessage', response.message);
                    window.location.reload();
                      
                } 
                else if (response.status === "error") {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error(response.message);
                }
            },
            error: function(response) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error('Something went wrong');
            }
        });

        
    
});

$('#update_business_details_form').submit(function(e) {
    e.preventDefault();

    
        let formData = new FormData(this);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            type: 'POST',
            url: '/update/business-details',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === "success") {
                    sessionStorage.setItem('successMessage', response.message);
                    window.location.reload();
                       
                } 
                else if (response.status === "error") {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error(response.message);
                    
                }
            },
            error: function(response) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error('Something went wrong');
            }
        });

        
    
});


$('#update_systerm_name_button').on('click',function(e){
    e.preventDefault();
  $('#update_system_name_modal').modal('show');
});

$('#update_system_name_form').submit(function(e) {
    e.preventDefault();
        let formData = new FormData(this);

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            type: 'POST',
            url: '/system-name/update',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.status === "success") {
                    sessionStorage.setItem('successMessage', 'Edit Successfull');
                            window.location.reload();
                       
                } 
                else if (response.status === "error") {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error(response.message);
                    
                }
            },
            error: function(response) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.error('Something went wrong');
            }
        });

        
    
});


$("#make_order_add_cc").on('click', function(e) {
    e.preventDefault();
    
   var ccCounter= $('#people_cc').val();
    addCCField(ccCounter);
});






    if ($('#pdfPage').length) {
       
        function loadPdf() {
            var selectedOption = $('input[name="with_prices"]:checked').val();
            var batch_id = $('#batch_id').val();
            if(selectedOption=="Yes"){
                var action_url= '/orders/pdf/' + btoa(batch_id);
            }else{
                var action_url= '/orders/no-cost-pdf/' + btoa(batch_id);
            }
           
            $.ajax({
                url: action_url,
                type: 'GET',
                data: { option: selectedOption },
                success: function(response) {
                    if (response.pdfContent) {
                        var pdfContent = 'data:application/pdf;base64,' + response.pdfContent;
                        $('#pdfIframe').attr('src', pdfContent);
                    } else {
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.error('Fail to generate pdf');
                    }
                },
                error: function(xhr) {
                    console.log('Error:', xhr.responseText);
                    alertify.set('notifier', 'position', 'top-center');
                        alertify.error('Fail to generate pdf');
                }
            });
        }
        loadPdf();

        // Add event listener for radio button changes
        $('input[name="with_prices"]').change(function() {
            loadPdf();
        });
        }

        
        
            function addCCField(ccCounter) {
                ccCounter++;
                $('#people_cc').val(ccCounter);
                var rowDiv = document.createElement("div");
                rowDiv.className = "row mb-3";
                rowDiv.id = "cc_row_" + ccCounter;
        
                var colDiv = document.createElement("div");
                colDiv.className = "col-md-12 d-flex align-items-center";
        
                var formFloatingDiv = document.createElement("div");
                formFloatingDiv.className = "form-floating flex-grow-1 me-2"; // Flex-grow to fill the remaining space and margin-right for spacing
        
                var inputField = document.createElement("input");
                inputField.type = "email";
                inputField.className = "form-control";
                inputField.placeholder = "";
                inputField.name = "cc_email_" + ccCounter;
                inputField.id = "cc_email_" + ccCounter;
                inputField.required = true;
        
                var label = document.createElement("label");
                label.htmlFor = "cc_email_" + ccCounter;
                label.textContent = "Recipient " + ccCounter + " Email";
        
                var removeButton = document.createElement("button");
                removeButton.type = "button";
                removeButton.className = "btn  btn-outline-primary";
                removeButton.textContent = "Remove";
                removeButton.id = "make_order_remove_cc";
        
                formFloatingDiv.appendChild(inputField);
                formFloatingDiv.appendChild(label);
                colDiv.appendChild(formFloatingDiv);
                colDiv.appendChild(removeButton);
                rowDiv.appendChild(colDiv);
                ccEmailsContainer.appendChild(rowDiv);
        
                ccEmailsContainer.style.display = "block";
               
            }
        
            function removeCCField(id) {
                var rowDiv = document.getElementById("cc_row_" + id);
                ccEmailsContainer.removeChild(rowDiv);
                var ccCounter =  $('#people_cc').val();
                ccCounter--;
                $('#people_cc').val(ccCounter);
                if (ccCounter === 0) {
                    ccEmailsContainer.style.display = "none";
                    submitButton.setAttribute('disabled', 'true');

                   
                } else {
                    updateFieldAttributes();
                }
            }
        
            function updateFieldAttributes() {
                var rows = ccEmailsContainer.querySelectorAll(".row");
                var counter = 1;
        
                rows.forEach(function(row) {
                    var inputField = row.querySelector("input");
                    var label = row.querySelector("label");
                    var removeButton = row.querySelector("button");
        
                    inputField.name = "cc_email_" + counter;
                    inputField.id = "cc_email_" + counter;
                    label.htmlFor = "cc_email_" + counter;
                    label.textContent = "Recipient " + counter + " Email";
                    row.id = "cc_row_" + counter;
        
                    counter++;
                });
            }
        
           
        
            // Use event delegation for remove buttons
            $("#ccEmailsContainer").on('click', '#make_order_remove_cc', function() {
                var rowId = $(this).closest('.row').attr('id').split('_')[2];
                removeCCField(rowId);
            });

            $('#update_password_form').submit(function(e) {
                e.preventDefault();
            
                // Define validation function
                function validateInput(selector, errorMessage, customValidation = null, required = true, matchValue = null) {
                    var value = $(selector).val();
                    if (value) {
                        value = value.trim();
                    }
                    if ((required && !value) || (value && customValidation && !customValidation(value)) || (matchValue && value !== $(matchValue).val())) {
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
            
                function validatePassword(value) {
                    return value.length >= 3;
                }
            
                var isValidCurrentPassword = validateInput("#update_password_current_password", "Check Your Password", validatePassword);
                var isValidNewPassword = validateInput("#update_password_password", "Check User Password", validatePassword);
                var isValidConfirmPassword = validateInput("#update_password_password_confirmation", "Passwords do not match", validatePassword, true, "#update_password_password");
            
                if (isValidCurrentPassword && isValidNewPassword && isValidConfirmPassword) {
                    let formData = new FormData(this);
            
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: 'POST', // Use POST or PUT depending on your endpoint
                        url: '/password',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status === "success") {
                                sessionStorage.setItem('successMessage', response.message);
                                        window.location.reload();
                            } else if (response.status === "error") {
                                printConfirmPasswordErrorMsg(response.message);
                            }
                        },
                        error: function(response) {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.error('Something went wrong');
                        }
                    });
                }
            });
            
            function printConfirmPasswordErrorMsg (msg) {
                $.each( msg, function( key, value ) {
                  
                    if (isWordPresent(value, 'password')){
                        $("#update_password_current_password").addClass('is-invalid');
                        $("#update_password_current_password").next('.invalid-feedback').remove(); 
                        $("#update_password_current_password").after('<div class="invalid-feedback">' + value + '</div>');
                        $("#update_password_current_password").on('keyup', function() {
                            $(this).removeClass('is-invalid');
                            $(this).next('.invalid-feedback').remove();
                        });} else{
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.error(value);
                        }
                    
                   
                });
               
              }

              $('#admin_update_password_form').submit(function(e) {
                e.preventDefault();
            
                // Define validation function
                function validateInput(selector, errorMessage, customValidation = null, required = true, matchValue = null) {
                    var value = $(selector).val();
                    if (value) {
                        value = value.trim();
                    }
                    if ((required && !value) || (value && customValidation && !customValidation(value)) || (matchValue && value !== $(matchValue).val())) {
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
            
                function validateUser(value) {
                    return value !== null && value !== '';
                }
            
                function validatePassword(value) {
                    return value.length >= 3;
                }
            
                var isValidCurrentPassword = validateInput("#update_password_current_password", "Check Current Password", validatePassword);
                var isValidNewPassword = validateInput("#update_password_password", "Check New Password", validatePassword);
                var isValidConfirmPassword = validateInput("#update_password_password_confirmation", "Passwords do not match", validatePassword, true, "#update_password_password");
                var isValidUserId = validateInput("#update_user_id", "Select User", validateUser, true);
            
                if (isValidCurrentPassword && isValidNewPassword && isValidConfirmPassword && isValidUserId) {
                    let formData = new FormData(this);
            
                    // Debug: Log form data to ensure values are being captured
                    for (let pair of formData.entries()) {
                        console.log(pair[0] + ': ' + pair[1]);
                    }
            
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST', // Use POST or PUT depending on your endpoint
                        url: '/employee/update-password', 
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status === "success") {
                                sessionStorage.setItem('successMessage', response.message);
                                    window.location.reload();
                            } else if (response.status === "error") {
                                printConfirmPasswordErrorMsg(response.message);
                            }
                        },
                        error: function(response) {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.error('Something went wrong');
                        }
                    });
                }
            });

            $('#developers_login_form').submit(function(e) {
                e.preventDefault();
           
                // Define validation function
                function validateInput(selector, errorMessage, customValidation = null, required = true) {
                    var value = $(selector).val();
                    if (value) {
                        value = value.trim();
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
            
                function validateUser(value) {
                    return value !== null && value !== '';
                }
            
                function validatePassword(value) {
                    return value.length >= 3;
                }
            
                var isValid_password = validateInput("#developer_password", "Check Your Password", validatePassword);
                var isValid_user_name = validateInput("#developer_user_name", "Enter Username");
            
                if (isValid_password  && isValid_user_name) {
                    let formData = new FormData(this);
            
                    // Debug: Log form data to ensure values are being captured
                    for (let pair of formData.entries()) {
                        console.log(pair[0] + ': ' + pair[1]);
                    }
            
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST', 
                        url: '/devs/login', 
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status === "success") {
                                sessionStorage.setItem('successMessage', response.message);
                                    window.location.reload();
                            } else if (response.status === "error") {
                                alertify.set('notifier', 'position', 'top-center');
                            alertify.error(response.message);
                            }
                        },
                        error: function(response) {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.error('Something went wrong');
                        }
                    });
                }
            });

            $('#adminLoginUrl').click(function(){
                adminLoginUrlClickCount++;
                if(adminLoginUrlClickCount==4){
                window.location.href = '/devs/login';
                adminLoginUrlClickCount=0
            }
           
            });

            var table = $('#list_roles_table').DataTable({
                processing: true,
                serverSide: true,
                "order": [] ,
                "pageLength": 500,
                ajax: "/list-roles",
               
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    {data: 'name', name: 'name'},
                    
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
               
          });
            
          $('#create_role_form').submit(function(e) {
       
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
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error(errorMessage);
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
    

            var isValidName = validateInput("#role_name", "Enter Role Name");
           
            
            // If all fields are valid, submit the form or perform your desired action
            if (isValidName) {
                // All fields are valid, proceed with form submission or other actions
                let formData = new FormData(this);
        
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: 'POST',
                    url: '/store-roles',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status === "success") {
                            sessionStorage.setItem('successMessage', response.message);
                            window.location.href = "/show-role/"+btoa(response.role_id);
                            
                        } 
                        else if (response.status === "error") {
                           
                            printRolesErrorMsg(response.message);
                            
                        }
                    },
                    error: function(response) {
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.error('Something went wrong');
                    }
                });
    
                
            }
        }); 

          function addPermissionField(ccCounter) {
                ccCounter++;
                $('#no_of_permissions').val(ccCounter);
                var rowDiv = document.createElement("div");
                rowDiv.className = "row mb-3";
                rowDiv.id = "permission_row_" + ccCounter;
        
                var colDiv = document.createElement("div");
                colDiv.className = "col-md-12 d-flex align-items-center";
        
                var formFloatingDiv = document.createElement("div");
                formFloatingDiv.className = "form-floating flex-grow-1 me-2"; // Flex-grow to fill the remaining space and margin-right for spacing
        
                var inputField = document.createElement("input");
                inputField.type = "text";
                inputField.className = "form-control";
                inputField.placeholder = "";
                inputField.name = "permission_" + ccCounter;
                inputField.id = "permission_" + ccCounter;
                inputField.required = true;
        
                var label = document.createElement("label");
                label.htmlFor = "permission_" + ccCounter;
                label.textContent = "Permission " + ccCounter + " Name";
        
                var removeButton = document.createElement("button");
                removeButton.type = "button";
                removeButton.className = "btn  btn-outline-primary";
                removeButton.textContent = "Remove";
                removeButton.id = "create_permission_remove";
        
                formFloatingDiv.appendChild(inputField);
                formFloatingDiv.appendChild(label);
                colDiv.appendChild(formFloatingDiv);
                colDiv.appendChild(removeButton);
                rowDiv.appendChild(colDiv);
               permissionsContainer.appendChild(rowDiv);
        
               permissionsContainer.style.display = "block";
               
            }
        
            function removePermissionField(id) {
                var rowDiv = document.getElementById("permission_row_" + id);
                permissionsContainer.removeChild(rowDiv);
                var ccCounter =  $('#no_of_permissions').val();
                ccCounter--;
                $('#no_of_permissions').val(ccCounter);
                if (ccCounter === 0) {
                    permissionsContainer.style.display = "none";
                   
                } else {
                    updatePermissionFieldAttributes();
                }
            }
        
            function updatePermissionFieldAttributes() {
                var rows =permissionsContainer.querySelectorAll(".row");
                var counter = 1;
        
                rows.forEach(function(row) {
                    var inputField = row.querySelector("input");
                    var label = row.querySelector("label");
                    var removeButton = row.querySelector("button");
        
                    inputField.name = "permission_" + counter;
                    inputField.id = "permission_" + counter;
                    label.htmlFor = "permission_" + counter;
                    label.textContent = "Permission_ " + counter + " Name";
                    row.id = "permission_row_" + counter;
        
                    counter++;
                });
            }
        
           
        
            // Use event delegation for remove buttons
            $("#permissionsContainer").on('click', '#create_permission_remove', function() {
                var rowId = $(this).closest('.row').attr('id').split('_')[2];
                
                removePermissionField(rowId);
            });  
            
            $('#create_permission_form').submit(function(e) {
               
       
                e.preventDefault();
                var permissionCounter = $('#no_of_permissions').val();

                if(permissionCounter < 1){   
                    alertify.set('notifier','position', 'top-center');
                    alertify.error('Enter Permission Name');
                    return false
                }
                
                    let formData = new FormData(this);
            
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: 'POST',
                        url: '/store-permissions',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status === "success") {
                                sessionStorage.setItem('successMessage', response.message);
                                window.location.reload();
                                   
                               
                            } 
                            else if (response.status === "error") {
                               
                                alertify.set('notifier', 'position', 'top-center');
                                alertify.error(response.message);
                                
                            }
                        },
                        error: function(response) {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.error('Something went wrong');
                        }
                    });
        
                    
               // }
            });

            $("#create_permission_add").on('click', function(e) {
                e.preventDefault();
                
                var permissionCounter = $('#no_of_permissions').val();
               
                addPermissionField(permissionCounter);
            });

            $('body').on('click', '#update_roles_button', function () {
                var role_id = $(this).data('id');
                $('#update_role_modal').modal('show');
                $.get('/edit-role/' + role_id, function (data) {
                    var rolePermissionsArray = Object.keys(data.rolePermissions).map(function (key) {
                        return parseInt(key);
                    });
            
                    // Clear previous checkboxes
                    var permissionsContainer = $('#permissions_container');
                    permissionsContainer.empty();
            
                    // Show the modal
                   
            
                    // Set role data
                    $('#role_id').val(data.role.id);
                    $('#role_name').val(data.role.name);
            
                    // Append new checkboxes
                    Object.keys(data.permissions).forEach(function(grouping_id) {
                        // Create a table for the grouping_id
                        var tableHtml = `
                            <table class="table table-bordered data-table">
                                <thead>
                                    <tr>
                                        <th>${grouping_id}</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody id="tbody_${grouping_id}">
                                </tbody>
                            </table>
                        `;
                        permissionsContainer.append(tableHtml);
                
                        // Get the tbody element for the current group
                        var tbody = $(`#tbody_${grouping_id}`);
                
                        // Iterate through each permission in the current group
                        data.permissions[grouping_id].forEach(function (permission) {
                            var isChecked = rolePermissionsArray.includes(permission.id) ? 'checked' : '';
                            var rowHtml = `
                                <tr>
                                    <td>
                                        <label class="form-check-label" for="permission_${permission.id}">${permission.display_name}</label>
                                    </td>
                                    <td>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="permission_${permission.id}" name="permission[${permission.id}]" value="${permission.id}" ${isChecked} />
                                        </div>
                                    </td>
                                </tr>
                            `;
                            tbody.append(rowHtml);
                        });
                    });
                }).fail(function () {
                    alertify.set('notifier', 'position', 'top-center');
                            alertify.error('Something went wrong');
                });
            });

            $('#update_permission_level_form').submit(function(e) {
       
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
        
              
        
                function validatePassword(value) {
                    return value.length >= 3;
                }
                function validateRole(value) {
                   
                    return value !== null && value !== '';
                }
        
                // Validate each input field
                var isValidPassword = validateInput("#password", "Check Your password", validatePassword);
                var isValidPemissionLevel = validateInput("#register_role_id", "Select Permission Level 3", validateRole, true);
               
               
                // If all fields are valid, submit the form or perform your desired action
                if (isValidPassword && isValidPemissionLevel) {
                    // All fields are valid, proceed with form submission or other actions
                    let formData = new FormData(this);
            
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: 'POST',
                        url: '/update-permission-level',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            if (response.status === "success") {
                                sessionStorage.setItem('successMessage', response.message);
                                    window.location.reload();
                              
                            } 
                            else if (response.status === "error") {
                               
                                printPermissionLelevelErrorMsg(response.message);
                                
                            }
                        },
                        error: function(response) {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.error('Something went wrong');
                        }
                    });
        
                    
                }
            });    
            
            $('#delete_role_button').on('click',function(e){
                e.preventDefault();
               
            var role_id = $('#delete_role_id').val();
            $.ajax({
                type: "get",
                    url: "/delete-role/"+role_id,
                success: function (response) {
                    if (response.status === "success") {
                        sessionStorage.setItem('successMessage', response.message);
                        window.location.reload();
                   
                } 
                else if (response.status === "error") {
                    sessionStorage.setItem('errorMessage', response.message);
                    window.location.reload();
                }
                },
                error: function (response) {
                    alertify.set('notifier', 'position', 'top-center');
                        alertify.error('An error occurred please try again later');
                }
            });
            
            });   
            
            
          $('body').on('click', '#delete_role_button',function(e){
            e.preventDefault();
            var role_id = $(this).data('id');

          $('#delete_role_modal').modal('show');
          $('#delete_role_id').val(role_id);
        });

        function  printPermissionLelevelErrorMsg (msg) {
            $.each( msg, function( key, value ) {
                if (isWordPresent(value, 'email')){
                    $("#register_role_id").addClass('is-invalid');
                    $("#register_role_id").next('.invalid-feedback').remove(); 
                    $("#register_role_id").after('<div class="invalid-feedback">' + value + '</div>');
                    $("#register_role_id").on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });
                    
                } 
                else if (isWordPresent(value, 'password')){
                    $("#password").addClass('is-invalid');
                    $("#password").next('.invalid-feedback').remove(); 
                    $("#password").after('<div class="invalid-feedback">' + value + '</div>');
                    $("#password").on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });}
                   else{
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error(value);
                }
            });
          }
            
          $(document).on('change', '.form-check-input', function() {
            var isChecked = $(this).is(':checked');
            var label = $(this).closest('tr').find('.form-check-label');
    
            // Update all related switches and labels
            var permissionId = $(this).val();
            $(`input[value="${permissionId}"]`).each(function() {
                $(this).prop('checked', isChecked);
                var relatedLabel = $(this).closest('tr').find('.form-check-label');
                relatedLabel.text(relatedLabel.text().replace(' (On)', '').replace(' (Off)', '') + (isChecked ? ' (On)' : ' (Off)'));
            });
        });

        
        function handleSwitchToggle(switchElement) {
            var isChecked = $(switchElement).is(':checked');
            var label = $(switchElement).closest('tr').find('.form-check-label');
            if (isChecked) {
                label.append(' (On)');
            } else {
                label.append(' (Off)');
            }
        }
    
        $('.form-check-input').each(function() {
            handleSwitchToggle(this);
        });
        
        function  printRolesErrorMsg (msg) {
           
            $.each( msg, function( key, value ) {
                if (isWordPresent(value, 'role')){
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Check Role Name');
                    $("#role_name").addClass('is-invalid');
                    $("#role_name").next('.invalid-feedback').remove(); 
                    $("#role_name").after('<div class="invalid-feedback">' + value + '</div>');
                    $("#role_name").on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });
                    
                } 
                else if (isWordPresent(value, 'permission')){
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error('Check Permissions');
                    $("#role_permissions").addClass('is-invalid');
                    $("#role_permissions").next('.invalid-feedback').remove(); 
                    $("#role_permissions").after('<div class="invalid-feedback">' + value + '</div>');
                    $("#role_permissions").on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });}
                   else{
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error(value);
                }
            });
          }


    });
    
        
