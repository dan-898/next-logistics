<?php

require_once '../OOP/database-con.php';
require_once '../OOP/UserPermissions.php';
require_once '../OOP/TimeManagement.php';

$database = new Database();
$conn = $database->getConnection();


$userPermissions = new UserPermissions($conn);
$timeManagement = new TimeManagement($conn);

// Fetch all projects
$projects = $timeManagement->getAllProjects();

// Handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['view_hours'])) {
    $selectedProjectId = $_POST['project_id'];

    // Fetch booked hours for the selected project
    $projectHours = $timeManagement->getProjectHours($selectedProjectId);

    // Fetch project details
    $projectDetails = $timeManagement->getProjectDetails($selectedProjectId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Project Wise Hours</title>
    <!-- Add necessary Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Project Wise Hours</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4">
        <div class="form-group">
            <label for="project_id">Select Project:</label>
            <select id="project_id" name="project_id" class="form-control">
                <?php foreach ($projects as $project) { ?>
                    <option value="<?php echo $project['id']; ?>"><?php echo $project['title']; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" name="view_hours" class="btn btn-primary">View Project Hours</button>
    </form>

    <?php if (isset($projectHours) && !empty($projectHours)) { ?>
        <div class="mt-4">
            <h3>Project: <?php echo $projectDetails['title']; ?></h3>
            <table class="table">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Hours</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($projectHours as $hours) { ?>
                    <tr>
                        <td><?php echo $hours['work_date']; ?></td>
                        <td><?php echo $hours['hours_worked']; ?></td>
                        <td><?php echo $hours['description']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } elseif (isset($projectHours) && empty($projectHours)) { ?>
        <p class="mt-4">No hours recorded for this project.</p>
    <?php } ?>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
