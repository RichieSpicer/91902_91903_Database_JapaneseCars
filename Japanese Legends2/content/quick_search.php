    <?php

    // default search order and help text
    $order = " ORDER BY d.Model ASC";
    $help_text = "";


    // retrieve search type and search term...

    $search_type_array = [
            'quick_search'  => 'Quick',
            'brand_search' => 'Brand',
            'model_search' => 'Model',
            'drivetrain_search' => 'drivetrain',
            'aspiration_search' => 'Aspiration'
    ];


    // Loop through the array to detect which submit button was pressed
    foreach ($search_type_array as $submit_name => $type_value) {
        if (isset($_POST[$submit_name])) {
            $search_type = $type_value;
            break;
        }
    }
    
    $search_term = $_REQUEST['quick_search_term'];



    // Set up heading before making it into a wildcard...
    $heading=$search_term;

    // make search term into a wildcard so we can use it with our prepared statement
    $search_term = '%'.$search_term.'%';

    // Dictionary containing 'single' searches and columns
    $search_columns = [
    "Brand"      => "Brand",
    "Model"     => "Model",
    "Aspiration"  => "Aspiration",
    "drivetrain"  => "drivetrain"
    ];

// Query for Japanese car data (single column)
if (array_key_exists($search_type, $search_columns)) {
    $column = $search_columns[$search_type];
    $sql_condition = "WHERE `$column` LIKE ?";
    $params = [$search_term];

}

elseif ($search_type == "Quick")
{
    $sql_condition = "
        WHERE `Model` LIKE ?
        OR `Brand` LIKE ?
        OR `Aspiration` LIKE ?
        OR `drivetrain` LIKE ?
    ";

    $params = array_fill(0, 4, $search_term);

    $help_text = "Results are based on brand, aspiration and drivetrain.";
}

  
    // Add order
    $sql_condition .= $order;


    include("results.php");

    ?>