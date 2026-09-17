<?php  

// Check user is logged in 
if(isset($_SESSION['admin'])) {  

    // Check button has been pressed 
    if(isset($_REQUEST['submit']))  
    {  
        // Retrieve data from form 
        $model = $_REQUEST['Model']; 
        $brand = $_REQUEST['brand'];  
        $drivetrain = $_REQUEST['drivetrain'];  
        $aspiration = $_REQUEST['Aspiration'];  
        $description = $_REQUEST['Description'];  


        // Check for duplicates 
        $params = [$model, $brand];  
        $sql_condition = "WHERE d.Model LIKE ? AND d.BrandID LIKE ?"; 
        $exists = get_query($dbconnect, $sql_condition, $params);  
  
        // $exists[1] is how many results we got from our query 
        $exists_count = $exists[1];  
  
        if ($exists_count > 0) {  
            $heading = "Oops!";  
            $help_text = "We already have an entry for ".$model.". Here it is...";  
        }  
  
        else {  
 
            // Add entry to database 
            $stmt_add = $dbconnect -> prepare( 
                "INSERT INTO `data`  
                (`Model`, `BrandID`, `AspirationID`, `DrivetrainID`, `Description`)  
                VALUES (?, ?, ?, ?, ?);" 
            );  
  
            $stmt_add -> bind_param( 
                "siiis",  
                $model,  
                $brand,  
                $aspiration,  
                $drivetrain,
                $description 
            );  
  
            $stmt_add -> execute();  
            $characterID = $dbconnect -> insert_id;  
            $stmt_add -> close();  
  
            // Generate success screen 
            $heading = "Add Car Success";  
            $help_text = "";  
            $params = [$characterID];  
            $sql_condition = "WHERE ID = ?";  
 
        }  
 
        // Display results 
        include("content/results.php");  
 
    }  
 
}  
 
else {  
 
    // Error if user is not logged in 
    $login_error = 'Please login to access this page';  
    header("Location: index.php?page=admin/login&error=$login_error");  
 
}  
 
?>