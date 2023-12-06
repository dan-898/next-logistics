<?php

class TimeManagement
{
    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function bookHours($projectId, $userId, $date, $hours, $explanation)
    {

        $query = "INSERT INTO projectdata (project_id, user_id, entry_date, work_date, hours_worked, description) 
              VALUES (:projectId, :userId, NOW(), :workDate, :hoursWorked, :explanation)";

        // Prepare the SQL query
        $stmt = $this->conn->prepare($query);

        // Bind parameters to the prepared statement
        $stmt->bindParam(':projectId', $projectId);
        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':workDate', $date);
        $stmt->bindParam(':hoursWorked', $hours);
        $stmt->bindParam(':explanation', $explanation);


        $stmt->execute();


        return true;
    }


    public function getLinkedProjectsForUser($userId) {

        $query = "SELECT id, title FROM projects WHERE id IN (SELECT project_id FROM projectusers WHERE user_id = :userId)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getProjectHours($projectId) {
        try {
            $query = "SELECT user_id, work_date, hours_worked, description 
                      FROM projectdata 
                      WHERE project_id = :project_id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':project_id', $projectId);
            $stmt->execute();

            // Fetch project hours data
            $projectHours = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return $projectHours;
        } catch (PDOException $e) {

            return [];
        }
    }
    public function getProjectDetails($projectId) {
        try {
            $query = "SELECT * FROM projects WHERE id = :project_id";

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':project_id', $projectId);
            $stmt->execute();

            // Fetch project details
            $projectDetails = $stmt->fetch(PDO::FETCH_ASSOC);

            return $projectDetails;
        } catch (PDOException $e) {

            return null;
        }
    }


    public function getUsersForProject($projectId) {
        $query = "SELECT u.id, u.name FROM users u INNER JOIN projectusers pu ON u.id = pu.user_id WHERE pu.project_id = :projectId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':projectId', $projectId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOwnBookedHours($userId) {
        $query = "SELECT pd.project_id, pd.work_date, pd.hours_worked, pd.description
              FROM projectdata pd
              INNER JOIN projectusers pu ON pd.project_id = pu.project_id
              WHERE pd.user_id = :userId
              AND pu.user_id = :userId";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getAllProjects() {

        $query = "SELECT * FROM projects";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $projects;
    }
    public function getAllEmployees() {
        $query = "SELECT id, name FROM users WHERE role = 'employee' AND active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getEmployeeBookedHours($employeeId) {
        $query = "SELECT * FROM projectdata WHERE user_id = :employeeId";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':employeeId', $employeeId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteEmployeeHours($hoursId) {
        try {

            $query = "DELETE FROM projectdata WHERE id = :hours_worked";


            $stmt = $this->conn->prepare($query);


            $stmt->bindParam(':hours_worked', $hoursId);


            $stmt->execute();


            if ($stmt->rowCount() > 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {

            echo "Error: " . $e->getMessage();
            return false;
        }
    }




    public function getHoursDetailsById($hoursId) {
        try {
            $query = "SELECT * FROM projectdata WHERE id = :hours_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':hours_id', $hoursId);
            $stmt->execute();

            // Fetch the details
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                echo "No data found for ID: " . $hoursId;
            }

            return $result;
        } catch (PDOException $e) {
            // Handle exceptions if any
            echo "Error: " . $e->getMessage();
            return false;
        }
    }


    // Method to update hour details
    public function updateEmployeeHours($hoursId, $projectId, $date, $hours, $explanation) {
        try {
            $query = "UPDATE projectdata SET project_id = :project_id, work_date = :work_date, hours_worked = :hours_worked, description = :description WHERE id = :hours_id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':project_id', $projectId, PDO::PARAM_INT);
            $stmt->bindParam(':work_date', $date);
            $stmt->bindParam(':hours_worked', $hours, PDO::PARAM_INT);
            $stmt->bindParam(':description', $explanation);
            $stmt->bindParam(':hours_id', $hoursId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->rowCount() > 0; // Return true if any row was affected
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return false;
        }
    }

}

