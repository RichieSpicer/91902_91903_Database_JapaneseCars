<?php

// Search term / Text setup
// This is mostly to make searching / clickable links easy
$ID = $find_rs['ID'];

$model = $find_rs['Model'];
$brand = $find_rs['Brand'];
$aspiration = $find_rs['Aspiration'];
$drivetrain = $find_rs['drivetrain'];

$featured = $find_rs['Images'];

// Image and icon set up
$model_icon = "images/Models/".$find_rs['Images'];
$brand_icon = "images/Icon/".$find_rs['Brand_Images'];

// URL Helpers
$click_type = "index.php?page=content/click_search&search_type=";
$click_term = "&search_term=";

?>