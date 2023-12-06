<?php

require_once '../../OOP/database-con.php';
require_once '../../OOP/ProjectManagement.php';
require_once '../../OOP/UserManagement.php';

// Create a database connection
$database = new Database();
$conn = $database->getConnection();

$successMessage = '';

$projectManagement = new ProjectManagement($conn);
$userManagement = new UserManagement($conn);

// Fetch projects and employees from the database
$projects = $projectManagement->getAllProjects();
$employees = $userManagement->getAllEmployees(); // This is an assumption; replace it with your actual method


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Link Employees to Project</title>
    <!-- Add necessary Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Additional custom styles */
        body {
            padding: 20px;
        }
        form {
            max-width: 400px;
            margin: 0 auto;
        }
        h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Link Employees to Project</h2>
    <?php if (isset($successMessage)) { ?>
        <div class="alert alert-success" role="alert">
            <h4> linked successfully</h4>
            <?php echo $successMessage; ?>
        </div>
    <?php } ?>
    <form method="post" action="link_employees_process.php">
        <div class="form-group">
            <label for="project_id">Select Project:</label>
            <select id="project_id" name="project_id" class="form-control">
                <!-- Fetch and display projects from the database -->
                <?php foreach ($projects as $project) { ?>
                    <option value="<?php echo $project['id']; ?>"><?php echo $project['title']; ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="form-group">
            <label for="employee_id">Select Employee:</label>
            <select id="employee_id" name="employee_id" class="form-control">
                <!-- Fetch and display employees from the database -->
                <?php foreach ($employees as $employee) { ?>
                    <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" name="link_employee" class="btn btn-primary">Link Employee</button>
    </form>
</div>

<!-- Add necessary Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

