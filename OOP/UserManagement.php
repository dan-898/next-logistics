<?php
class UserManagement
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }


    public function getAllEmployees()
    {
        $query = "SELECT * FROM users WHERE role = 'Employee'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }



    public function linkEmployeeToProject($projectId, $userId)
    {

         $query = "INSERT INTO projectusers (project_id, user_id) VALUES (:project_id, :user_id)";
         $stmt = $this->conn->prepare($query);
         $stmt->bindParam(':project_id', $projectId);
         $stmt->bindParam(':user_id', $userId);
         return $stmt->execute();
        return true; // Placeholder for success
    }

}

