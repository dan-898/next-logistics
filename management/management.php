<!DOCTYPE html>
<html>
<head>
    <title>Management Dashboard</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h1 class="mb-4">Management Dashboard</h1>
    <div class="row">
        <div class="col-md-6">
            <h3>Actions and Overview</h3>
            <ul class="list-group">
                <li class="list-group-item"><a href="add_project.php">Add New Project</a></li>
                <li class="list-group-item"><a href="project-CRUD/projects.php">Projects</a></li>
                <li class="list-group-item"><a href="manage_employee_hours.php">Manage Employee Hours</a></li>
                <!-- Other relevant management actions -->
            </ul>
        </div>
        <div class="col-md-6">
            <h3>Reports and Overviews</h3>
            <ul class="list-group">
                <li class="list-group-item"><a href="overview_projects.php">Overview of Projects</a></li>
                <li class="list-group-item"><a href="overview_employees.php">Overview of Employees</a></li>
                <li class="list-group-item"><a href="project_wise_hours.php">Project-wise Hours</a></li>
                <li class="list-group-item"><a href="employee_wise_hours.php">Employee-wise Hours</a></li>


            </ul>
        </div>
    </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
