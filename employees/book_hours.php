<?php

require_once '../OOP/database-con.php';
require_once '../OOP/UserPermissions.php';
require_once '../OOP/TimeManagement.php';

// Create a database connection
$database = new Database();
$conn = $database->getConnection();

// Instantiate classes
$userPermissions = new UserPermissions($conn);
$timeManagement = new TimeManagement($conn);

// Assuming user ID 1 for demonstration purposes
$userId = 1;

// Handling form submissions
$successMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_hours'])) {
        $projectId = $_POST['project_id']; // Project selected by the user

        // Assuming you have methods to validate input values
        $date = $_POST['date'];
        $hours = $_POST['hours'];
        $explanation = $_POST['explanation'];

        // Save the booked hours for the user on the selected project
        $success = $timeManagement->bookHours($projectId, $userId, $date, $hours, $explanation);

        if ($success) {
            // Set success message if hours are booked
            $successMessage = 'Hours booked successfully!';
        } else {
            // Display an error message or redirect to an error page
            header("Location: booked_hours_error.php");
            exit();
        }
    }
}

// Fetch projects where the user is linked
$linkedProjects = $timeManagement->getLinkedProjectsForUser($userId); // Replace with your method
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Book Hours</title>

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Book Hours</h2>

    <!-- Display success message if applicable -->
    <?php if ($successMessage !== '') { ?>
        <div class="alert alert-success" role="alert">
            <?php echo $successMessage; ?>
        </div>
    <?php } ?>

    <!-- Form to select project -->
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="mt-4">
        <div class="form-group">
            <label for="project_id">Select Project:</label>
            <select id="project_id" name="project_id" class="form-control">
                <?php foreach ($linkedProjects as $project) { ?>
                    <option value="<?php echo $project['id']; ?>"><?php echo $project['title']; ?></option>
                <?php } ?>
            </select>
        </div>
        <button type="submit" name="submit_project" class="btn btn-primary">Show Linked Employees</button>
    </form>

    <?php
    // Display form for booking hours
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_project'])) {
        $selectedProjectId = $_POST['project_id'];

        // Fetch linked employees for the selected project
        $linkedEmployees = $timeManagement->getUsersForProject($selectedProjectId); // Replace with your method

        if (!empty($linkedEmployees)) {
            ?>
            <form method="post" action="book_hours.php" class="mt-4">
                <input type="hidden" name="project_id" value="<?php echo $selectedProjectId; ?>">
                <div class="form-group">
                    <label for="employee_id">Select Employee:</label>
                    <select id="employee_id" name="employee_id" class="form-control">
                        <?php foreach ($linkedEmployees as $employee) { ?>
                            <option value="<?php echo $employee['id']; ?>"><?php echo $employee['name']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Date:</label>
                    <input type="date" id="date" name="date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="hours">Number of Hours:</label>
                    <input type="number" id="hours" name="hours" class="form-control" min="1" required>
                </div>
                <div class="form-group">
                    <label for="explanation">Explanation:</label>
                    <textarea id="explanation" name="explanation" class="form-control" rows="4" cols="50" required></textarea>
                </div>
                <button type="submit" name="submit_hours" class="btn btn-primary">Book Hours</button>
            </form>
            <?php
        } else {
            echo "<p class='mt-4'>No linked employees found for the selected project.</p>";
        }
    }
    ?>
</div>

<!-- Add necessary Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
