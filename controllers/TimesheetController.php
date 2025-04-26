<?php
namespace App\Controllers;
class TimesheetController {
    private $db;
    private $timesheet;

    public function __construct($db) {
        $this->db = $db;
        $this->timesheet = new Timesheet($db);
    }

    public function submitTimesheet($user_id, $job_id, $hours) {
        $this->timesheet->user_id = $user_id;
        $this->timesheet->job_id = $job_id;
        $this->timesheet->hours_worked = $hours;
        $this->timesheet->status = 'submitted'; // Initial status is submitted

        if ($this->timesheet->submit()) {
            return "Timesheet submitted successfully!";
        }
        return "Failed to submit timesheet.";
    }

    public function approveTimesheet($id) {
        $this->timesheet->id = $id;
        if ($this->timesheet->approve()) {
            return "Timesheet approved successfully!";
        }
        return "Failed to approve timesheet.";
    }

    public function rejectTimesheet($id) {
        $this->timesheet->id = $id;
        if ($this->timesheet->reject()) {
            return "Timesheet rejected successfully!";
        }
        return "Failed to reject timesheet.";
    }
}
?>
