<?php
class UserPermissions {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function hasPermission($userId, $permission) {
        // Placeholder logic to check user permissions
        // Simulated permissions check (Example: Checking if the user has a specific permission)
        // You'll need to replace this with actual logic fetching user permissions from your database
        if ($userId == 1 && $permission == 'add_change_delete_projects') {
            return true; // Simulated permission granted
        } else {
            return false; // Simulated permission denied
        }
    }


}

