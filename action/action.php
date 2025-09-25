<?php
require_once '../class/admin.php';
$admin = new Admin();


if (isset($_POST['action']) && $_POST['action'] == 'register') {
    $firstName = $admin->validateName($admin->testInput($_POST['firstName']));
    $lastName = $admin->validateName($admin->testInput($_POST['lastName']));
    $password = $admin->testInput($_POST['password']);
    $who = $admin->validateName($admin->testInput($_POST['responsibility']));

    $letters = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';
    $numbers = '123456789';
    $randomLetters = substr(str_shuffle($letters), 0, 4);
    $randomNumbers = substr(str_shuffle($numbers), 0, 4);
    $combined = str_shuffle($randomLetters . $randomNumbers);


    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $name = $firstName . ' ' . $lastName;
    $admin->registerNewUser($combined, $name, $who, $password, $hashedPassword);
    echo 'success';
}

if (isset($_POST['action']) && $_POST['action'] == 'login') {

    $staff_id = $admin->testInput($_POST['staff_id']);
    $password = $admin->testInput($_POST['password']);
    // echo $staff_id;
    // echo $password;

    $loggedInUser = $admin->loginUser($staff_id); // Fetch user based on staff_id
    if ($loggedInUser !== null) {
        if (password_verify($password, $loggedInUser['password'])) {

            $_SESSION['staff_id'] = $staff_id;
            $_SESSION['name'] = $loggedInUser['name'];
            $who = $loggedInUser['who']; // Get the role from the who column

            if ($loggedInUser['passwordStatus'] == 1) {
                $_SESSION['passwordStatus'] = $loggedInUser['passwordStatus'];
                echo $who; // Output the role for frontend handling
            } else if ($loggedInUser['passwordStatus'] == 0) {
                echo 'changePassword';
                $_SESSION['who'] = $who;
            }
        } else {
            echo 'incorrectPass'; // Password did not match
            exit();
        }
    } else {
        echo 'usernotfound'; // User not found
        exit();
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'addTicket') {
    require_once 'session.php';
    // $staff_id = $admin->testInput($_POST['staff_id']) ?? '';
    $linkInput = $admin->testInput($_POST['link']);
    $title = $admin->testInput($_POST['title']);
    $status = $admin->testInput($_POST['status']);
    $details = $admin->testInput($_POST['details']);
    $fromDate = $admin->testInput($_POST['fromDate']);
    $toDate = $admin->testInput($_POST['toDate']);

    $letters = 'ABCDEFGHIJKLMNPQRSTUVWXYZ';
    $numbers = '123456789';
    $randomLetters = substr(str_shuffle($letters), 0, 3);
    $randomNumbers = substr(str_shuffle($numbers), 0, 3);
    $combined = str_shuffle($randomLetters . $randomNumbers);
    $ticket_id = 'IES-' . $combined;


    // Use "http" as a delimiter
    $links = explode('http', $linkInput);

    // Prepend "http" back to each link and remove duplicates
    $uniqueLinks = array_unique(array_filter(array_map(function ($link) {
        return trim($link) ? 'http' . trim($link) : null; // Add 'http' back and trim whitespace
    }, $links)));

    // Create the final output
    $uniqueLinksString = implode('<br>', $uniqueLinks); // Using <br> for new lines instead of comma

    $admin->addTicket($ticket_id, $staff_id, $uniqueLinksString, $title, $status,  $details, $fromDate, $toDate);

    echo 'success';
}

if (isset($_POST['action']) && $_POST['action'] == 'displayTicket') {
    require_once 'session.php';

    $output = '';

    $SN = 1;
    $ticket = $admin->displayStaffTicket($staff_id);

    if ($ticket) {
        $output .= '<table id="datatable-buttons" class="table custom-table  table-striped display nowrap table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ticket ID</th>
                            <th class="col-3">Link</th>
                            <th class="col-3">Title</th>
                            <th>Status</th>
                            <th class="col-3">Detail</th>
                            <th>From</th>
                            <th>Date</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($ticket as $row) {
            $output .= '<tr>
                      <td scope="row">' . $SN++ . '</td>
                      <td>' . $row['ticket_id'] . '</td>
                      <td><a href="' . htmlspecialchars($row['link']) . '" title="Go to ticket" style="color: blue;" target="_blank">' . htmlspecialchars($row['link']) . '</a></td>
                      <td>' . $row['title'] . '</td>
                      <td>' . $row['status'] . '</td>
                      <td>' . $row['details'] . '</td>
                      <td>' . (isset($row['fromDate']) ? $row['fromDate'] : '') . '</td>
                      <td>' . (isset($row['toDate']) ? $row['toDate'] : '') . '</td>
                      <td>' . $row['created_at'] . '</td>
                      <td>' . (isset($row['updated_at']) ? $row['updated_at'] : '') . '</td>
                      <td style="text-align:justify;">
                        <a href="#" id="' . $row['ticket_id'] . '" data-bs-toggle="modal" data-bs-target="#viewTicketModal" title="View Details" class="showBtn"><i style="font-size: larger;" class="fa fa-info-circle text-success"></i></a>&nbsp;&nbsp;
                        <a href="#" id="' . $row['ticket_id'] . '" data-bs-toggle="modal" data-bs-target="#updateTicketModal" title="Update Details"  class="showBtn"><i style="font-size: larger;" class="fa fa-pencil-square-o text-primary" ></i></a>&nbsp;&nbsp;
                        <a href="#" id="' . $row['ticket_id'] . '" title="Delete Details"  class="deleteBtn"><i style="font-size: larger;" class="fa fa-trash text-danger"></i></a>
                      </td>
                        </tr>';
        }
        $output .= '</tbody>
                </table>';
        echo $output;
    } else {
        echo '<h3 class="text-center text-secondary">:( You have not written any ticket yet! Write your first ticket now!</h3>';
    }
}

if (isset($_POST['showTicket'])) {
    $ticket_id = $_POST['showTicket'];

    // Assuming you have a method to get the ticket details
    $ticketDetails = $admin->showTicket($ticket_id);

    header('Content-Type: application/json'); // Set JSON header
    if ($ticketDetails) {
        echo json_encode($ticketDetails); // Send the ticket details as JSON
    } else {
        echo json_encode(['error' => 'Ticket not found']);
    }
    exit; // Ensure no further output
}

if (isset($_POST['showStaff'])) {
    $staff_id = $_POST['showStaff'];
    $ticketDetails = $admin->showStaff($staff_id); // Call the function

    // Return JSON response
    // echo json_encode($data);

    header('Content-Type: application/json'); // Set JSON header
    if ($ticketDetails) {
        echo json_encode($ticketDetails); // Send the ticket details as JSON
    } else {
        echo json_encode(['error' => 'Ticket not found']);
    }
    exit; // Ensure no further output
}

if (isset($_POST['action']) && $_POST['action'] == 'updateTicket') {

    $linkInput = $admin->testInput($_POST['link']);
    $title = $admin->testInput($_POST['title']);
    $status = $admin->testInput($_POST['status']);
    $details = $admin->testInput($_POST['details']);
    $ticket_id =  $admin->testInput($_POST['ticket_id']);
    $fromDate = $admin->testInput($_POST['fromDate']);
    $toDate = $admin->testInput($_POST['toDate']);


    // Use "http" as a delimiter
    $links = explode('http', $linkInput);

    // Prepend "http" back to each link and remove duplicates
    $uniqueLinks = array_unique(array_filter(array_map(function ($link) {
        return trim($link) ? 'http' . trim($link) : null; // Add 'http' back and trim whitespace
    }, $links)));

    // Create the final output
    $uniqueLinksString = implode('<br>', $uniqueLinks); // Using <br> for new lines instead of comma


    $admin->updateTicket($ticket_id, $uniqueLinksString, $title, $status,  $details, $fromDate, $toDate);

    echo 'success';
}

if (isset($_POST['delete_id'])) {
    $ticket_id = $_POST['delete_id'];

    $admin->deleteTicket($ticket_id);
    echo 'success';
}

if (isset($_POST['showDeletedTicket'])) {
    $ticket_id = $_POST['showDeletedTicket'];

    // Assuming you have a method to get the ticket details
    $ticketDetails = $admin->showDeletedTicket($ticket_id);

    header('Content-Type: application/json'); // Set JSON header
    if ($ticketDetails) {
        echo json_encode($ticketDetails); // Send the ticket details as JSON
    } else {
        echo json_encode(['error' => 'Ticket not found']);
    }
    exit; // Ensure no further output
}

if (isset($_POST['action']) && $_POST['action'] == 'getUser') {
    require_once 'session.php';

    $output = '';

    $user = $admin->getUser();
    // echo $user;
    if ($user) {
        $output .= '<select name="selectEmployee" id="selectEmployee" class="custome-select border-0 pr-3">
            <option value="" disabled selected hidden>Select Employee</option>';
        foreach ($user as $row) {
            $output .= '<option value="' . $row['staff_id'] . '">' . strtoupper($row['name']) . '</option>';
        }
        $output .= '</select>';
        echo $output;
    } else {
        echo '<h3 class="text-center text-secondary">:( No Staff Ticket Yet!</h3>';
    }
}

if ($_POST['action'] === 'getDeletedTicket') {
    // Fetch and display deleted tickets
    $deletedTickets = $admin->getDeletedTickets();
    $output = '';
    $SN = 1;
    if ($deletedTickets) {
        $output .= '<table id="datatable-buttons" class="table custom-table  table-striped display nowrap table-bordered custom-table" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Staff ID</th>
                            <th>Ticket ID</th>
                            <th style="width: 100px !important;">Link</th>
                            <th class="col-3">Title</th>
                            <th>Status</th>
                            <th class="col-3">Detail</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($deletedTickets as $row) {
            $output .= '<tr>
                      <td scope="row">' . $SN++ . '</td>
                      <td>' . $row['staff_id'] . '</td>
                      <td>' . $row['ticket_id'] . '</td>
                      <td><a href="' . htmlspecialchars($row['link']) . '" title="Go to ticket" style="color: blue;" target="_blank">' . htmlspecialchars($row['link']) . '</a></td>
                      <td>' . $row['title'] . '</td>
                      <td>' . $row['status'] . '</td>
                      <td>' . $row['details'] . '</td>
                      <td>' . (isset($row['fromDate']) ? $row['fromDate'] : '') . '</td>
                      <td>' . (isset($row['toDate']) ? $row['toDate'] : '') . '</td>
                      <td>' . $row['created_at'] . '</td>
                      <td>' . (isset($row['updated_at']) ? $row['updated_at'] : '') . '</td>
                      <td style="text-align:justify;">
                        <a href="#" id="' . $row['ticket_id'] . '" data-bs-toggle="modal" data-bs-target="#viewTicketModal" title="View Details"  class="showDeletedBtn"><i style="font-size: larger;" class="fa fa-info-circle text-success" ></i></a>&nbsp;&nbsp;
                        <a href="#" id="' . $row['ticket_id'] . '" title="Restore Details"  class="restoreBtn"><i style="font-size: larger;" class="fa fa-reply text-primary" ></i></a>&nbsp;&nbsp;
                        <a href="#" id="' . $row['ticket_id'] . '" title="Delete Details"  class="deletePermanentBtn"><i style="font-size: larger;" class="fa fa-trash text-danger"></i></a>
                      </td>
                        </tr>';
        }
        $output .= '</tbody>
                </table>';
        echo $output;
    } else {
        echo '<h3 class="text-center text-secondary">:( No deleted tickets available!</h3>';
    }
}

if ($_POST['action'] === 'getTicketByUser' && isset($_POST['selectedValue'])) {
    $staff_id = $admin->testInput($_POST['selectedValue']);
    $ticket = $admin->displayStaffTicket($staff_id);

    $output = '';
    $SN = 1;

    if ($ticket) {
        $output .= '<table id="datatable-buttons" class="table custom-table  custom-table  table-striped display nowrap table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Staff ID</th>
                            <th>Ticket ID</th>
                            <th class="col-3">Link</th>
                            <th class="col-3">Title</th>
                            <th>Status</th>
                            <th class="col-3">Detail</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($ticket as $row) {
            $output .= '<tr>
                      <td scope="row">' . $SN++ . '</td>
                      <td>' . $row['staff_id'] . '</td>
                      <td>' . $row['ticket_id'] . '</td>
                      <td><a href="' . htmlspecialchars($row['link']) . '" title="Go to ticket" style="color: blue;" target="_blank">' . htmlspecialchars($row['link']) . '</a></td>
                      <td>' . $row['title'] . '</td>
                      <td>' . $row['status'] . '</td>
                      <td>' . $row['details'] . '</td>
                      <td>' . (isset($row['fromDate']) ? $row['fromDate'] : '') . '</td>
                      <td>' . (isset($row['toDate']) ? $row['toDate'] : '') . '</td>
                      <td>' . $row['created_at'] . '</td>
                      <td>' . (isset($row['updated_at']) ? $row['updated_at'] : '') . '</td>
                      <td style="text-align:justify;">
                        <a href="#" id="' . $row['ticket_id'] . '" data-bs-toggle="modal" data-bs-target="#viewTicketModal" title="View Details"  class="showBtn"><i style="font-size: larger;" class="fa fa-info-circle text-success" ></i></a>&nbsp;&nbsp;
                        <a href="#" id="' . $row['ticket_id'] . '" data-bs-toggle="modal" data-bs-target="#updateTicketModal" title="Update Details"  class="showBtn"><i style="font-size: larger;" class="fa fa-pencil-square-o text-primary" ></i>&nbsp;&nbsp;</a>
                        <a href="#" id="' . $row['ticket_id'] . '" title="Delete Details"  class="deleteBtn"><i style="font-size: larger;" class="fa fa-trash text-danger"></i></a>
                      </td>
                    </tr>';
        }
        $output .= '</tbody>
                </table>';
        echo $output;
    } else {
        echo '<h3 class="text-center text-secondary">:( No tickets found for this staff member!</h3>';
    }
}

if (isset($_POST['deletePermanent_id'])) {
    $ticket_id = $_POST['deletePermanent_id'];

    $admin->deletePermanentTicket($ticket_id);
    echo 'success';
}

if (isset($_POST['restore_id'])) {
    $ticket_id = $_POST['restore_id'];

    $admin->restoreTicket($ticket_id);
    echo 'success';
}

if (isset($_POST['action']) && $_POST['action'] == 'dateForm') {
    $fromDate = $admin->testInput($_POST['fromDate']);
    $toDate = $admin->testInput($_POST['toDate']);

    if ($fromDate <= $toDate) {
        // Dates are in correct order, no changes needed
        $fromDate = $fromDate;
        $toDate = $toDate;
    } else {
        // Swap the dates
        $temp = $fromDate;
        $fromDate = $toDate;
        $toDate = $temp;
    }


    $output = '';

    $SN = 1;
    $ticket = $admin->displayStaffDateTicket($fromDate, $toDate);

    if ($ticket) {
        $output .= '<table id="datatable-buttons" class="table custom-table  custom-table  table-striped display nowrap table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Ticket ID</th>
                            <th class="col-3">Link</th>
                            <th class="col-3">Title</th>
                            <th>Status</th>
                            <th class="col-3">Detail</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th style="width: 150px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($ticket as $row) {
            $output .= '<tr>
                      <td scope="row">' . $SN++ . '</td>
                      <td>' . $row['ticket_id'] . '</td>
                      <td><a href="' . htmlspecialchars($row['link']) . '" title="Go to ticket" style="color: blue;" target="_blank">' . htmlspecialchars($row['link']) . '</a></td>
                      <td>' . $row['title'] . '</td>
                      <td>' . $row['status'] . '</td>
                      <td>' . $row['details'] . '</td>
                      <td>' . (isset($row['fromDate']) ? $row['fromDate'] : '') . '</td>
                      <td>' . (isset($row['toDate']) ? $row['toDate'] : '') . '</td>
                      <td>' . $row['created_at'] . '</td>
                      <td>' . (isset($row['updated_at']) ? $row['updated_at'] : '') . '</td>
                      <td style="text-align:justify;">
                        <a href="#" id="' . $row['ticket_id'] . '" data-bs-toggle="modal" data-bs-target="#viewTicketModal" title="View Details" class="showBtn"><i style="font-size: larger;" class="fa fa-info-circle text-success"></i></a>&nbsp;&nbsp;
                        <a href="#" id="' . $row['ticket_id'] . '" data-bs-toggle="modal" data-bs-target="#updateTicketModal" title="Update Details"  class="showBtn"><i style="font-size: larger;" class="fa fa-pencil-square-o text-primary" ></i></a>&nbsp;&nbsp;
                        <a href="#" id="' . $row['ticket_id'] . '" title="Delete Details"  class="deleteBtn"><i style="font-size: larger;" class="fa fa-trash text-danger"></i></a>
                      </td>
                        </tr>';
        }
        $output .= '</tbody>
                </table>';
        echo $output;
    } else {
        echo '<h3 class="text-center text-secondary">:( No ticket found for the selected dates. Select other dates</h3>';
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'displayStaff') {
    $output = '';

    $SN = 1;
    $ticket = $admin->displayStaff();

    if ($ticket) {
        $output .= '<table id="datatable-buttons" class="table custom-table  custom-table  table-striped display nowrap table-bordered" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Staff ID</th>
                            <th>Staff Name</th>
                            <th>Responsibility</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>';
        foreach ($ticket as $row) {
            $output .= '<tr>
                      <td scope="row">' . $SN++ . '</td>
                      <td>' . $row['staff_id'] . '</td>
                      <td>' . $row['name'] . '</td>
                      <td>' . $row['who'] . '</td>
                      <td>' . $row['viewPassword'] . '</td>
                      <td style="text-align:justify;">
                        <a href="#" id="' . htmlspecialchars($row['staff_id']) . '" data-bs-toggle="modal" data-bs-target="#resetPasswordModal" title="Reset Password"  class="staffBtn"><i style="font-size: larger;" class="fa fa-key text-success"></i></a>

                      </td>
                        </tr>';
        }
        $output .= '</tbody>
                </table>';
        echo $output;
    } else {
        echo '<h3 class="text-center text-secondary">:( You have not written any ticket yet! Write your first ticket now!</h3>';
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'changePassword') {
    $staff_id = $admin->testInput($_POST['staff_id']);
    $currentPassword = $admin->testInput($_POST['currentPassword']);
    $newPassword = $admin->testInput($_POST['newPassword']);
    $confirmNewPassword = $admin->testInput($_POST['confirmNewPassword']);
    // $who = $admin->testInput($_POST['who']);

    if ($newPassword !== $confirmNewPassword) {
        echo "notMatchPass";
        exit();
    }
    $loggedInUser = $admin->loginUser($staff_id); // Fetch user based on staff_id
    if ($loggedInUser !== null) {
        if (password_verify($currentPassword, $loggedInUser['password'])) {
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            $admin->changePassword($staff_id, '', $hashedPassword, 1);

            $_SESSION['passwordStatus'] = $loggedInUser['passwordStatus'];
            
            $_SESSION['who'] = $loggedInUser['who'];
            echo $loggedInUser['who']; // Output the role for frontend handling

        } else {
            echo 'incorrectPass'; // Password did not match
            exit();
        }
    } else {
        echo 'usernotfound'; // User not found
        exit();
    }
}

if (isset($_POST['action']) && $_POST['action'] == 'resetPassword') {
    $staff_id = $admin->testInput($_POST['staff_id']);
    $password = $admin->testInput($_POST['password']);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $admin->changePassword($staff_id, $password, $hashedPassword, 0);

    echo 'success'; // Output the role for frontend handling


}
