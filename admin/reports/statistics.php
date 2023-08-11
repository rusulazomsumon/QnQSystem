
   <!-- theree chat will show, expence, investor, projects -->
   <div class="container">
        <div style="max-width: auto;">
            <canvas id="myPieChart" width="100%" height="100"></canvas>
        </div>
    </div>

    <script>
    // Retrieve data from the database
    <?php
    $data = [];
    $query = "SELECT SUM(CASE WHEN is_credit = 0 THEN amount ELSE 0 END) AS debit_amount, SUM(CASE WHEN is_credit = 1 THEN amount ELSE 0 END) AS credit_amount FROM khata";
    $result = $conn->query($query);

    if ($row = $result->fetch_assoc()) {
        $data = $row;
    }
    ?>

    // Organize data for the chart
    const debitAmount = <?php echo $data['debit_amount']; ?>;
    const creditAmount = <?php echo $data['credit_amount']; ?>;
    
    const ctx = document.getElementById('myPieChart').getContext('2d');
    const myPieChart = new Chart(ctx, {
        type: 'bar',
        // changeing the type, you can make chart, line, pie, 
        data: {
            labels: ['Debit', 'Credit'],
            datasets: [{
                data: [debitAmount, creditAmount],
                backgroundColor: ['red', 'green']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
            // Customize other options as needed
        }
    });
    </script>



