<?php

class Timesheet {
    private $conn;
    private $table = 'timesheets';

    public $id;
    public $user_id;
    public $job_id;
    public $hours_worked;
    public $status;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function submit() {
        $query = "INSERT INTO " . $this->table . " SET user_id = :user_id, job_id = :job_id, hours_worked = :hours_worked, status = :status";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':job_id', $this->job_id);
        $stmt->bindParam(':hours_worked', $this->hours_worked);
        $stmt->bindParam(':status', $this->status);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function approve() {
        $query = "UPDATE " . $this->table . " SET status = 'approved' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function reject() {
        $query = "UPDATE " . $this->table . " SET status = 'rejected' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
?>
