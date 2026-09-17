    <?php

    // default search order and help text
    $order = " ORDER BY d.Model ASC";
    $help_text = "";

    // retrieve user input ...  
    $BrandID = $_REQUEST['brand'];
    $AspirationID = $_REQUEST['Aspiration'];
    $DrivetrainID = $_REQUEST['drivetrain'];


    // if the item is blank, replace it with a %% wildcard.
    $all_input = [$BrandID, $AspirationID, $DrivetrainID];

    foreach ($all_input as $index => $value) {
        if ($value === "") {
            $all_input[$index] = "%%";
        }
    }

    list($BrandID, $AspirationID, $DrivetrainID) = $all_input;


    // Set up heading before making it into a wildcard...
    $heading="Filter Results...";

    // All Japanese car entries
    $all_characters = "%%";
   
    $sql_condition = "
    WHERE d.BrandID  LIKE ?
    AND d.AspirationID LIKE ?
    AND d.DrivetrainID LIKE ?

    "; 

    $params = [$BrandID, $AspirationID, $DrivetrainID];

    // Example parameters for filtering Japanese car entries

    $help_text = "Results show characters which match ALL the filters you chose.  If there are no results, try fewer parameters.";


    // Add order
    $sql_condition .= $order;


    include("results.php");

    ?>