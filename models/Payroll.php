<?php
class Payroll {
    private $conn;
    private $table = 'payroll';

    public $id;
    public $user_id;
    public $pay_period;
    public $hours_worked;
    public $hourly_rate;
    public $total_pay;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    // Create a payroll record
    public function create() {
        $query = "INSERT INTO " . $this->table . " (user_id, pay_period, hours_worked, hourly_rate, total_pay) 
                  VALUES (:user_id, :pay_period, :hours_worked, :hourly_rate, :total_pay)";

        $stmt = $this->conn->prepare($query);

        // Sanitize input data
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->pay_period = htmlspecialchars(strip_tags($this->pay_period));
        $this->hours_worked = htmlspecialchars(strip_tags($this->hours_worked));
        $this->hourly_rate = htmlspecialchars(strip_tags($this->hourly_rate));
        $this->total_pay = htmlspecialchars(strip_tags($this->total_pay));

        // Bind parameters
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':pay_period', $this->pay_period);
        $stmt->bindParam(':hours_worked', $this->hours_worked);
        $stmt->bindParam(':hourly_rate', $this->hourly_rate);
        $stmt->bindParam(':total_pay', $this->total_pay);

        // Execute query and return result
        if ($stmt->execute()) {
            return true;
        }

        return false;
    }
}
?>
