<?php
require_once '../OOP/database-con.php';
require_once '../OOP/TimeManagement.php';

$database = new Database();
$conn = $database->getConnection();
$timeManagement = new TimeManagement($conn);
$successMessage = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_hours'])) {
    $hoursId = $_POST['hours_id'];
    $projectId = $_POST['project_id'];
    $date = $_POST['date'];
    $hours = $_POST['hours'];
    $explanation = $_POST['explanation'];

    $success = $timeManagement->updateEmployeeHours($hoursId, $projectId, $date, $hours, $explanation);

    if ($success) {

        $successMessage = 'Hours updated successfully.';

    } else {
        echo "Update failed. Please try again.";
    }

}


if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $hoursId = $_GET['id'];
    $hoursDetails = $timeManagement->getHoursDetailsById($hoursId);

    if (!$hoursDetails) {
        echo "Hours details not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Update Hours</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Update Hours</h2>
    <?php if (!empty($successMessage)) { ?>
        <div class="alert alert-success" role="alert">
            <?php echo $successMessage; ?>
        </div>
    <?php } ?>

    <?php if (isset($hoursDetails) && $hoursDetails) { ?>
        <form method="post" action="">
            <input type="hidden" name="hours_id" value="<?php echo $hoursDetails['id']; ?>">
            <input type="text" name="project_id" value="<?php echo $hoursDetails['project_id']; ?>">
            <input type="date" name="date" value="<?php echo $hoursDetails['work_date']; ?>">
            <input type="number" name="hours" value="<?php echo $hoursDetails['hours_worked']; ?>">
            <input type="text" name="explanation" value="<?php echo $hoursDetails['description']; ?>">
            <button type="submit" name="update_hours">Update Hours</button>
        </form>
    <?php } ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>


