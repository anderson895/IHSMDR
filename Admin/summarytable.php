<?php include 'includes/header.php'; ?>
<?php include 'includes/topbar.php'; ?>
<?php include 'includes/sidebar.php'; ?>

<div class="page-wrapper">
    <div class="content">
        <div class="page-header p-4" style="background: linear-gradient(to bottom, rgba(214, 215, 219, 0.29), rgba(221, 221, 221, 0.5)); background-image: url('assets/img/Header - Top Background Image (1600x200).jpg'); background-position: center center; background-repeat: no-repeat;">
            <div class="page-title">
                <h4>FHSIS</h4>
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
                
                   
                </div>
                <div class="table-responsive">
                <?php 
// First Query: Age Category Data
$sql_age_category = "
SELECT 
    mm.name AS maternal_name,
    COALESCE(CASE 
        WHEN p.age BETWEEN 10 AND 14 THEN '10-14'
        WHEN p.age BETWEEN 15 AND 19 THEN '15-19'
        WHEN p.age BETWEEN 20 AND 49 THEN '20-49'
    END, 'No Data') AS age_category,
    b.name AS barangay,
    COUNT(p.id) AS count
FROM 
    barangay AS b
INNER JOIN 
    patients AS p ON p.address = b.name
INNER JOIN 
    detail_patient_maternal AS dpm ON dpm.patient_id = p.id
INNER JOIN 
    master_maternal AS mm ON mm.id = dpm.maternal_id
GROUP BY 
    mm.name, age_category, b.name
ORDER BY 
    mm.name, age_category, b.name
";

// Second Query: Sex Category Data
$sql_sex_category = "
SELECT
    mm.name AS maternal_name,
    CASE
        WHEN p.sex = 'Male' THEN 'M'
        WHEN p.sex = 'Female' THEN 'F'
        ELSE 'No Data'
    END AS sex_category,
    b.name AS barangay,
    COUNT(p.id) AS count
FROM
    barangay AS b
INNER JOIN patients AS p ON p.address = b.name
INNER JOIN detail_patient_maternal AS dpm ON dpm.patient_id = p.id
INNER JOIN master_maternal AS mm ON mm.id = dpm.maternal_id
GROUP BY
    mm.name,
    p.sex,
    b.name
ORDER BY
    mm.name,
    sex_category,
    b.name
";

// Execute the queries
$result_age_category = $conn->query($sql_age_category);
$result_sex_category = $conn->query($sql_sex_category);

// Process and display Age Category data
if ($result_age_category->num_rows > 0) {
    $data_age_category = [];
    $barangays = [];

    while ($row = $result_age_category->fetch_assoc()) {
        $maternalName = $row["maternal_name"];
        $ageCategory = $row["age_category"];
        $barangay = $row["barangay"];
        $count = $row["count"];

        $data_age_category[$maternalName][$ageCategory][$barangay] = $count;
        if (!in_array($barangay, $barangays)) {
            $barangays[] = $barangay;
        }
    }

    // Sort barangays alphabetically
    sort($barangays);

    // Generate Table for Age Categories
    echo "<h3>Age Category Data</h3>";
    echo "<table class='table table-striped table-bordered' id='datatable_age'>";
    echo "<thead>
            <tr>
                <th rowspan='2'>No.</th>
                <th rowspan='2'>Maternal Indicator</th>
                <th rowspan='2'>Age Group</th>";
    foreach ($barangays as $barangay) {
        echo "<th colspan='1'>" . htmlspecialchars($barangay) . "</th>";
    }
    echo "<th rowspan='2'>Total</th></tr><tr></tr></thead><tbody>";

    $no = 1;
    foreach ($data_age_category as $maternalName => $ageGroups) {
        foreach (['10-14', '15-19', '20-49'] as $ageCategory) {
            echo "<tr>";
            if ($ageCategory === '10-14') {
                echo "<td rowspan='3'>$no</td>
                      <td rowspan='3'>" . htmlspecialchars($maternalName) . "</td>";
                $no++;
            }
            echo "<td>" . htmlspecialchars($ageCategory) . "</td>";

            $rowTotal = 0;
            foreach ($barangays as $barangay) {
                $count = $ageGroups[$ageCategory][$barangay] ?? 0;
                echo "<td>" . $count . "</td>";
                $rowTotal += $count;
            }

            echo "<td>" . $rowTotal . "</td></tr>";
        }
    }

    echo "</tbody></table>";
} else {
    echo "No Age Category data found.<br>";
}

// Process and display Sex Category data
if ($result_sex_category->num_rows > 0) {
    $data_sex_category = [];

    while ($row = $result_sex_category->fetch_assoc()) {
        $maternalName = $row["maternal_name"];
        $sexCategory = $row["sex_category"];
        $barangay = $row["barangay"];
        $count = $row["count"];

        $data_sex_category[$maternalName][$sexCategory][$barangay] = $count;
    }

    // Sort barangays alphabetically
    sort($barangays);

    // Generate Table for Sex Categories
    echo "<h3>Sex Category Data</h3>";
    echo "<table class='table table-striped table-bordered' id='datatable_sex'>";
    echo "<thead>
            <tr>
                <th rowspan='2'>No.</th>
                <th rowspan='2'>Maternal Indicator</th>
                <th rowspan='2'>Sex Category</th>";
    foreach ($barangays as $barangay) {
        echo "<th colspan='1'>" . htmlspecialchars($barangay) . "</th>";
    }
    echo "<th rowspan='2'>Total</th></tr><tr></tr></thead><tbody>";

    $no = 1;
    foreach ($data_sex_category as $maternalName => $sexCategories) {
        foreach (['M', 'F'] as $sexCategory) {
            echo "<tr>";
            if ($sexCategory === 'M') {
                echo "<td rowspan='2'>$no</td>
                      <td rowspan='2'>" . htmlspecialchars($maternalName) . "</td>";
                $no++;
            }
            echo "<td>" . htmlspecialchars($sexCategory) . "</td>";

            $rowTotal = 0;
            foreach ($barangays as $barangay) {
                $count = $sexCategories[$sexCategory][$barangay] ?? 0;
                echo "<td>" . $count . "</td>";
                $rowTotal += $count;
            }

            echo "<td>" . $rowTotal . "</td></tr>";
        }
    }

    echo "</tbody></table>";
} else {
    echo "No Sex Category data found.";
}
?>

                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'modal/patients/modal.php'; ?>
<?php include 'includes/footer.php'; ?>



<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

<script>
    document.getElementById('exportButton').addEventListener('click', function() {
        // Send an AJAX request to summarytableexport.php to fetch the table data
        $.ajax({
            url: 'summarytableexport.php',
            type: 'POST',
            success: function(response) {
                console.log(response); // Check what the response contains
                var workbook = XLSX.utils.book_new();
                
                var table = document.createElement('table');
                table.innerHTML = response;
                
                var sheet = XLSX.utils.table_to_sheet(table);
                XLSX.utils.book_append_sheet(workbook, sheet, 'Summary Report');
                
                XLSX.writeFile(workbook, 'Summary_Report.xlsx');
            },
            error: function() {
                alert('Error fetching data for export');
            }
        });
    });
</script>
