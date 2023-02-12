<?php
ob_start();
$connection = mysqli_connect("localhost", "root", "", "todo");
if (!$connection) {
    echo "db connection failed";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo project</title>
    <!-- css link -->
    <link rel="stylesheet" href="./style.css">
    <!-- fontawesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

</head>

<body>
    <div class="container">
        <div class="todo-list">
            <div class="todo-input">
                <form action="./index.php" method="POST">
                    <input type="text" placeholder="Daily Activities" id="todoInput" name="todoBox">
                    <button name="add" type="submit">Add</button>
                </form>
                <?php


                if (isset($_GET["clicked_update_item"])) {
                    $clicked_update_item = $_GET["clicked_update_item"];

                    $read_activity_query2 = "SELECT * FROM daily_activities WHERE id=$clicked_update_item";
                    $read_activity_query_result2 = mysqli_query($connection, $read_activity_query2);
                    $row = mysqli_fetch_assoc($read_activity_query_result2);


                    echo "<form action='./index.php?clicked={$row['id']}' method='POST'>
                    <input type='text' value={$row['user_activity']} name='todoNewName'>
                    <button name='update' class='update-btn' type='submit'>Update</button>
                </form>";
                }


                ?>


            </div>
            <ul>
                <?php
                $read_activity_query = "SELECT * FROM daily_activities";
                $read_activity_query_result = mysqli_query($connection, $read_activity_query);
                // print_r($read_activity_query_result);
                while ($row = mysqli_fetch_assoc($read_activity_query_result)) {
                ?>
                    <div class="todo-collection">
                        <li><?php echo $row["user_activity"] ?></li>
                        <div class="crud-icons">
                            <button><a href='./index.php?clicked_update_item=<?php echo $row["id"] ?>'><i class="fa fa-pencil"></i></a></button>
                            <button><a href='./index.php?clicked_item=<?php echo $row["id"] ?>' }><i class="fa fa-trash"></i></a></button>
                        </div>

                    </div>


                <?php
                }
                ?>

            </ul>
        </div>
    </div>
</body>

<?php
if (isset($_POST['add'])) {
    // print_r($_POST);
    $activity = $_POST["todoBox"];

    //create an activity
    $insert_activity_query = "INSERT INTO daily_activities(user_activity) VALUES ('$activity')";
    $insert_activity_query_result = mysqli_query($connection, $insert_activity_query);
    if (!$insert_activity_query_result) {
        echo "insert_activity_query_result connection failed";
    } else {
        header("location:./index.php");
    }
}
?>


<?php

//delete an item
if (isset($_GET["clicked_item"])) {

    $clicked_id = $_GET["clicked_item"];
    $delete_activity_query = "DELETE FROM daily_activities WHERE id=$clicked_id";
    $delete_activity_query_result = mysqli_query($connection, $delete_activity_query);
    if (!$delete_activity_query_result) {
        echo "delete_activity_query_result failed";
    } else {
        header("location:./index.php");
    }
}

?>

<?php
//upadte an code


if (isset($_POST["update"])) {

    $id_take_from_get = $_GET['clicked'];
    $todoNewName = $_POST["todoNewName"];


    $update_query = "UPDATE daily_activities SET user_activity='$todoNewName'
WHERE id=$id_take_from_get";

    $update_query_result = mysqli_query($connection, $update_query);


    if (!$update_query_result) {
        echo "update_query_result failed";
    } else {
        header("location:./index.php");
    }
}
?>


</html>