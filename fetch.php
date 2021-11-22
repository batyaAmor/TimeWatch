<?php
require_once "config.php";
if (isset($_POST["limit"], $_POST["start"])) {//lazy loading
    $query = "SELECT tikets.*,name FROM tikets join customers where customer_id=id ORDER BY ticket_id LIMIT " . $_POST["start"] . ", " . $_POST["limit"] . "";
}
if (isset($_POST["str"])) {//autocomplete
    $query = "SELECT tikets.*,name FROM tikets join customers where customer_id=id AND
                (ticket_id LIKE '%" . $_POST["str"] . "%' or date LIKE '%" . $_POST["str"] . "%'
                or content LIKE '%" . $_POST["str"] . "%' or customer_id LIKE '%" . $_POST["str"] . "%')";
}
$result = mysqli_query($link, $query);
while ($row = mysqli_fetch_array($result)) {
    echo "<tr class='table table-bordered table-striped'>";
    echo "<td>" . $row['ticket_id'] . "</td>";
    echo "<td>" . $row['content'] . "</td>";
    echo "<td>" . $row['date'] . "</td>";
    echo '<td><a href="readC.php?id=' . $row['customer_id'] . '">' . $row['name'] . '</a></td>';
    echo "</tr>";
}
?>