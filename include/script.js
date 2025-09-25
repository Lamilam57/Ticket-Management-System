
function init_DataTables() {
    // Check if DataTable is defined
    if (typeof $.fn.DataTable === 'undefined') {
        return;
    }

    $(document).ready(function () {
        // Initialize DataTable with buttons
        var table = $('#datatable-buttons').DataTable({
            dom: '<"row mb-3"<"col-sm-6"l><"col-sm-6 text-end"B>>' +
                '<"row"<"col-12"tr>>' +
                '<"row mt-3"<"col-sm-6"i><"col-sm-6 text-end"p>>',
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'CSV',
                    className: 'btn btn-primary btn-sm me-2',
                    exportOptions: {
                        columns: ':not(:last-child)' // Exclude the last column
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Excel',
                    className: 'btn btn-success btn-sm',
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }
            ]
        });

        // Apply Bootstrap styles to buttons
        $('.dt-buttons .btn').addClass('shadow-sm');
    });

    // Initialize other DataTable instances
    $('#datatable').DataTable();

    $('#datatable-keytable').DataTable({
        keys: true
    });

    $('#datatable-responsive').DataTable();

    $('#datatable-scroller').DataTable({
        ajax: "js/datatables/json/scroller-demo.json",
        deferRender: true,
        scrollY: 380,
        scrollCollapse: true,
        scroller: true
    });

    $('#datatable-fixed-header').DataTable({
        fixedHeader: true
    });

    var $datatableCheckbox = $('#datatable-checkbox');
    $datatableCheckbox.DataTable({
        order: [[1, 'asc']],
        columnDefs: [
            { orderable: false, targets: [0] }
        ]
    });

    // Use Bootstrap 5 utilities for checkboxes
    $datatableCheckbox.on('draw.dt', function () {
        $('input[type="checkbox"]').addClass('form-check-input');
    });
}

function showpassword() {
    const passwordInput = document.getElementById('password');
    const showpassword = document.getElementById('customControlAutosizing');
    passwordInput.type = showpassword.checked ? 'text' : 'password';

}

// Toggle password visibility
document.querySelectorAll('.toggle-password').forEach(button => {
    button.addEventListener('click', function () {
        const target = document.getElementById(this.getAttribute('data-target'));
        const icon = this.querySelector('i');
        if (target.type === 'password') {
            target.type = 'text';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        } else {
            target.type = 'password';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        }
    });
});

