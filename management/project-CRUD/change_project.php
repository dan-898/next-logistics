<?php

require_once '../../OOP/database-con.php';
require_once '../../OOP/ProjectManagement.php';

// Create a database connection
$database = new Database();
$conn = $database->getConnection();

// Instantiate ProjectManagement class
$projectManagement = new ProjectManagement($conn);

// Get project details to populate the form
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $projectId = $_GET['id'];

    // Fetch project details
    $project = $projectManagement->getProjectById($projectId);
}

// Handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $code = $_POST['code'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $maxhours = $_POST['maxhours'];
    $isActive = isset($_POST['active']) ? 1 : 0;

    // Update project details
    $updateResult = $projectManagement->updateProject($projectId, $title, $code, $startDate, $endDate, $maxhours, $isActive);

    // Handle the update result (success or failure)
    if ($updateResult) {
        // Redirect or show success message
        header("Location: projects.php"); // Redirect to projects list page
        exit();
    } else {
        $errorMessage = "Failed to update the project."; // Show error message
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Change Project</title>
    <!-- Add Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
<div class="container">
    <h2>Edit Project</h2>
    <?php if (isset($errorMessage)) {
        echo '<div class="alert alert-danger">' . $errorMessage . '</div>';
    } ?>

    <form method="post">
        <?php if (isset($project) && is_array($project)) { ?>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="title">Title:</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?php echo $project['title']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="code">Code:</label>
                    <input type="text" class="form-control" id="code" name="code" value="<?php echo $project['code']; ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="start_date">Start Date:</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="<?php echo $project['start_date']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="end_date">End Date:</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="<?php echo $project['end_date']; ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-6 mb-3">
                    <label for="maxhours">Max Hours:</label>
                    <input type="number" class="form-control" id="maxhours" name="maxhours" value="<?php echo $project['maxhours']; ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="active">Active:</label>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="active" name="active" <?php if ($project['active']) echo 'checked'; ?>>
                        <label class="form-check-label" for="active">Active</label>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <p>Project details not found.</p>
        <?php } ?>
        <button type="submit" class="btn btn-primary">Update Project</button>
    </form>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

