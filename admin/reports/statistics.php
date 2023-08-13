<?php

// Query to fetch individual users with type = 2
$query = "SELECT u.id, u.firstname, u.lastname
          FROM users u
          WHERE u.type = 2";

$result = mysqli_query($conn, $query);

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $userId = $row['id'];
        $userName = $row['firstname'] . ' ' . $row['lastname'];

        // Query to calculate Total Investment for the user
        $investmentQuery = "SELECT SUM(k.amount) AS total_investment
                            FROM khata k
                            INNER JOIN source s ON k.Issue = s.Id
                            WHERE k.u_id = $userId AND s.Id = 2 AND k.is_credit = 1";

        $investmentResult = mysqli_query($conn, $investmentQuery);
        $investmentRow = mysqli_fetch_assoc($investmentResult);
        $totalInvestment = $investmentRow['total_investment'];

        // Query to calculate Total Credit for the user
        $creditQuery = "SELECT SUM(amount) AS total_credit
                        FROM khata
                        WHERE u_id = $userId AND is_credit = 1";

        $creditResult = mysqli_query($conn, $creditQuery);
        $creditRow = mysqli_fetch_assoc($creditResult);
        $totalCredit = $creditRow['total_credit'];

        // Query to calculate Total Debit for the user
        $debitQuery = "SELECT SUM(amount) AS total_debit
                       FROM khata
                       WHERE u_id = $userId AND is_credit = 0";

        $debitResult = mysqli_query($conn, $debitQuery);
        $debitRow = mysqli_fetch_assoc($debitResult);
        $totalDebit = $debitRow['total_debit'];

          // Display user data using Bootstrap card layout
        echo '<div class="card mb-3">';
            echo '<div class="card-body">';
                echo '<div class="row">';
                    echo '<div class="col-md-12">';
                        echo '<h1 class="card-title">' . $userName . '</h1>';
                        echo '<p class="card-text"><strong>Total Investment:</strong> ' . $totalInvestment . '</p>';
                        echo '<p class="card-text"><strong>Total Credit:</strong> ' . $totalCredit . '</p>';
                        echo '<p class="card-text"><strong>Total Debit:</strong> ' . $totalDebit . '</p>';
                        echo '<a href="./reports/single_user_stat.php?user_id=' . $userId . '" class="btn btn-primary">View Details</a>';
                    echo '</div>';
                echo '</div>';
            echo '</div>';
        echo '</div>';
        
    }

    mysqli_free_result($result);
} else {
    echo "Error: " . mysqli_error($conn);
}

// Close the database connection
?>
