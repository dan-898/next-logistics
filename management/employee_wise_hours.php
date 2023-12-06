<?php

require_once '../OOP/database-con.php';
require_once '../OOP/UserPermissions.php';
require_once '../OOP/TimeManagement.php';


$database = new Database();
$conn = $database->getConnection();

// Instantiate classes
$userPermissions = new UserPermissions($conn);
$timeManagement = new TimeManagement($conn);


$userId = 1;

// Fetch all active employees
$employees = $timeManagement->getAllEmployees(); // Replace with your method to fetch employees

// Handling form submissions
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['view_hours'])) {
    $selectedEmployeeId = $_POST['employee_id'];

    // Fetch booked hours for the selected employee
    $bookedHours = $timeManagement->getEmployeeBookedHours($selectedEmployeeId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Employee Worked Hours</title>
    <!-- Add necessary Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Employee Worked Hours</h2>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4">
        <div class="form-group">
            <label for="employee_id">Select Employee:</label>
            <select id="employee_id" name="employee_id" class="form-control">
                <?php foreach ($employees as $employee) { ?>
                    <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" name="view_hours" class="btn btn-primary">View Worked Hours</button>
    </form>

    <?php if (isset($bookedHours) && !empty($bookedHours)) { ?>
        <div class="mt-4">
            <table class="table">
                <thead>
                <tr>
                    <th>Project ID</th>
                    <th>Date</th>
                    <th>Hours</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bookedHours as $hours) { ?>
                    <tr>
                        <td><?php echo $hours['project_id']; ?></td>
                        <td><?php echo $hours['work_date']; ?></td>
                        <td><?php echo $hours['hours_worked']; ?></td>
                        <td><?php echo $hours['description']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } elseif (isset($bookedHours) && empty($bookedHours)) { ?>
        <p class="mt-4">No booked hours found for this employee.</p>
    <?php } ?>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
