$(document).ready(function () {

    $('#loading_alert')
    .hide()  
    .ajaxStart(function() {
        $(this).show();
    })
    .ajaxStop(function() {
        $(this).hide();
    })
;
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
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.message);
                    setTimeout(() => {
                        window.location.href = "/admin/home";
                    }, 5000);
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
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.success(response.message);
                            if(register_clicked_button=='register_save_view'){
                                setTimeout(() => {
                                    window.location.href = "/employee/view/"+btoa(response.user_id);
                            }, 5000);
                        }
                            else{
                                setTimeout(() => {
                                    window.location.reload();
                                }, 5000);
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
                            alertify.set('notifier', 'position', 'top-center');
                                alertify.success(response.message);
                                setTimeout(() => {
                                
                                window.location.reload();
                            }, 5000);
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
                                window.location.reload();
                        }, 5000);
                       
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
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.message);
                    setTimeout(() => {
                        window.location.reload();
                     }, 5000);
               
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
                            setTimeout(() => {
                                window.location.href = '/import-and-view';
                            }, 5000);
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

            
            $('#purchaseOrdersTable').DataTable();

            $('#save_and_view').on('click', function() {
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
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.success(response.message); 
                            setTimeout(() => {
                                window.location.href = "/orders/pdf/"+response.batch_id;
                            }, 5000);
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

            $('#save_and_send').on('click', function() {
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
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.success(response.message);
                            setTimeout(() => {
                                window.location.href = "/make-orders/"+response.batch_id;
                            }, 5000);
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

                var table = $('#view_batch_table').DataTable({
                    processing: true,
                    serverSide: true,
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
                        { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                        { data: 'quantity', name: 'quantity' },
                        { data: 'product_name', name: 'product_name' },
                        { data: 'price_quantity', name: 'price_quantity', createdCell: function (td, cellData, rowData, row, col) {
                            $(td).addClass('text-end');
                        }},

                        {
                            data: 'sub_total',
                            name: 'sub_total',
                            createdCell: function (td, cellData, rowData, row, col) {
                                $(td).addClass('text-end');
                            },
                            render: $.fn.dataTable.render.number(',', '.', 0, '')
                        }
                        

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
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.success(response.message);
                        if(register_clicked_button=='register_save_view'){
                            setTimeout(() => {
                            window.location.href = "/suppliers/view/"+btoa(response.supplier_id);
                        }, 5000);
                    }
                        else{
                            setTimeout(() => {
                                window.location.href = "/create-supplier";
                            }, 5000);
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
        });
      }

      var table = $('#active_suppliers_table').DataTable({
        processing: true,
        serverSide: true,
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
                    alertify.set('notifier', 'position', 'top-center');
                        alertify.success('Supplier Edited Succefully');
                    setTimeout(() => {
                        window.location.reload();
                    }, 5000);
                   
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
        alertify.set('notifier', 'position', 'top-center');
        alertify.success(response.message);
        setTimeout(() => {
            window.location.reload();
        }, 5000);
            
       
    } 
    else if (response.status === "error") {
        alertify.set('notifier', 'position', 'top-center');
        alertify.error(response.message);
        setTimeout(() => {
            
        }, 5000);
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
         
        alertify.set('notifier', 'position', 'top-center');
        alertify.success('Supplier Activated Succefully');
        setTimeout(() => {
            window.location.reload();
        }, 5000);
            
       
    } 
    else if (response.status === "error") {
        alertify.set('notifier', 'position', 'top-center');
        alertify.error(response.message);
         setTimeout(() => {
            window.location.reload();
         }, 5000);
    }
    },
    error: function (response) {
        alertify.set('notifier', 'position', 'top-center');
            alertify.error('An error occurred please try again later');
    }
});

});

var table = $('#imported_batches_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "/orders/list-imported-batches",
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

var table = $('#ordered_batches_table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "/orders/list-ordered-batches",
   "order": [] ,
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
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(response.message); 
                setTimeout(() => {
                    window.location.href = "/view/batch/"+response.batch_id;
                }, 5000);
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


$('#update_and_make_order_button').on('click', function() {
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
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(response.message); 
                setTimeout(() => {
                    window.location.href = "/make-orders/"+response.batch_id;
                }, 5000);
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

$('#delete_batch_order').on('click',function(e){
    e.preventDefault();
   
var batch_id = $('#delete_batch_id').val();
$.ajax({
    type: "get",
        url: "/order-batch/delete/"+batch_id,
    success: function (response) {
        if (response.status === "success") {
        alertify.set('notifier', 'position', 'top-center');
        alertify.success(response.message);
        setTimeout(() => {
            window.location.reload();
        }, 5000);
            
       
    } 
    else if (response.status === "error") {
        alertify.set('notifier', 'position', 'top-center');
        alertify.error(response.message);
        setTimeout(() => {
            
        }, 5000);
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
    let formData = new FormData(form);   // Create FormData from the form element

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
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(response.message);
                setTimeout(() => {
                    window.history.back();
                }, 5000);
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


$('body').on('click', '#make_order',function(e){
    e.preventDefault();
    
    var order_batch_id = $(this).data('id');
  $('#make_order_modal').modal('show');
  $('#delete_batch_id').val(order_batch_id);
});
$("#people_cc").on('keyup', function() {
   
        var doorNamesContainer = document.getElementById("doorNamesContainer");
        var submitButton = document.querySelector('button[type="submit"]');
    var no_people_cc = $(this).val();
    
        if (no_people_cc > 0) {
            doorNamesContainer.innerHTML = '';
    
            
            var numRows = Math.ceil(no_people_cc / 2); // For pairs of doors in each row
    
            for (var i = 1; i <= numRows; i++) {
                var rowDiv = document.createElement("div");
                rowDiv.className = "row mb-3";
    
                // Create first column for odd-numbered door
                var colDiv1 = document.createElement("div");
                colDiv1.className = "col-md-6";
    
                if (2 * i - 1 <= no_people_cc) { // Check if there's an odd-numbered door to add
                    var formFloatingDiv1 = document.createElement("div");
                    formFloatingDiv1.className = "form-floating mb-3 mb-md-0";
    
                    var inputField1 = document.createElement("input");
                    inputField1.type = "text";
                    inputField1.className = "form-control";
                    inputField1.placeholder = "";
                    inputField1.name = "cc_email_" + (2 * i - 1);
                    inputField1.id = "cc_email_" + (2 * i - 1);
                    inputField1.required = true;
    
                    var label1 = document.createElement("label");
                    label1.htmlFor = "cc_email_" + (2 * i - 1);
                    label1.textContent = "Recipient " + (2 * i - 1) + " email";
    
                    formFloatingDiv1.appendChild(inputField1);
                    formFloatingDiv1.appendChild(label1);
                    colDiv1.appendChild(formFloatingDiv1);
                }
    
                
                var colDiv2 = document.createElement("div");
                colDiv2.className = "col-md-6";
    
                if (2 * i <= no_people_cc) { 
                    var formFloatingDiv2 = document.createElement("div");
                    formFloatingDiv2.className = "form-floating";
    
                    var inputField2 = document.createElement("input");
                    inputField2.type = "email";
                    inputField2.className = "form-control";
                    inputField2.placeholder = "";
                    inputField2.name = "cc_email_" + (2 * i);
                    inputField2.id = "cc_email_" + (2 * i);
                    inputField2.required = true;
    
                    var label2 = document.createElement("label");
                    label2.htmlFor = "cc_email_" + (2 * i);
                    label2.textContent = "Recepient " + (2 * i) + " Email";
    
                    formFloatingDiv2.appendChild(inputField2);
                    formFloatingDiv2.appendChild(label2);
                    colDiv2.appendChild(formFloatingDiv2);
                }
    
                // Append columns to row
                rowDiv.appendChild(colDiv1);
                rowDiv.appendChild(colDiv2);
    
                // Append row to container
                doorNamesContainer.appendChild(rowDiv);
            }
    
            doorNamesContainer.style.display = "block";
            submitButton.removeAttribute('disabled');
            return true;
    
           
        } else {
            doorNamesContainer.style.display = "none";
            submitButton.setAttribute('disabled', 'true');
            return false;
    
    
        }
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
                    console.log('success')
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.message);
                    
                        setTimeout(() => {
                            window.location.reload();
                        }, 5000);
                   
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
                    console.log('success')
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.message);
                    
                        setTimeout(() => {
                            window.location.reload();
                        }, 5000);
                   
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
                    alertify.set('notifier', 'position', 'top-center');

                alertify.success('Edit Successful');
                    
                        setTimeout(() => {
                            window.location.reload();
                        }, 5000);
                   
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

    });
    
        
