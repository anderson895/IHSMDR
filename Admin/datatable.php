<?php include 'includes/header.php'; ?>
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header p-4" style="background: linear-gradient(to bottom, rgba(214, 215, 219, 0.29), rgba(221, 221, 221, 0.5)); background-image: url('assets/img/Header - Top Background Image (1600x200).jpg'); background-position: center center; background-repeat: no-repeat;">
            <div class="page-title">
                <h4>M1 FORM</h4>
                <h6>Reports</h6>
            </div>
            <div class="page-btn">
                <button class="btn btn-added" id="exportButton">
                    <img src="assets/img/icons/plus.svg" class="me-1" alt="img">Export
                </button>
            </div>
        </div> 

        <div class="card">
            <div class="card-body">
                <div class="table-top">
                    <label for="categoryFilter">Select Category:</label>
                    <select id="categoryFilter" class="form-select">
                        <option value="">-- Choose a category --</option>
                        <?php
                        // Fetch categories from the database
                        $sql = "SELECT id, name FROM master_category WHERE status = 1";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['id'] . '">' . htmlspecialchars($row['name']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-bordered" id="datatable">
                        <thead class="thead-dark">
                            <tr>
                                <th>Maternal Metric</th>
                                <th>10 - 14</th>
                                <th>15 - 19</th>
                                <th>20 - 49</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody id="dataBody">
                            <!-- Filtered results will be displayed here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'modal/patients/modal.php'; ?>
<?php include 'includes/footer.php'; ?>

<script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.0/xlsx.full.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    document.getElementById('exportButton').addEventListener('click', function() {
        var table = document.getElementById('datatable');
        var workbook = XLSX.utils.table_to_book(table, { sheet: "Sheet1" });
        XLSX.writeFile(workbook, 'Datatable.xlsx');
    });
</script>

<script>
    $(document).ready(function () {
        $('#categoryFilter').change(function () {
            var categoryId = $(this).val();
            if (categoryId) {
                $.ajax({
                    url: 'fetch_data.php', // PHP file to fetch data
                    type: 'POST',
                    data: { category_id: categoryId },
                    success: function (data) {
                        $('#dataBody').html(data);
                    }
                });
            } else {
                $('#dataBody').html(''); // Clear results if no category is selected
            }
        });
    });
</script>
</script>
