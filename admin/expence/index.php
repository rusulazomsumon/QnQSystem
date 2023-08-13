<?php
require_once('../config.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_settings->userdata('id');
    $description = $_POST['description'];
    $amount = $_POST['amount'];
    $issue = $_POST['issue'];
    $is_credit = $_POST['is_credit'];

    // Handle attachment file upload
    if (isset($_FILES['attachment'])) {
        $targetDirectory = __DIR__ . '/../../../media/'; // Adjust path
        $attachmentPath = '/ajms/media/' . basename($_FILES['attachment']['name']);

        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($attachmentPath, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($attachmentPath)) {
            echo '<div class="alert alert-danger" role="alert">File already exists.</div>';
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != 'jpg' && $imageFileType != 'png' && $imageFileType != 'jpeg') {
            echo '<div class="alert alert-danger" role="alert">Only JPG, JPEG, and PNG files are allowed.</div>';
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo '<div class="alert alert-danger" role="alert">File was not uploaded.</div>';
        } else {
            $targetDirectory = $_SERVER['DOCUMENT_ROOT'] . '/ajms/media/'; // Absolute path
$attachmentPath = '/ajms/media/' . basename($_FILES['attachment']['name']);

if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetDirectory . basename($_FILES['attachment']['name']))) {
    // Insert data into the khata table including attachment path
    $insertQuery = "INSERT INTO khata (u_id, Description, amount, Issue, is_credit, attach) 
                    VALUES ('$user_id', '$description', '$amount', '$issue', '$is_credit', '$attachmentPath')";
    if ($conn->query($insertQuery) === TRUE) {
        echo '<div class="alert alert-success" role="alert">Data inserted successfully!</div>';
    } else {
        echo '<div class="alert alert-danger" role="alert">Error: ' . $conn->error . '</div>';
    }
} else {
    echo '<div class="alert alert-danger" role="alert">File upload failed.</div>';
}
        }
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
        <h3>Expense Entry Form:</h3>
        <form action="" method="POST" enctype="multipart/form-data">
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
                <label for="description">Description:</label>
                <input type="text" class="form-control" name="description" required>
            </div>
            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" class="form-control" name="amount" required>
            </div>
            
            <div class="form-group">
                <label for="is_credit">Expence Type:</label> <br>
                <input type="radio" id="is_credit_debit" name="is_credit" value="0" required>
                <label for="is_credit_debit">Debit</label>
                <input type="radio" id="is_credit_credit" name="is_credit" value="1" required>
                <label for="is_credit_credit">Credit</label>
            </div>
            <!-- add attachment file -->
            <div class="form-group">
                <label for="attachment">Attachment:</label>
                <input type="file" class="form-control-file" name="attachment">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>
