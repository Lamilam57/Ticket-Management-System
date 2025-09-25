<?php
require_once 'database.php';

class Admin extends Database
{
    private $ticket_table = "ticket";
    // Register new user
    public function registerNewUser($staff_id, $name, $who, $viewPassword, $password)
    {
        $sql = "INSERT INTO `users`(`staff_id`, `name`, `who`, `viewPassword`, `password`) VALUES (:staff_id, :name, :who, :viewPassword, :password)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['staff_id' => $staff_id, 'name' => $name, 'who' => $who, 'viewPassword' => $viewPassword, 'password' => $password]);

        return true;
    }

    public function loginUser($staff_id)
    {
        $sql = "SELECT * FROM `users` WHERE `staff_id`= :staff_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['staff_id' => $staff_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $row : null;
    }

    public function addTicket($ticket_id, $staff_id, $link, $title, $status,  $details, $fromDate, $toDate)
    {
        $sql = "INSERT INTO $this->ticket_table(`ticket_id`, `staff_id`, `link`, `title`, `status`, `details`, `fromDate`, `toDate`) VALUES  (:ticket_id, :staff_id, :link, :title, :status, :details, :fromDate, :toDate)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['ticket_id' => $ticket_id, 'staff_id' => $staff_id, 'link' => $link, 'title' => $title, 'status' => $status, 'details' => $details, 'fromDate' => $fromDate, 'toDate' => $toDate]);
        // $this->conn->lastInsertId();
        return true;
    }

    public function displayStaffTicket($staff_id)
    {
        $sql = "SELECT * FROM $this->ticket_table WHERE `staff_id`= :staff_id AND `deleted`= 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['staff_id' => $staff_id]);
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

    public function showTicket($ticket_id)
    {
        $sql = "SELECT * FROM $this->ticket_table WHERE `ticket_id` = :ticket_id AND `deleted`= 0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['ticket_id' => $ticket_id]);

        // Fetch a single row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $row : null; // Return the row or null if not found
    }

    public function updateTicket($ticket_id, $link, $title, $status,  $details, $fromDate, $toDate)
    {
        $sql = "UPDATE $this->ticket_table SET `link` = :link, `title` = :title, `status` = :status, `details` = :details, `fromDate` = :fromDate, `toDate` = :toDate WHERE ticket_id= :ticket_id AND deleted=0";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['ticket_id' => $ticket_id, 'link' => $link, 'title' => $title, 'status' => $status, 'details' => $details, 'fromDate' => $fromDate, 'toDate' => $toDate]);

        return true;
    }

    public function deleteTicket($ticket_id)
    {
        $sql = "UPDATE $this->ticket_table SET deleted=1 WHERE ticket_id= :ticket_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['ticket_id' => $ticket_id]);

        return true;
    }

    public function getUser()
    {
        $sql = "SELECT * FROM `users`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row ? $row : null;
    }

    public function getDeletedTickets()
    {
        $sql = "SELECT * FROM $this->ticket_table WHERE `deleted`= 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

    public function showDeletedTicket($ticket_id)
    {
        $sql = "SELECT * FROM $this->ticket_table WHERE `ticket_id` = :ticket_id AND `deleted`= 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['ticket_id' => $ticket_id]);

        // Fetch a single row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row ? $row : null; // Return the row or null if not found
    }

    public function deletePermanentTicket($ticket_id)
    {
        $sql = "DELETE FROM $this->ticket_table WHERE ticket_id= :ticket_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['ticket_id' => $ticket_id]);

        return true;
    }

    public function restoreTicket($ticket_id)
    {
        $sql = "UPDATE $this->ticket_table SET deleted=0 WHERE ticket_id= :ticket_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['ticket_id' => $ticket_id]);

        return true;
    }

    public function displayStaffDateTicket($fromDate, $toDate)
    {
        $sql = "SELECT * FROM $this->ticket_table WHERE (`fromDate` BETWEEN :fromDate AND :toDate OR `toDate` BETWEEN :fromDate AND :toDate) AND `deleted` = 0;";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['fromDate' => $fromDate, 'toDate' => $toDate]);
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

    public function displayStaff()
    {
        $sql = "SELECT * FROM `users`";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

    public function changePassword($staff_id, $viewPassword, $password, $passwordStatus)
    {
        $sql = "UPDATE `users` SET `viewPassword` = :viewPassword, `password`= :password, `passwordStatus`= :passwordStatus WHERE `staff_id`= :staff_id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute(['staff_id' => $staff_id, 'viewPassword' => $viewPassword, 'password' => $password, 'passwordStatus' => $passwordStatus]);

        return true;
    }

    public function showStaff($staff_id)
{
    $sql = "SELECT * FROM `users` WHERE `staff_id` = :staff_id";
    $stmt = $this->conn->prepare($sql);
    $stmt->execute(['staff_id' => $staff_id]);

    // Fetch a single row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    return $row ?: null; // Return the row or null if not found
}

}
