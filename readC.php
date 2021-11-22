<?php
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    require_once "config.php";
    $sql = "SELECT * FROM customers WHERE id = ?";
    if ($stmt = mysqli_prepare($link, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        $param_id = trim($_GET["id"]);
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                $name = $row["name"];
                $address = $row["address"];
                $mail = $row["mail"];
                $phone = $row["phone"];
            } else {
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        $sql2 = "select * from tikets where customer_id=" . $_GET["id"];
        $result2 = mysqli_query($link, $sql2);
    }
    mysqli_close($link);
} else {
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mt-5 mb-3">View Record</h1>
                <div class="form-group">
                    <label>Name</label>
                    <p><b><?php echo $row["name"]; ?></b></p>
                </div>
                <div class="form-group">
                    <label>Address</label>
                    <p><b><?php echo $row["address"]; ?></b></p>
                </div>
                <div class="form-group">
                    <label>Mail</label>
                    <p><b><?php echo $row["mail"]; ?></b></p>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <p><b><?php echo $row["phone"]; ?></b></p>
                </div>
                <div>
                    ticket list:
                    <?php
                    if ($result2) {
                        if (mysqli_num_rows($result2) > 0) {
                            echo '<table class="table table-bordered table-striped">';
                            echo "<thead>";
                            echo "<tr>";
                            echo "<th>#</th>";
                            echo "<th>Content</th>";
                            echo "<th>Date</th>";
                            echo "</tr>";
                            echo "</thead>";
                            echo "<tbody>";
                            while ($row = mysqli_fetch_array($result2)) {
                                echo "<tr class='table table-bordered table-striped'>";
                                echo "<td>" . $row['ticket_id'] . "</td>";
                                echo "<td>" . $row['content'] . "</td>";
                                echo "<td>" . $row['date'] . "</td>";
                                echo "</td>";
                                echo "</tr>";
                            }
                            echo "</tbody>";
                            echo "</table>";
                            mysqli_free_result($result2);
                        } else {
                            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                        }
                    } else {
                        echo "Oops! Something went wrong. Please try again later.";
                    }
                    ?>
                </div>
            </div>
            <p><a href="tickets.php" class="btn btn-primary">Tickets list</a></p>
            <p><a href="indexC.php" class="btn btn-primary">Customers list</a></p>
        </div>
    </div>
</div>
</body>
</html>