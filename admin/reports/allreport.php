<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h3>All Transactions</h3>
            <div class="mb-3">
                <input type="text" id="filterSL" placeholder="Filter by SL">
                <input type="text" id="filterStakeholder" placeholder="Search">
                <!-- Add input fields for other columns here -->
            </div>
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
                        ORDER BY khata.Id DESC";
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
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and jQuery -->
<!-- from header -->

<script>
function applyFilters() {
    const filterSL = document.getElementById('filterSL').value.toLowerCase();
    const filterStakeholder = document.getElementById('filterStakeholder').value.toLowerCase();
    // Get other filter input values here

    const rows = document.querySelectorAll('tbody tr');
    
    rows.forEach(row => {
        const rowData = row.textContent.toLowerCase();
        const matchesFilterSL = rowData.includes(filterSL);
        const matchesFilterStakeholder = rowData.includes(filterStakeholder);
        // Check other filters here

        if (matchesFilterSL && matchesFilterStakeholder) {
            row.style.display = ''; // Show row
        } else {
            row.style.display = 'none'; // Hide row
        }
    });
}

document.addEventListener('input', applyFilters);
</script>