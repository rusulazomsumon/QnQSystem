<?php

require_once('../config.php'); 


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $user_id = $_POST['user_id'];
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $issue = $_POST['issue'];
    $is_credit = $_POST['is_credit'];

    // Insert data into the khata table
    $insertQuery = "INSERT INTO khata (u_id, Description, amount, Issue, is_credit) 
                    VALUES ('$user_id', '$description', '$amount', '$issue', '$is_credit')";
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
    <title>Expense Entry Form</title>
    <!-- Include Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h3>Expense Entry Form</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label for="user_id">User:</label>
                <select class="form-control" name="user_id">
                    <!-- Populate user options from your database -->
                    <?php
                    $userQuery = "SELECT id, username FROM users";
                    $userResult = $conn->query($userQuery);

                    while ($userRow = $userResult->fetch_assoc()) {
                        echo '<option value="' . $userRow['id'] . '">' . $userRow['username'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" name="description" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" class="form-control" name="amount" required>
            </div>
            <div class="form-group">
                <label for="issue">Issue:</label>
                <select class="form-control" name="issue">
                    <!-- Populate issue options from your database -->
                    <?php
                    $issueQuery = "SELECT Id, title FROM source";
                    $issueResult = $conn->query($issueQuery);

                    while ($issueRow = $issueResult->fetch_assoc()) {
                        echo '<option value="' . $issueRow['Id'] . '">' . $issueRow['title'] . '</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="is_credit">Expence Type:</label> <br>
                <input type="radio" id="is_credit_debit" name="is_credit" value="0" required>
                <label for="is_credit_debit">Debit</label>
                <input type="radio" id="is_credit_credit" name="is_credit" value="1" required>
                <label for="is_credit_credit">Credit</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
