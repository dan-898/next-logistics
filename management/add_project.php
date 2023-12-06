<?php
require_once '../OOP/database-con.php';
require_once '../OOP/ProjectManagement.php';


$database = new Database();
$conn = $database->getConnection();


$projectManagement = new ProjectManagement($conn);

// Initialize variables
$successMessage = '';

// Handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $code = $_POST['code'];
    $startDate = $_POST['start_date'];
    $endDate = $_POST['end_date'];
    $maxHours = $_POST['max_hours'];
    $isActive = isset($_POST['active']) ? 1 : 0;


    $addResult = $projectManagement->addProject($title, $code, $startDate, $endDate, $maxHours, $isActive);

    // Handle the result
    if ($addResult) {

        $successMessage = 'Project added successfully!';
    } else {

        header("Location: error_page.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Project</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .short-input {
            width: 300px;

    </style>

</head>
<body>
<div class="container mt-4">
    <h2>Add Project</h2>
    <?php if ($successMessage !== '') { ?>
        <div class="alert alert-success" role="alert">
            <?php echo $successMessage; ?>
        </div>
    <?php } ?>

    <form method="post">
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control form-control-sm short-input" id="title" required>
        </div>
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" name="code" class="form-control form-control-sm short-input" id="code" required>
        </div>
        <div class="form-group">
            <label for="start_date">Start Date</label>
            <input type="date" name="start_date" class="form-control form-control-sm short-input" id="start_date" required>
        </div>
        <div class="form-group">
            <label for="end_date">End Date</label>
            <input type="date" name="end_date" class="form-control form-control-sm short-input" id="end_date" required>
        </div>
        <div class="form-group">
            <label for="max_hours">Max Hours</label>
            <input type="number" name="max_hours" class="form-control form-control-sm short-input" id="max_hours" required>
        </div>
        <div class="form-check">
            <input type="checkbox" name="active" class="form-check-input" id="active">
            <label class="form-check-label" for="active">Active</label>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Add Project</button>
    </form>
</div>

<!-- Add Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
