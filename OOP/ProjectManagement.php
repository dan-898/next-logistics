<?php
class ProjectManagement {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }
    
    public function addProject($title, $code, $startDate, $endDate, $maxHours, $isActive)
    {
        try {
            $query = "INSERT INTO projects (title, start_date, end_date, active, code, maxhours) 
                      VALUES (:title, :start_date, :end_date, :active, :code, :max_hours)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':start_date', $startDate);
            $stmt->bindParam(':end_date', $endDate);
            $stmt->bindParam(':active', $isActive);
            $stmt->bindParam(':code', $code);
            $stmt->bindParam(':max_hours', $maxHours);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {

            echo "Error: " . $e->getMessage();
            return false;
        }
    }



    public function updateProject($projectId, $newTitle, $newCode, $newStartDate, $newEndDate, $newmaxhours, $newActive) {

        $query = "UPDATE projects SET title = :title, code = :code, maxhours = :maxhours, start_date = :startDate, end_date = :endDate, active = :active WHERE id = :projectId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':title', $newTitle);
        $stmt->bindParam(':maxhours', $newmaxhours);
        $stmt->bindParam(':code', $newCode);
        $stmt->bindParam(':startDate', $newStartDate);
        $stmt->bindParam(':endDate', $newEndDate);
        $stmt->bindParam(':active', $newActive);
        $stmt->bindParam(':projectId', $projectId);
        return $stmt->execute();
    }


    public function deleteProject($projectId) {
        // Logic for deleting a project
        // Example placeholder code:
        $query = "DELETE FROM projects WHERE id = :projectId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':projectId', $projectId);
        $stmt->execute();

        return true;
    }

    public function getLinkedEmployeesCount($projectId) {
        $query = "SELECT COUNT(DISTINCT user_id) AS employee_count FROM projectdata WHERE project_id = :projectId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':projectId', $projectId);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($result) ? $result['employee_count'] : 0;
    }

    public function closeProject($projectId) {
        $query = "UPDATE projects SET active = 0 WHERE id = :projectId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':projectId', $projectId);
        return $stmt->execute();
    }



    public function getProjectById($projectId) {


        $query = "SELECT * FROM projects WHERE id = :projectId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':projectId', $projectId);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public function getAllProjects() {


        $query = "SELECT * FROM projects";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getActiveProjects() {


        $query = "SELECT * FROM projects WHERE status = 'Active'";
        $stmt = $this->conn->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function linkEmployeeToProject($projectId, $userId)
    {
        $query = "INSERT INTO projectusers (project_id, user_id) VALUES (:project_id, :user_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':project_id', $projectId);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }

}

