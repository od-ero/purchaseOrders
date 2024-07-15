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
                        window.location.href = "/admin/home";
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
            var isValidStaffNo = validateInput("#register_staff_no", "Staff number is required.", null, false);
            var isValidPhone = validateInput("#register_phone", "Invalid Phone Number", validatePhone);
            var isValidEmail = validateInput("#register_email", "Invalid Email", validateEmail, false);
            var isValidPassword = validateInput("#register_password", "Check password", validatePassword);
            var isValidRoleId = validateInput("#register_role_id", "Select Role ID", validateRole, true);
           
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
                            console.log('success')
                            if(register_clicked_button=='register_save_view'){
                                setTimeout(() => {
                                alertify.set('notifier', 'position', 'top-center');
                                alertify.success(response.message);
                                window.location.href = "/employee/view/"+btoa(response.user_id);
                            }, 1000);
                        }
                            else{
                                setTimeout(() => {
                                    alertify.set('notifier', 'position', 'top-center');
                                    alertify.success(response.message);
                                    window.location.href = "/employee/register";
                                }, 1000);
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
            var isValidIdNo = validateInput("#register_id_no", "Enter ID Number");
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
                                setTimeout(() => {
                                alertify.set('notifier', 'position', 'top-center');
                                alertify.success(response.message);
                                window.location.reload();
                            }, 1000);
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
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.success(response.message);
                            setTimeout(() => {
                            
                        }, 5000);
                        window.location.reload();
                    } 
                    else if (response.status === "error") {
                        alertify.set('notifier', 'position', 'top-center');
                            alertify.error(response.message);
                        setTimeout(() => {
                            
                        }, 1000);
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
                   
                    setTimeout(() => {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.message);
                }, 5000);
                window.location.reload();
            } 
            else if (response.status === "error") {
                setTimeout(() => {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.error(response.message);
                }, 5000);
                window.location.reload();
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
        
                var batch_name = $("#batch_name").val();
                var file_upload = $("#file_name").val();
        
                // Validate batch name
                if (batch_name.length < 1) {
                    $("#batch_name").addClass('is-invalid');
                    $("#batch_name").next('.invalid-feedback').remove(); // Remove existing error message
                    $("#batch_name").after('<div class="invalid-feedback">Enter batch</div>');
        
                    $("#batch_name").off('keyup').on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });
                    return false;
                }
        
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
                var allowedFiles = [".xlsx", ".xls", ".csv"];
                var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" + allowedFiles.join('|') + ")$");
                if (!regex.test(file_upload.toLowerCase())) {
                    $("#file_name").addClass('is-invalid');
                    $("#file_name").next('.invalid-feedback').remove(); // Remove existing error message
                    $("#file_name").after('<div class="invalid-feedback">Kindly enter a valid Excel file</div>');
        
                    $("#file_name").off('keyup').on('keyup', function() {
                        $(this).removeClass('is-invalid');
                        $(this).next('.invalid-feedback').remove();
                    });
                    return false;
                }
        
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
                        if (response.status === "success") {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.success('Success');
                            window.location.href = '/import-and-view';
                        } else if (response.status === "error") {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.error('Server error');
                        }
                    },
                    error: function(response) {
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.error('Something went wrong');
                    }
                });

                
            });

            
            $('#purchaseOrdersTable').DataTable();

            $('#save_and_view').on('click', function() {
                var batch_details = {
                    'batch_name':$('#upload_and_view_batch_name').val(),
                    'supplier_name':$('#upload_and_view_supplier_name').val(),
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
                           
                            window.location.href = "/saved/"+response.batch_id;
                           
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.success(response.message);
                        } else if (response.status === "error") {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.error('Server error');
                        }
                    },
                    error: function(response) {
                        alertify.set('notifier', 'position', 'top-center');
                        alertify.error('Something went wrong');
                    }
                });
            });
                var table = $('#saved_table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "/saved/" + $('#saved_batch_id').val(),
                        dataSrc: function(json) {
                            // Append the 'Total' row to the data
                            json.data.push({
                                DT_RowClass: 'total-row',
                                DT_RowIndex: '',
                                sub_total: json.sub_total_sum,
                                product_name: '', 
                                quantity: '',
                                price_quantity: 'Total (KSH):',
                                
                            });
                            return json.data;
                        }
                    },
                    columns: [
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'product_name', name: 'product_name' },
                        { data: 'quantity', name: 'quantity' },
                        { data: 'price_quantity', name: 'price_quantity' },
                        { data: 'sub_total', name: 'sub_total' }, 
                    ],
                    initComplete: function() {
                       
                    }
                });
            
          function appendTotalRowPurchaseOrdersTable() {
            const totalRow = `
                <tr>
                    <td class="no-border"></td> 
                    <td class="no-border"></td> 
                    <td class="no-border"></td> 
                    <td><b>Total (KSH)</b></td> 
                    <td><b id="total"><input type='text' id='total1' name='total1'></b></td>
                </tr>
            `;
            $('#purchaseOrdersTable tbody').append(totalRow);
        }

        function updateTotalPurchaseOrdersTable() {
            let total = 0;
            $('.subtotal').each(function() {
                total += parseFloat($(this).text()) || 0;
            });
            $('#total').text(total.toFixed(2));
        }

        function updateSubtotalPurchaseOrdersTable($row) {
            const quantity = parseFloat($row.find('#quantity').val()) || 0;
            const price = parseFloat($row.find('#price').val()) || 0;
           
            const subtotal = quantity * price;
            $row.find('.subtotal').text(subtotal.toFixed(0));
            updateTotalPurchaseOrdersTable();
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
        var isValidEmail = validateInput("#register_email", "Invalid Email", validateEmail, false);
       
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
                url: '/employee/register',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.status === "success") {
                        console.log('success')
                        if(register_clicked_button=='register_save_view'){
                            setTimeout(() => {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.success(response.message);
                            window.location.href = "/employee/view/"+btoa(response.user_id);
                        }, 1000);
                    }
                        else{
                            setTimeout(() => {
                                alertify.set('notifier', 'position', 'top-center');
                                alertify.success(response.message);
                                window.location.href = "/employee/register";
                            }, 1000);
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

    });
    
        
