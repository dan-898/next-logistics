<?php

require_once '../../OOP/database-con.php';
require_once '../../OOP/ProjectManagement.php';

// Create a database connection
$database = new Database();
$conn = $database->getConnection();

// Instantiate ProjectManagement class
$projectManagement = new ProjectManagement($conn);

// Fetch all projects
$projects = $projectManagement->getAllProjects(); // Assuming a method to fetch all projects

// ... (previous PHP code to fetch projects)

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['change_project'])) {
        // Handle edit project action
        $projectId = $_POST['project_id'];
        header("Location: change_project.php?id=$projectId");
        exit();
    }

    if (isset($_POST['delete_project'])) {
        // Handle delete project action
        $projectId = $_POST['project_id'];
        header("Location: delete_project.php?id=$projectId");
        exit();
    }

    if (isset($_POST['close_project'])) {
        $projectId = $_POST['project_id'];
        header("Location: close_project.php?id=$projectId");
        exit();
    }

    if (isset($_POST['link_employees'])) {
        // Handle link employees action
        $projectId = $_POST['project_id'];
        header("Location: link_employees.php?id=$projectId");
        exit();
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <title>All Projects</title>
    <!-- Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Optional Bootstrap theme -->
    <!-- link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap-theme.min.css" rel="stylesheet" -->

    <style>
        .active-status {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 5px;
        }

        .active-dot {
            background-color: green;
        }

        .inactive-dot {
            background-color: rgb(103, 103, 103);
        }
    </style>
</head>
<body>
<div class="container mt-4">
    <h2>All Projects</h2>
    <table class="table table-bordered">
        <thead class="thead-dark">
        <tr>
            <th>Title</th>
            <th>Code</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Active</th>
            <th>Max Hours</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($projects as $project) { ?>
            <tr>
                <td><?php echo $project['title']; ?></td>
                <td><?php echo $project['code']; ?></td>
                <td><?php echo $project['start_date']; ?></td>
                <td><?php echo $project['end_date']; ?></td>
                <td>
                    <?php if ($project['active'] == 1) { ?>
                        <span class="active-status active-dot"></span>
                    <?php } else { ?>
                        <span class="active-status inactive-dot"></span>
                    <?php } ?>
                </td>
                <td><?php echo $project['maxhours']; ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="project_id" value="<?php echo $project['id']; ?>">
                        <button type="submit" class="btn btn-primary" name="change_project">Edit</button>
                        <button type="submit" class="btn btn-danger" name="delete_project">Delete</button>
                        <button type="submit" class="btn btn-warning" name="close_project">Close</button>
                        <button type="submit" class="btn btn-success" name="link_employees">Link Employees</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>

<!-- Bootstrap JS and jQuery links -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
