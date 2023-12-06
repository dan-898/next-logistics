<?php

require_once '../OOP/database-con.php';
require_once '../OOP/UserPermissions.php';
require_once '../OOP/TimeManagement.php';


$database = new Database();
$conn = $database->getConnection();

// Instantiate classes
$userPermissions = new UserPermissions($conn);
$timeManagement = new TimeManagement($conn);

// Handling form submissions for editing or deleting hours
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['edit_hours'])) {
        $hoursId = $_POST['hours_id'];
        // Redirect to the edit page with the specific hours ID
        header("Location: update_hours.php?id=$hoursId");
        exit();
    } elseif (isset($_POST['delete_hours'])) {
        $hoursId = $_POST['hours_id'];
        // Perform deletion using $hoursId
        $success = $timeManagement->deleteEmployeeHours($hoursId); // Replace with your deletion method

        // Redirect to appropriate page after deletion
        if ($success) {
            header("Location: manage_employee_hours.php");
            exit();
        } else {
            // Handle deletion failure or show an error message
            echo "Deletion failed. Please try again.";
        }
    }
}

// Fetch all active employees
$employees = $timeManagement->getAllEmployees(); // Replace with your method to fetch employees

// Fetch booked hours for the selected employee if selected
if (isset($_GET['employee_id'])) {
    $selectedEmployeeId = $_GET['employee_id'];
    $bookedHours = $timeManagement->getEmployeeBookedHours($selectedEmployeeId);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage Employee Hours</title>
    <!-- Add necessary Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Manage Employee Hours</h2>

    <!-- Form to select employee -->
    <form method="get" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4">
        <div class="form-group">
            <label for="employee_id">Select Employee:</label>
            <select id="employee_id" name="employee_id" class="form-control">
                <?php foreach ($employees as $employee) { ?>
                    <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name']; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" name="view_hours" class="btn btn-primary">View Employee Hours</button>
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
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($bookedHours as $hours) { ?>
                    <tr>
                        <td><?php echo $hours['project_id']; ?></td>
                        <td><?php echo $hours['work_date']; ?></td>
                        <td><?php echo $hours['hours_worked']; ?></td>
                        <td><?php echo $hours['description']; ?></td>
                        <td>
                            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                <input type="hidden" name="hours_id" value="<?php echo $hours['id']; ?>">
                                <button type="submit" name="edit_hours" class="btn btn-sm btn-primary">Edit</button>
                                <button type="submit" name="delete_hours" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this entry?')">Delete</button>
                            </form>
                        </td>
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
