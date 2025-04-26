<?php

class Migration
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    // Apply migration (create tables)
    public function apply($query)
    {
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            echo "Migration applied successfully.\n";
        } catch (PDOException $e) {
            echo "Error applying migration: " . $e->getMessage() . "\n";
        }
    }

    // Revert migration (drop tables)
    public function revert($query)
    {
        try {
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            echo "Migration reverted successfully.\n";
        } catch (PDOException $e) {
            echo "Error reverting migration: " . $e->getMessage() . "\n";
        }
    }
}
