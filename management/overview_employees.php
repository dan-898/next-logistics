<?php

require_once '../OOP/database-con.php';
require_once '../OOP/UserPermissions.php';
require_once '../OOP/TimeManagement.php';

$database = new Database();
$conn = $database->getConnection();

// Instantiate classes
$userPermissions = new UserPermissions($conn);
$timeManagement = new TimeManagement($conn);

// Fetch all employees
$employees = $timeManagement->getAllEmployees();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Overview</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Employee Overview</h2>

    <?php if (!empty($employees)) { ?>
        <table class="table mt-4">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Role</th>

            </tr>
            </thead>
            <tbody>
            <?php foreach ($employees as $employee) { ?>
                <tr>
                    <td><?php echo $employee['id']; ?></td>
                    <td><?php echo $employee['name']; ?></td>
                    <td><?php echo isset($employee['role']) ? ucfirst($employee['role']) : 'N/A'; ?></td>
                    <!-- Display other employee information within respective table cells -->
                </tr>
            <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="mt-4">No employees found.</p>
    <?php } ?>
</div>

<!-- Add necessary Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
