<?php
include('../../config.php');
include('../inc/header.php');
include('../inc/navigation.php');
include('../inc/topBarNav.php');
?>

<!-- Content Container -->
<div class="content-container">
    <div class="row">
        <div class="col-md-3">
            <!-- Left column, empty space -->
        </div>
        <div class="col-md-9">
            <?php
            if (isset($_GET['user_id'])) {
                $userId = $_GET['user_id'];

                // Query to fetch user details
                $queryUser = "SELECT username FROM users WHERE id = $userId";
                $resultUser = mysqli_query($conn, $queryUser);
                $username = mysqli_fetch_assoc($resultUser)['username'];

                // Query to fetch user transactions
                $queryTransactions = "SELECT khata.*, source.title AS issue_title
                                      FROM khata
                                      LEFT JOIN source ON khata.Issue = source.Id
                                      WHERE khata.u_id = $userId
                                      ORDER BY khata.Id DESC";

                $resultTransactions = mysqli_query($conn, $queryTransactions);

                if ($resultTransactions) {
                    echo '<h3>All Transactions by: ' . $username . '</h3>'; // Display the message in an h1 tag
                    echo '<hr>';
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

                    while ($row = mysqli_fetch_assoc($resultTransactions)) {
                        echo '<tr>';
                        echo '<td>' . $row['entry_time_date'] . '</td>';
                        echo '<td>' . $row['issue_title'] . '</td>';
                        echo '<td>' . $row['amount'] . '</td>';
                        echo '<td>' . ($row['is_credit'] == 1 ? 'Credit' : 'Debit') . '</td>';
                        echo '</tr>';
                    }

                    echo '</tbody>';
                    echo '</table>';

                    mysqli_free_result($resultTransactions);
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "User ID not provided.";
            }
            ?>
        </div>
    </div>
</div>


<!-- End Content Container -->

<?php
// Close the database connection
?>
