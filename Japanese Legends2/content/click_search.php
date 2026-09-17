<?php

// retrieve search type and term
$search_type = to_clean($_REQUEST['search_type']);
$search_term = to_clean($_REQUEST['search_term']);

$heading = $search_term;
$help_text = "";
$order = " ORDER BY d.Model ASC";

// Dictionary containing searches and columns
$search_columns = [
    "brand"       => "Brand",
    "model"       => "Model",
    "drivetrain"  => "drivetrain",
    "Aspiration"  => "Aspiration"
];

// Parameters for searches
$params = [$search_term];

// Look up column based on search type
if (array_key_exists($search_type, $search_columns)) {

    $column = $search_columns[$search_type];

    $sql_condition = "WHERE `$column` LIKE ?";

}

// Search for specifications
else if ($search_type == "specs") {

    $sql_condition = "
        WHERE Aspiration LIKE ?
        OR drivetrain LIKE ?
    ";

    $params = array_fill(0, 2, $search_term);

}

else {

    $sql_condition = "
        WHERE Model LIKE ?
        OR Brand LIKE ?
        OR Aspiration LIKE ?
        OR drivetrain LIKE ?
    ";

    $params = array_fill(0, 4, $search_term);

}

// Add order
$sql_condition .= $order;

include("results.php");

?>