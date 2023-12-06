<?php

require_once '../../OOP/database-con.php';
require_once '../../OOP/ProjectManagement.php';

$database = new Database();
$conn = $database->getConnection();

// Instantiate ProjectManagement class
$projectManagement = new ProjectManagement($conn);

// Check if the project ID is set and handle the deletion
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_project'])) {
    $projectId = $_POST['project_id'];

    // Check if there are linked employees to this project
    $linkedEmployees = $projectManagement->getLinkedEmployeesCount($projectId);

    // If there are linked employees, display a message
    if ($linkedEmployees > 0) {
        echo "There are linked employees to this project. You cannot delete it.";
        // You can provide additional instructions or handle it as needed
    } else {
        // No linked employees, proceed with the deletion
        $projectManagement->deleteProject($projectId);

        // Redirect to the page showing all projects or any other relevant page
        header("Location: projects.php");
        exit();
    }
}

// Retrieve the project details based on the provided ID
if (isset($_GET['id'])) {
    $projectId = $_GET['id'];
    $project = $projectManagement->getProjectById($projectId);
    if (!$project) {
        // Handle invalid project ID
        // You can redirect to an error page or handle it as needed
        header("Location: error.php");
        exit();
    }
} else {
    // Handle missing project ID
    // You can redirect to an error page or handle it as needed
    header("Location: error.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Delete Project</title>
    <!-- Add necessary Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Add any additional CSS styles here */
        body {
            padding: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Delete Project: <?php echo $project['title']; ?></h2>
    <p>Are you sure you want to delete this project?</p>

    <form method="post">
        <input type="hidden" name="project_id" value="<?php echo $projectId; ?>">
        <button type="submit" name="delete_project" class="btn btn-danger">Confirm Delete</button>
    </form>
</div>

<!-- Add necessary Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>