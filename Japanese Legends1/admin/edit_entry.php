<?php

// check user is logged in
if(isset($_SESSION['admin'])) {

    // check button has been pressed
    if(isset($_REQUEST['submit']))
    {

        $ID = $_REQUEST['ID'];

        $model = $_REQUEST['model'];
        $brand = $_REQUEST['brand'];
        $aspiration = $_REQUEST['aspiration'];
        $drivetrain = $_REQUEST['drivetrain'];
        $description = $_REQUEST['description'];


        // Edit DB Entry
        $stmt_edit = $dbconnect->prepare("
            UPDATE `data`
            SET
                `Model` = ?,
                `AspirationID` = ?,
                `DrivetrainID` = ?,
                `BrandID` = ?,
                `Description` = ?
            WHERE `ID` = ?
        ");

        $stmt_edit->bind_param(
            "siiisi",
            $model,
            $aspiration,
            $drivetrain,
            $brand,
            $description,
            $ID
        );

        $stmt_edit->execute();
        $stmt_edit->close();


        // retrieve the entry we have just edited
        $heading = "Edit Car Success";
        $help_text = "";
        $params = [$ID];
        $sql_condition = "WHERE d.ID = ?";

        include("content/results.php");

    }

}

else {

    // error if user is not logged in
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=admin/login&error=$login_error");

}

?>