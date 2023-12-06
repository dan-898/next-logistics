<?php

require_once '../OOP/database-con.php';
require_once '../OOP/UserPermissions.php';
require_once '../OOP/TimeManagement.php';


$database = new Database();
$conn = $database->getConnection();

// Instantiate classes
$userPermissions = new UserPermissions($conn);
$timeManagement = new TimeManagement($conn);

// Fetch all projects
$projects = $timeManagement->getAllProjects();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Overview of Projects</title>
    <!-- Add necessary Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Overview of Projects</h2>

    <?php if (!empty($projects)) { ?>
        <table class="table mt-4">
            <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Active</th>
                <th>Code</th>
                <th>Actual</th>
                <th>Max Hours</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($projects as $project) { ?>
                <tr>
                    <td><?php echo $project['id']; ?></td>
                    <td><?php echo $project['title']; ?></td>
                    <td><?php echo $project['start_date']; ?></td>
                    <td><?php echo $project['end_date']; ?></td>
                    <td><?php echo $project['active']; ?></td>
                    <td><?php echo $project['code']; ?></td>
                    <td><?php echo $project['actual']; ?></td>
                    <td><?php echo $project['maxhours']; ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p>No projects found.</p>
    <?php } ?>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
