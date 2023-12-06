<?php

require_once '../../OOP/database-con.php';
require_once '../../OOP/ProjectManagement.php';
require_once '../../OOP/UserManagement.php';

// Create a database connection
$database = new Database();
$conn = $database->getConnection();

// Instantiate ProjectManagement and UserManagement classes
$projectManagement = new ProjectManagement($conn);
$userManagement = new UserManagement($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['link_employee'])) {
    // Get selected project and employee IDs from the form
    $projectId = $_POST['project_id'];
    $employeeId = $_POST['employee_id'];

    // Link the employee to the project
    $success = $projectManagement->linkEmployeeToProject($projectId, $employeeId);

    if ($success) {

        header("Location: link_employees.php?success=true");
        exit();
    } else {

        header("Location: link_employees.php?error=true");
        exit();
    }
} else {
    // Handle invalid requests or redirects if necessary
    header("Location: link_employees.php");
    exit();
}