$(document).ready(function () {
    function dataTableButtons() {
        $('#datatable-buttons').DataTable({
            dom: '<"top d-flex justify-content-between align-items-center"lfB>rt<"bottom d-flex justify-content-between align-items-center"ip>',
            buttons: [
                {
                    extend: 'csvHtml5',
                    text: 'Download CSV',
                    className: 'btn btn-primary btn-sm me-2', // Bootstrap button with spacing
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                },
                {
                    extend: 'excelHtml5',
                    text: 'Download Excel',
                    className: 'btn btn-success btn-sm me-2', // Bootstrap button with spacing
                    exportOptions: {
                        columns: ':not(:last-child)'
                    }
                }
            ]
        });

        // Additional styling for buttons (spacing between buttons)
        $('.dt-buttons .btn').css({
            'border-radius': '5px',       // Rounded corners
            'font-weight': 'bold',       // Make text bold
            'padding': '6px 12px',       // Adjust padding
            'box-shadow': '0 4px 6px rgba(0,0,0,0.1)' // Add shadow for elevation
        });

    }

    if (window.location.pathname.endsWith("user.php")) {
        displayAllTicket();
    }

    if (window.location.pathname.endsWith("deletedTicket.php")) {
        displayDeletedTicketByUser();
    }

    if (window.location.pathname.endsWith("registerUser.php")) {
        displayAllStaff();
    }



    // Dispay all ticket
    function displayAllTicket() {
        $.ajax({
            url: 'action/action.php',
            method: 'post',
            data: {
                action: 'displayTicket'
            },
            success: function (response) {
                $("#displayTicket").html(response);
                dataTableButtons()
            }
        });
    }

    // Add ticket
    $("#submit").on('click', function (e) {
        e.preventDefault();
        $("#submit").val('Please wait...');

        if ($("#addTicketForm")[0].checkValidity() || $('#link').val() == '') {
            $.ajax({
                type: 'post',
                url: 'action/action.php',
                data: $("#addTicketForm").serialize() + "&action=addTicket",
                success: function (response) {
                    // console.log(response);
                    if (response === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Added',
                            text: 'Ticket Added Sucessfully!',
                        });

                        $("#submit").val('SUBMIT');
                        $('#enterTicketModal').modal('hide'); //Hide Modal
                        $('#addTicketForm')[0].reset(); //Reset Form

                        displayAllTicket() //Update Table
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Try again later!',
                        });
                        $("#submit").val('SUBMIT');
                    }
                }
            })
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'All *** fields must be filled!',
            });
            $("#submit").val('SUBMIT');
        }
    });

    // Show Ticket Details 
    $("body").on("click", '.showBtn', function (e) {
        e.preventDefault();

        id = $(this).attr('id'); // Get the id from the clicked element
        // console.log(id)
        $.ajax({
            url: 'action/action.php',
            method: 'post',
            data: {
                showTicket: id
            },
            dataType: 'json', // Specify JSON data type
            success: function (data) {
                console.log("Parsed data:", data);

                // console.log(data.fromDate)
                // console.log(data.toDate)
                // Populate fields
                $("#ticket_id").val(data.ticket_id);
                $("#links").val(data.link);
                $("#title").val(data.title);
                $("#status").val(data.status);
                $("#details").val(data.details);
                $("#vfromDate").val(data.fromDate);
                $("#vtoDate").val(data.toDate);
                $("#created_at").val(data.created_at);
                $("#updated_at").val(data.updated_at);
                $("#ucreated_at").val(data.created_at);
                $("#uupdated_at").val(data.updated_at);

                $("#dticket_id").val(data.ticket_id);
                $("#uticket_id").val(data.ticket_id);
                $("#ulink").val(data.link);
                $("#utitle").val(data.title);
                $("#ustatus").val(data.status);
                $("#ufromDate").val(data.fromDate);
                $("#utoDate").val(data.toDate);
                $("#udetails").val(data.details);
            }
        });

    });

    // Show Deleted Ticket Details 
    $("body").on("click", '.showDeletedBtn', function (e) {
        e.preventDefault();

        id = $(this).attr('id'); // Get the id from the clicked element
        // console.log(id)
        $.ajax({
            url: 'action/action.php',
            method: 'post',
            data: {
                showDeletedTicket: id
            },
            dataType: 'json', // Specify JSON data type
            success: function (data) {
                // console.log("Parsed data:", data);

                // Populate fields
                $("#ticket_id").val(data.ticket_id);
                $("#links").val(data.link);
                $("#title").val(data.title);
                $("#status").val(data.status);
                $("#details").val(data.details);
                $("#created_at").val(data.created_at);
                $("#updated_at").val(data.updated_at);

                $("#dticket_id").val(data.ticket_id);
                $("#uticket_id").val(data.ticket_id);
                $("#ulink").val(data.link);
                $("#utitle").val(data.title);
                $("#ustatus").val(data.status);
                $("#udetails").val(data.details);
            }
        });

    });

    // Update ticket
    $("#update").on('click', function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Update ticket?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, update it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $("#update").val('Please wait...');
                if ($("#updateTicketForm")[0].checkValidity() || $('#ulink').val() == '') {
                    $.ajax({
                        type: 'post',
                        url: 'action/action.php',
                        data: $("#updateTicketForm").serialize() + "&action=updateTicket",
                        success: function (response) {
                            // console.log(response)
                            if (response === 'success') {
                                Swal.fire({
                                    title: "Updated!",
                                    text: "Your ticket has been Updated.",
                                    icon: "success"
                                });

                                $("#update").val('Save Changes');
                                $('#updateTicketModal').modal('hide'); //Hide Modal
                                $('#updateTicketForm')[0].reset(); //Reset Form

                                displayAllTicket() //Update Table
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Try again later!',
                                });
                                $("#update").val('Save Changes');
                            }
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'All RED fields must be filled!',
                    });
                    $("#update").val('Save Changes');
                }

            }
        });

    });

    // Delete Ticket Details
    $("body").on("click", '.deleteBtn', function (e) {
        e.preventDefault();
        delete_id = $(this).attr('id');

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: 'action/action.php',
                    data: {
                        delete_id: delete_id
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your ticket has been deleted.",
                            icon: "success"
                        });
                        displayAllTicket() //Update Table
                    }
                })
            }
        });
    });

    // Delete Permanent Ticket Details
    $("body").on("click", '.deletePermanentBtn', function (e) {
        e.preventDefault();
        deletePermanent_id = $(this).attr('id');

        // console.log(deletePermanent_id)
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: 'action/action.php',
                    data: {
                        deletePermanent_id: deletePermanent_id
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your ticket has been deleted.",
                            icon: "success"
                        }).then(() => {
                            displayDeletedTicketByUser(); // Update the table
                        });
                    }
                })
            }
        });
    });

    // ShowUser
    if (window.location.pathname.endsWith("admin.php")) {
        showUser();
    }

    function showUser() {
        // alert('helloworld')
        $.ajax({
            url: 'action/action.php',
            method: 'post',
            data: {
                action: 'getUser'
            },
            success: function (response) {
                $("#getUser").html(response);
                // console.log(response)
                // showUser();
            }
        });
    }

    // Change Content of Category
    $(document).on('change', '#selectEmployee', function () {
        var selectedValue = $(this).val();

        if (selectedValue) {
            $.ajax({
                url: 'action/action.php',
                method: 'post',
                data: {
                    action: selectedValue === "1" ? 'getDeletedTicket' : 'getTicketByUser',
                    selectedValue: selectedValue
                },
                success: function (response) {
                    $('#displayTicket').html(response); // Display the data in the displayTicket div
                    dataTableButtons()
                },
                error: function () {
                    $('#displayTicket').html('An error occurred.');
                }
            });
        } else {
            $('#displayTicket').html(''); // Clear the displayTicket if no option is selected
        }
    });

    // Get Deleted Ticket by User
    function displayDeletedTicketByUser() {
        var selectedValue = "1";

        if (selectedValue) {
            $.ajax({
                url: 'action/action.php',
                method: 'post',
                data: {
                    action: selectedValue === "1" ? 'getDeletedTicket' : 'getTicketByUser',
                    selectedValue: selectedValue
                },
                success: function (response) {
                    $('#displayTicket').html(response); // Display the data in the displayTicket div
                    dataTableButtons()
                },
                error: function () {
                    $('#displayTicket').html('An error occurred.');
                }
            });
        } else {
            $('#displayTicket').html(''); // Clear the displayTicket if no option is selected
        }
    }

    // Restore Ticket Details
    $("body").on("click", '.restoreBtn', function (e) {
        e.preventDefault();
        restore_id = $(this).attr('id');

        Swal.fire({
            title: "Are you sure?",
            text: "The ticket will be displayed for the respective staff!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, restore it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: 'post',
                    url: 'action/action.php',
                    data: {
                        restore_id: restore_id
                    },
                    success: function (response) {
                        Swal.fire({
                            title: "Restored!",
                            text: "Your ticket has been restored.",
                            icon: "success"
                        });
                        displayDeletedTicketByUser()
                    }
                })
            }
        });
    });
    // function showTicket(element) {
    //   element.preventDefault();
    //   var id = $(element).attr('id'); // Get the id from the clicked element
    //   console.log(id);
    //   $.ajax({
    //     url: 'action/action.php',
    //     method: 'post',
    //     data: {
    //       showTicket: id
    //     },
    //     success: function(response) {
    //       var ticket = JSON.parse(response); // Parse the JSON response
    //       console.log(ticket); // Handle the ticket details
    //       // You can populate the modal with ticket details here
    //     }
    //   });
    // }

    $(document).on('submit', '#dateForm', function (e) {
        e.preventDefault(); // Prevent form submission

        // Check if all required fields are filled and valid
        if ($("#dateForm")[0].checkValidity() && $("#fromDate").val() !== "" && $("#toDate").val() !== "") {
            $.ajax({
                type: 'post',
                url: 'action/action.php',
                data: $("#dateForm").serialize() + "&action=dateForm",
                success: function (response) {
                    $('#displayTicket').html(response); // Display the data in the displayTicket div
                    dataTableButtons()
                },
                error: function () {
                    $('#displayTicket').html('An error occurred.');
                }
            })
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'All Date fields must be filled!',
            });
        }
    });

    $(".generatePassword").on('click', function (e) {
        const characters = "ABCDEFGHJKLMNPQRSTUVWXYZ23456789";
        let token = "";
        for (let i = 0; i < 8; i++) {
            const randomIndex = Math.floor(Math.random() * characters.length);
            token += characters[randomIndex];
        }
        $(".password").val(token); // Set the generated token in the input field
    });

    // Register new Staff
    $(document).ready(function () {
        $("#addStaff").click(function (e) {
            if ($("#registrationForm")[0].checkValidity()) {
                e.preventDefault();

                $.ajax({
                    url: 'action/action.php',
                    method: 'post',
                    data: $("#registrationForm").serialize() + "&action=register",
                    success: function (response) {
                        if (response == 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Add Staff',
                                text: 'Staff Added Succesfully',
                            })
                        }
                        $('#addUserModal').modal('hide'); //Hide Modal
                        $('#registrationForm')[0].reset(); //Reset Form

                        displayAllStaff() //Update Table
                    }
                })
            }
        });
    });

    function displayAllStaff() {
        $.ajax({
            url: 'action/action.php',
            method: 'post',
            data: {
                action: 'displayStaff'
            },
            success: function (response) {
                // console.log(response)
                $("#displayUser").html(response);
                dataTableButtons()
            }
        });
    }

    // Login script
    $("#login-btn").click(function (e) {
        // console.log('hello')
        if ($("#loginForm")[0].checkValidity()) {
            e.preventDefault();
            $("#login-btn").val('Please wait...');

            $.ajax({
                url: 'action/action.php',
                method: 'post',
                data: $("#loginForm").serialize() + "&action=login",
                success: function (response) {
                    if (response == 'changePassword') {
                        $('#changePasswordModal').modal('show');
                    }
                    else if (response == 'staff') {
                        window.location.href = 'user.php';
                    } else if (response == 'admin') {
                        window.location.href = 'admin.php';
                    } else if (response == 'incorrectPass') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Incorrect Password!',
                        });
                        $("#login-btn").val('LOGIN');
                    } else if (response == 'usernotfound') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'User Not Found!',
                        });
                        $("#login-btn").val('LOGIN');
                    }
                },
                error: function (xhr, status, error) {
                    console.log(xhr.responseText); // Logs any PHP errors
                }
            });
        }
    });

    // Change Password
    $('#changePasswordForm').submit(function (e) {
        e.preventDefault();

        const isIndexPage = currentPage === "index.php";
        // alert(currentPage)
        const staffIdValue = $("#changeStaffId").val();

        if (isIndexPage) {
            // When on index.php, set the value of #staff_id to #exampleInputEmail1's value
            $("#changeStaffId").val($("#exampleInputEmail1").val());

            // Update #staff_id value whenever #exampleInputEmail1 changes
            $("#exampleInputEmail1").on("input", function () {
                $("#changeStaffId").val($(this).val());
            });
        } else {
            // When not on index.php, keep the value set by PHP
            $("#exampleInputEmail1").val(staffIdValue);
        }

        var currentPassword = $('#currentPassword').val();
        var newPassword = $('#newPassword').val();
        var confirmNewPassword = $('#confirmNewPassword').val();

        // Check if passwords match
        if (newPassword !== confirmNewPassword) {
            Swal.fire({
                icon: 'success',
                title: 'Password Changed',
                text: 'Password Changed Succesfully',
            });
        }

        $.ajax({
            url: 'action/action.php',
            method: 'post',
            data: $("#changePasswordForm").serialize() + "&action=changePassword",
            success: function (response) {
                console.log(response)
                if (response == 'staff') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Changed',
                        text: 'Password Changed Succesfully',
                    });
                    window.location.href = 'user.php';
                } else if (response == 'admin') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Password Changed',
                        text: 'Password Changed Succesfully',
                    });
                    window.location.href = 'admin.php';
                } else if (response == 'incorrectPass') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Incorrect Password!',
                    });
                    $("#login-btn").val('LOGIN');
                } else if (response == 'notMatchPass') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Password does not match!',
                    });
                    $("#login-btn").val('LOGIN');
                }
                // else{
                //     Swal.fire({
                //         icon: 'success',
                //         title: 'Password Changed',
                //         text: 'Password Changed Succesfully',
                //     });
                // }
            }
        });
    });

    // Show Staff Details
    $("body").on("click", '.staffBtn', function (e) {
        e.preventDefault();

        const id = $(this).attr('id'); // Get the ID from the clicked element
        // Debugging ID
        console.log("Staff ID:", id);

        $.ajax({
            url: 'action/action.php',
            method: 'POST',
            data: {
                showStaff: id
            },
            dataType: 'json', // Expect JSON response
            success: function (data) {
                console.log("Staff Data:", data);
                $(".staff_id").val(data.staff_id);

            },
            error: function (xhr, status, error) {
                console.error("AJAX Error:", status, error);
                console.error("Response Text:", xhr.responseText); // Log raw response
            }
        });

    });

    // Reset Password
    $("#resetPassword").on('click', function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Reset Password?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, reset it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $("#resetPassword").val('Please wait...');
                if ($("#resetPasswordForm")[0].checkValidity()) {
                    $.ajax({
                        type: 'post',
                        url: 'action/action.php',
                        data: $("#resetPasswordForm").serialize() + "&action=resetPassword",
                        success: function (response) {
                            // console.log(response)
                            if (response === 'success') {
                                Swal.fire({
                                    title: "Reset Password!",
                                    text: "The Password is reset completely.",
                                    icon: "success"
                                });

                                $("#resetPassword").val('Save Changes');
                                $('#resetPasswordModal').modal('hide'); //Hide Modal
                                $('#resetPasswordForm')[0].reset(); //Reset Form

                                displayAllStaff(); //Update Table
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Try again later!',
                                });
                                $("#update").val('Save Changes');
                            }
                        }
                    })
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'All RED fields must be filled!',
                    });
                    $("#resetPassword").val('Reset Password');
                }

            }
        });

    });
});