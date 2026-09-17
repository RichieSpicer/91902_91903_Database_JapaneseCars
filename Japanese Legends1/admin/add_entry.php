<?php 
 
// check user is logged in 
if(isset($_SESSION['admin'])) { 
 
    // set up dropdown array... 
 
    // retrieval name | table | ID | Value | Placeholder
    $dropdown_details = [ 
        ['brand', 'brand', 'BrandID', 'Brand', 'Brand...'], 
       ['drivetrain', 'drivetrain', 'drivetrainID', 'drivetrain', 'Drivetrain...'],
        ['Aspiration', 'Aspiration', 'AspirationID', 'Aspiration', 'Aspiration...'], 
    ]; 
 
?> 
 
<div class="big-form"> 
 
    <h2>Add Entry</h2> 
 
    <form action="index.php?page=admin/insert_entry" method="post"> 
 
        <p>
            <input name="Model" placeholder="Car Model" required/>
        </p>

        <?php  
         
        // Loop to generate drop downs...
        foreach($dropdown_details as $drop) { 
            list($name, $table, $id_field, $label_field, $placeholder) = $drop; 
        ?> 
 
        <select class="marg-bottom" name="<?= $name ?>" required> 
            <option value="" disabled selected>
                <?= htmlspecialchars($placeholder); ?>
            </option> 
            
            <?php              
                get_options($dbconnect, $table, $id_field, $label_field); 
            ?> 
 
        </select> 
 
        <?php 
 
        } // end dropdown foreach 
 
        ?> 
 
        <p> 
            <textarea name="Description" placeholder="Description" required></textarea> 
        </p> 
  
        <p>
            <input class="large-submit" type="submit" name="submit" value="Submit" />
        </p> 
 
    </form> 
 
</div>  <!-- / big-form --> 
 
<script> 
    <?php include("autocomplete.php"); ?>   
</script> 
 
<?php 
 
} 
 
// not logged in else 
else { 
    $login_error = 'Please login to access this page'; 
    header("Location: index.php?page=admin/login&error=$login_error"); 
} 
 
?>