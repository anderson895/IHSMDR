<?php

include '../includes/config.php';

if (isset($_POST['category_id'])) {
    $categoryId = intval($_POST['category_id']); // Ensure category ID is treated as an integer

    // Your query to fetch data based on the selected category
    $sql = "SELECT 
                mm.name AS `Maternal Metric`,
                SUM(CASE WHEN p.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) AS `10 - 14`,
                SUM(CASE WHEN p.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) AS `15 - 19`,
                SUM(CASE WHEN p.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS `20 - 49`,
                SUM(CASE WHEN p.age BETWEEN 10 AND 14 THEN 1 ELSE 0 END) +
                SUM(CASE WHEN p.age BETWEEN 15 AND 19 THEN 1 ELSE 0 END) +
                SUM(CASE WHEN p.age BETWEEN 20 AND 49 THEN 1 ELSE 0 END) AS `Total`
            FROM 
                master_maternal AS mm
            LEFT JOIN 
                detail_patient_maternal AS dpm ON mm.id = dpm.maternal_id
            LEFT JOIN 
                patients AS p ON dpm.patient_id = p.id
            WHERE 
                mm.types = $categoryId -- Directly using the variable
            GROUP BY 
                mm.name
            ORDER BY 
                mm.id ASC";

    $result = mysqli_query($conn, $sql); // Execute the query

    // Check if there are results and display them
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['Maternal Metric']) . '</td>';
                echo '<td>' . htmlspecialchars($row['10 - 14']) . '</td>';
                echo '<td>' . htmlspecialchars($row['15 - 19']) . '</td>';
                echo '<td>' . htmlspecialchars($row['20 - 49']) . '</td>';
                echo '<td>' . htmlspecialchars($row['Total']) . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="5">No data found.</td></tr>';
        }
    } else {
        echo '<tr><td colspan="5">Error executing query: ' . mysqli_error($conn) . '</td></tr>'; // Display error message
    }
}
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>