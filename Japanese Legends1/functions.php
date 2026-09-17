<?php

function get_query($dbconnect, $sql_condition, $params = [])
 {
   // d ==> data table
    // D ==> drivetrain table
    // b ==> brand table
	// m ==> aspiration table
	
  $find_sql = "
  SELECT d.*,
          r.*,
          b.*,
          a.*
          

  FROM data d 

  JOIN brand b ON b.BrandID = d.BrandID
  JOIN drivetrain r ON r.DrivetrainID = d.DrivetrainID
  JOIN Aspiration a ON a.AspirationID = d.AspirationID

  -- Adds additional sql condition
  $sql_condition

      ";

     // Prepared Statements
    $stmnt = $dbconnect -> prepare($find_sql);

    if(!empty($params)) {
          $types = str_repeat('s', count($params));  // all params treated as strings
          
          $bind_values = [];
          foreach ($params as $key => $value) {
            $bind_values[$key] = &$params[$key];
          }  // end bind fo each    
          
      array_unshift($bind_values, $types);
      call_user_func_array([$stmnt, 'bind_param'], $bind_values);

    } // end bind parameters if

    $stmnt -> execute();

    $find_query = $stmnt -> get_result();
    $find_count = $find_query -> num_rows;

    $stmnt -> close();

    return [$find_query, $find_count];

 }

 // trims white space from our search term
 function to_clean($data) {
	$data = trim($data);	
	return $data;
}

// generate drop down menu based on table
function get_options($dbconnect, $table, $idField, $valueField) {

    // retrieve options from database
    $dropdownSql = "SELECT * FROM `$table` ORDER BY `$table`.`$valueField` ASC ";
    $dropdownQuery = mysqli_query($dbconnect, $dropdownSql);

    // create options!
    while($dropdownRs = mysqli_fetch_assoc($dropdownQuery)) {

      ?>
        <option value="<?= $dropdownRs[$idField]; ?>">
          <?= htmlspecialchars($dropdownRs[$valueField]); ?>
        </option>
      <?php

    } // end dropdown while

}

// entity is trait (ie: thing that needs to be autocompleted)
function autocomplete_list($dbconnect, $item_sql, $entity)    
{
// Get entity / topic list from database
$all_items_query = mysqli_query($dbconnect, $item_sql);
    
// Make item arrays for autocomplete functionality...
while($row=mysqli_fetch_array($all_items_query))
{
  $item=$row[$entity];
  $items[] = $item;
}

$all_items=json_encode($items);
return $all_items;
    
}

?>