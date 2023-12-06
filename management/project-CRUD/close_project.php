<?php
require_once '../../OOP/database-con.php';
require_once '../../OOP/ProjectManagement.php';


$database = new Database();
$conn = $database->getConnection();


$projectManagement = new ProjectManagement($conn);

// Handling form submissions for closing a project
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['close_project'])) {
        $projectId = $_POST['project_id'];
        $projectManagement->closeProject($projectId);
        // Add logic for redirecting or displaying a success message
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Close Project</title>

</head>
<body>
<h2>Close Project</h2>
<form method="post">
    <input type="hidden" name="project_id" value="<?php echo $_GET['id']; ?>">
    <button type="submit" name="close_project">Close Project</button>
</form>
</body>
</html>
