<?php

include('../../config.php');

include('../inc/header.php');
include('../inc/navigation.php');
include('../inc/header.php');
include('../inc/topBarNav.php');


if (isset($_GET['user_id'])) {
    $userId = $_GET['user_id'];

    // Query to fetch user details
    $query = "SELECT khata.*, users.username, source.title AS issue_title
              FROM khata
              LEFT JOIN users ON khata.u_id = users.id
              LEFT JOIN source ON khata.Issue = source.Id
              WHERE khata.u_id = $userId
              ORDER BY khata.Id DESC";

    $result = mysqli_query($conn, $query);

    if ($result) {
        // Display user details in a table
        echo '<table class="table">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Date</th>';
        echo '<th>Issue</th>';
        echo '<th>Amount</th>';
        echo '<th>Credit/Debit</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['entry_time_date'] . '</td>';
            echo '<td>' . $row['issue_title'] . '</td>';
            echo '<td>' . $row['amount'] . '</td>';
            echo '<td>' . ($row['is_credit'] == 1 ? 'Credit' : 'Debit') . '</td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        mysqli_free_result($result);
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "User ID not provided.";
}

// Close the database connection
?>
