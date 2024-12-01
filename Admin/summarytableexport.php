<?php

include '../includes/config.php';
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

// Check if queries returned results
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
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
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
    echo "<table border='1' cellpadding='5' cellspacing='0'>";
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
