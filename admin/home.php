<style>
    .scroll-message {
    height: 50px;
    overflow: hidden;
    position: relative;
    background: #337ab7;
    color: #fff;
    border: 1px solid #fff;
}

.scroll-message p {
    position: absolute;
    width: 100%;
    height: 100%;
    margin: 0;
    line-height: 50px;
    text-align: center;
    /* Starting position */
    transform:translateX(100%);
    /* Apply animation to this element */
    animation: scroll-message 20s linear infinite;
}

/* Move it (define the animation) */
@keyframes scroll-message {
    0% { transform: translateX(100%); }
    100% { transform: translateX(-100%); }
}
</style>

<!-- <h1>Welcome to <?php echo $_settings->info('name') ?> </h1> -->
<!-- <hr class="border-border bg-primary"> -->
<!-- Notice Board / short massage -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="scroll-message bg-primary text-white">
                <p><?php echo $_settings->info('short_msg') ?></p>
            </div>
        </div>
    </div>
</div>
<div class="row mt-3">
    <!-- statictics chart here -->
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <?php require_once('reports/chart.php') ?>
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-navy elevation-1"><i class="far fa-money-bill-alt"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Current Balance</span>
            <span class="info-box-number text-right">
                <!-- <?php 
                    echo $conn->query("SELECT * FROM `group_list` where delete_flag = 0 and status = 1 ")->num_rows;
                ?> -->
                <!-- show total ammount -->
                <?php 
                    $result = $conn->query("SELECT SUM(CASE WHEN is_credit = 0 THEN -amount ELSE amount END) AS total_amount FROM khata")->fetch_assoc();
                    $totalAmount = $result['total_amount'];
                    
                    echo "$totalAmount";
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-primary elevation-1"><i class="fas fa-arrow-up"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Total Earning</span>
            <span class="info-box-number text-right">
                <?php 
                    $totalCredit = $conn->query("SELECT SUM(amount) AS total_credit FROM khata WHERE is_credit = 1")->fetch_assoc()['total_credit'];

                    echo "$totalCredit";
                    
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <div class="col-12 col-sm-12 col-md-6 col-lg-3">
        <div class="info-box bg-gradient-light shadow">
            <span class="info-box-icon bg-gradient-info elevation-1"><i class="fas fa-arrow-down"></i></span>

            <div class="info-box-content">
            <span class="info-box-text">Total Expense</span>
            <span class="info-box-number text-right">
                <?php 
                    $totalCredit = $conn->query("SELECT SUM(amount) AS total_credit FROM khata WHERE is_credit = 0")->fetch_assoc()['total_credit'];

                    echo "$totalCredit";
                    
                ?>
            </span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
</div>
<hr class="border-border bg-warning">
<!-- last 6 transiction details -->
<div class="row">
    <div class="col-md-12">
        <table class="table bg-warning">
            <thead>
                <tr>
                    <th>SL</th>
                    <th>Stakeholder</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Issue</th>
                    <th>Types</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT khata.*, users.username, source.title AS issue_title
                          FROM khata
                          LEFT JOIN users ON khata.u_id = users.id
                          LEFT JOIN source ON khata.Issue = source.Id
                          ORDER BY khata.Id DESC LIMIT 5";

                $result = $conn->query($query);

                $serial = 1;
                while ($row = $result->fetch_assoc()) {
                    $creditDebit = $row['is_credit'] == 1 ? 'Credit' : 'Debit';
                    $rowClass = $serial % 2 == 0 ? 'table-info' : 'table-primary';
                    echo "<tr class=\"$rowClass\">";
                    echo "<td>{$serial}</td>";
                    echo "<td>{$row['username']}</td>";
                    echo "<td>{$row['description']}</td>";
                    echo "<td>{$row['amount']}</td>";
                    echo "<td>{$row['issue_title']}</td>";
                    echo "<td>{$creditDebit}</td>";
                    echo "</tr>";
                    $serial++;
                }
                ?>
            </tbody>
        </table>
        <!-- <button class="btn btn-info btn-lg btn-block" href="https://example.com/demo">See All Report</button> -->
    </div>
</div>


