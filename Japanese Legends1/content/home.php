<?php 
// Retrieve featured items...
// Wild card 'search term' to return all results so that we can choose five random results and still use a prepared statement
$search_term = "%%";
$params = [$search_term];


// Set up query
$sql_condition = "WHERE `Images` LIKE ? AND `Images` !='' ORDER BY `Model` ASC";    
list($find_query, $find_count) = get_query($dbconnect, $sql_condition, $params);

    
?>
    
<h2>Welcome</h2>

<p>Use the random / filter / search tools above to explore the Japanese cars. Here are some featured cars to get you started.
</p>

<p>
    Please hover over the images below to learn more about each car.
</p>

<p>&nbsp;</p>


<div class='all-cards'>


<?php

while($find_rs = mysqli_fetch_assoc($find_query)) {

    $model_icon = "images/Models/".$find_rs['Images'];
    $brand_icon = "images/Icon/".$find_rs['Brand_Images'];

    // Search term / Text setup
    $ID = $find_rs['ID'];
    
    $brand = $find_rs['Brand'];
    $model = $find_rs['Model'];
    $Aspiration = $find_rs['Aspiration'];
    $drivetrain = $find_rs['drivetrain'];

    // URL helpers
    $click_type = "index.php?page=content/click_search&search_type=";
    $click_term = "&search_term=";

?>


<div class="container">
    

    <img src="<?= $brand_icon; ?>" alt="<?= $brand; ?>" class="brand"> 


    <div class="overlay">

    
<div class="car-details">

    <div class="brand-name"><?= $brand; ?></div>

            <div class="model-title">
        <a title="">
<img src="<?= $model_icon; ?>" alt="<?= $model; ?>" class="model-image">
        </a>

        <a class="model" 
        href="index.php?page=content/click_search&search_type=model&search_term=<?= urlencode($model); ?>">
        <?= $model; ?></a>
    </div>

    <?php

    // list to hold icons to easily generate 'icon row'
    // Title (and alt) | URL | icon     

    $all_icons = [

        [$brand, $click_type."brand".$click_term.urlencode($brand), $brand_icon],

    ];

    ?>

    <div class="icon-row">

    <?php foreach($all_icons as $item): ?>
            <a title="<?= $item[0]; ?>" href="<?= $item[1]; ?>"><img src="<?= $item[2]; ?>" alt="<?= $item[0]; ?>" ></a>  
            
    <?php endforeach; ?>
    
    </div> <!-- / icon row -->

    <div class="description">
    <?= $find_rs['Description']; ?>
    </div>


    <div class="spec-tags">

    <?php
    
    $all_specs = [$drivetrain, $Aspiration];
    
    // iterate through list of specs and output them (if they are not n/a)
    foreach ($all_specs as $specs) {
        if($specs != "n/a") {

            ?>
            
            <a href="<?= $click_type?>specs<?= $click_term.urlencode($specs); ?>" class="specs"><?= $specs; ?></a>

            <?php

        }

    }

    ?>

    </div> 

    <?php

    // if user is logged in, show edit / delete options
    if (isset($_SESSION['admin'])) {

        ?>

        <div class="tools">

            <a class="nav-button" href="index.php?page=admin/edit&ID=<?= $ID; ?>">
                <i class="fa-solid fa-pen-nib"></i>
            </a> &nbsp; &nbsp;

            <?php

        


            

            ?>

        </div>

        <?php

    }

    ?>


</div>  <!-- / character details -->

</div>  <!-- / overlay -->

</div>  <!-- / container -->

<?php 

} // end results while

?>


</div>  <!-- / all-cards -->