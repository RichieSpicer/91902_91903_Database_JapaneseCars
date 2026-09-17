<?php // retrieve data

    list($find_query, $find_count) = get_query($dbconnect, $sql_condition, $params);

    // set up heading for single / multiple results
    if($find_count == 1) {
        $results_heading = $heading;
    }

    else {
        $results_heading = $heading." (".$find_count." results)";
    }

    if($find_count > 0)

    {

        if($heading != "") {
    ?>

        <h2 class="search-heading">
            <?= htmlspecialchars($results_heading); ?>
        </h2>

    <?php

        }

        // display help text if it exists...
        if($help_text!="")
        {
            ?>
            <i class="results-heading"><i class="fa-solid fa-circle-info"></i> <?= $help_text; ?></i><br><br>
            <?php
        }

        else {
            echo "<br>";
        }

    ?>

<div class="cards-outer">
    
<div class='all-cards'>


<?php

while($find_rs = mysqli_fetch_assoc($find_query)) {

    // Search term / Text setup
    $ID = $find_rs['ID'];
    $brand = $find_rs['Brand'];
    $model = $find_rs['Model'];
    $aspiration = $find_rs['Aspiration'];
    $drivetrain = $find_rs['drivetrain'];

    // Image and icon set up
    $model_icon = "images/Models/".$find_rs['Images'];
    $brand_icon = "images/Icon/".$find_rs['Brand_Images'];
    
    // URL Helpers
    $click_type = "index.php?page=content/click_search&search_type=";
    $click_term = "&search_term=";

?>


<div class="car-details">

    <div class="brand-name"><?= htmlspecialchars($brand); ?></div>

    <div class="model-title">

        <a title="">
            <img src="<?= htmlspecialchars($model_icon); ?>" 
                 alt="<?= htmlspecialchars($model); ?>" 
                 class="model-image">
        </a>

        <a class="model" 
        href="index.php?page=content/click_search&search_type=model&search_term=<?= urlencode($model); ?>">
        <?= htmlspecialchars($model); ?></a>

    </div>


    <?php

    // list to hold icons
    $all_icons = [

        [$brand, $click_type."brand".$click_term.urlencode($brand), $brand_icon],
    ];

    ?>

    <div class="icon-row">

    <?php foreach($all_icons as $item): ?>

            <a title="<?= htmlspecialchars($item[0]); ?>" href="<?= $item[1]; ?>">
                <img src="<?= htmlspecialchars($item[2]); ?>" alt="<?= htmlspecialchars($item[0]); ?>">
            </a>  
            
    <?php endforeach; ?>
    
    </div> <!-- / icon row -->


    <div class="description">
        <?= htmlspecialchars($find_rs['Description']); ?>
    </div>


    <div class="spec-tags">

    <?php
    
    $all_specs = [$aspiration, $drivetrain];
    
    foreach ($all_specs as $specs) {

        if($specs != "n/a") {

            ?>
            
            <a href="<?= $click_type?>specs<?= $click_term.urlencode($specs); ?>" class="specs">
                <?= htmlspecialchars($specs); ?>
            </a>

            <?php

        }

    }

    ?>

    </div>  <!-- / spec tags -->


    <?php

    // if user is logged in, show edit / delete options
    if (isset($_SESSION['admin'])) {

        ?>

        <div class="tools">

            <!-- Edit button -->
            <a class="nav-button" 
               href="index.php?page=admin/edit&ID=<?= $ID; ?>"
               title="Edit">
                <i class="fa-solid fa-pen-nib"></i>
            </a>

            &nbsp; &nbsp;

            <!-- Delete button -->
            <a class="nav-button" 
                href="index.php?page=admin/delete_confirm&ID=<?= $ID; ?>"
                title="Delete">
                <i class="fa-solid fa-trash"></i>
            </a>
            </a>

        </div>

        <?php

    }

    ?>


</div>  <!-- / car details -->


<?php

}   // end results while

?>


</div>  <!-- / all-cards -->

</div>  <!-- / cards outer -->


<?php

    }

// if there are no results...
else {

    ?>

   <h2>No Results</h2>

   <div class="no-results-message">

    <div class='center-image'>
    <img class='error-image' src="images/no_results.png" alt="No results image">
    </div>

    <p>&nbsp;</p>

    <div class="error all">

   <p>
        Sorry! There are no results for your search.
    </p>

    <p>
        Please try another search term / use fewer characters in the search box.
    </p>

    </div>

</div>

    <?php

}

?>

<p>&nbsp;</p>