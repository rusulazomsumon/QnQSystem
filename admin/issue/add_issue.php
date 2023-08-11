<?php

require_once('../config.php'); 


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Insert data into the khata table
    $insertQuery = "INSERT INTO source (title, description) 
                    VALUES ('$title', '$description')";
    if ($conn->query($insertQuery) === TRUE) {
        echo '<div class="alert alert-success" role="alert">Data inserted successfully!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Issue Entry Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>

     <!-- Issue Entry Form -->
     <div class="container">
        <h3>Issue Entry Form</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label for="title">Issue Name:</label>
                <input type="text" class="form-control" name="title" required>
            </div>
            <div class="form-group">
                <label for="description">Issue Description</label>
                <input type="text" class="form-control" name="description" required>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <!-- All Registered Issue -->
    <div class="container mt-5">
        <h3>Issue List</h3>
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $issueQuery = "SELECT Id, title, description FROM source";
                $issueResult = $conn->query($issueQuery);

                while ($issueRow = $issueResult->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . $issueRow['Id'] . '</td>';
                    echo '<td>' . $issueRow['title'] . '</td>';
                    echo '<td>' . $issueRow['description'] . '</td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
