<?php

// check user is logged in
if(isset($_SESSION['admin'])) {

    // get ID for entry to be edited
    $ID = $_REQUEST['ID'];

    // retrieve entry details
    $get_entry_sql = "WHERE d.ID = ?";
    $params = [$ID];

    $get_entry_query = get_query($dbconnect, $get_entry_sql, $params)[0];
    $get_entry_rs = mysqli_fetch_assoc($get_entry_query);

    if($get_entry_rs) {

        $model = $get_entry_rs['Model'];
        $description = $get_entry_rs['Description'];
        $images = $get_entry_rs['Images'];

        $brandID = $get_entry_rs['BrandID'];
        $brand = $get_entry_rs['Brand'];

        $aspirationID = $get_entry_rs['AspirationID'];
        $aspiration = $get_entry_rs['Aspiration'];

        $drivetrainID = $get_entry_rs['DrivetrainID'];
        $drivetrain = $get_entry_rs['drivetrain'];

?>
<div class="big-form">
    <h2>Edit Entry</h2>

    <form action="index.php?page=admin/edit_entry&ID=<?= $ID; ?>" method="post">

        <p>
            <input name="model" value="<?= htmlspecialchars($model); ?>" required>
        </p>

        <p>
            <select name="brand" required>
                <option value="<?= $brandID; ?>" selected>
                    <?= htmlspecialchars($brand); ?>
                </option>
                <?php
                get_options(
                    $dbconnect,
                    'brand',
                    'BrandID',
                    'Brand'
                );
                ?>
            </select>
        </p>

        <p>
            <select name="aspiration" required>
                <option value="<?= $aspirationID; ?>" selected>
                    <?= htmlspecialchars($aspiration); ?>
                </option>
                <?php
                get_options(
                    $dbconnect,
                    'Aspiration',
                    'AspirationID',
                    'Aspiration'
                );
                ?>
            </select>
        </p>

<p>
    <select name="drivetrain" required>
        <?php
        get_options(
            $dbconnect,
            'drivetrain',
            'drivetrainID',
            'drivetrain',
            $drivetrainID
        );
        ?>
    </select>
</p>

        <p>
            <textarea name="description" required><?= htmlspecialchars($description); ?></textarea>
        </p>

        <button class="form-submit pad-10" type="submit" name="submit">
            Submit
        </button>

    </form>
</div>

<?php
    } else {
        echo "<p>No results found for this car.</p>";
    }

} else {
    $login_error = 'Please login to access this page';
    header("Location: index.php?page=admin/login&error=$login_error");
}
?>