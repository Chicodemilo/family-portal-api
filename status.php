<?php
session_start();

if ($_SESSION['valid'] != true) {
    echo 'dude';
    header('Refresh: 2; URL = index.php');
}

include 'statusUtilities.php';

$id = $_SESSION['id'];

$statusUtilities = new StatusUtilities($id);
$name = $statusUtilities->getCurrentName();
$status = $statusUtilities->getCurrentStatus();
$options = $statusUtilities->getStatusOptions();

if (isset($_POST['submit'])) {
    $statusUtilities->submitAll($_POST);
    $name = $_POST['name'];
    if ($_POST['optionStatus'] != '') {
        $status = $_POST['optionStatus'];
    } else {
        $status = $_POST['status'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="local.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <title>⚡️ FAMBO ⚡️</title>
</head>

<body>
    <div class="row">
        <div class="col">&nbsp;</div>
        <div class="col-6">
            <div class="card">
                <div class="card-header bigHead">🚀🐕🏀🏊‍♀️🍕🛠🍦🐶⛹🏼‍♀️🥑🤘🏻🎹🌳🌸🎺🏋🏼‍♀️🦐💜</br>
                    HELLO <?php echo $name; ?>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <input type="hidden" class="form-control" placeholder="enter" name="id" value="<?php echo addslashes($id);
?>">
                            display name:
                            <input type="text" class="form-control" placeholder="name" name="name" id="name"
                                value="<?php echo addslashes($name); ?>" maxlength="10">
                            <br>
                            status:
                            <input type=" text" class="form-control" placeholder="status" name="status"
                                value="<?php echo addslashes($status); ?>" autofocus maxlength="50">
                            <br>
                            <select class="form-control" id="optionStatus" name="optionStatus">

                                <option value=''>--</option>
                                <?php
foreach ($options as $option) {
    echo "<option value='$option'>$option</option> ";
}
?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit">Submit</button>
                    </form>
                    <hr>
                    <a href="logout.php">logout</a>
                </div>
                <div class="card-footer bigHead">🚀🐕🏀🏊‍♀️🍕🛠🍦🐶⛹🏼‍♀️🥑🤘🏻🎹🌳🌸🎺🏋🏼‍♀️🦐💜</div>
            </div>
        </div>
        <div class="col">&nbsp;</div>
    </div>
</body>
<script>
</script>

</html>