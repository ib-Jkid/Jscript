<?php ob_start();
require("../session.php");
require("../functions.php");
$connection = connect_DB();
if (cleared(4)) {

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "delete from comments where id = {$id}";
    $result = get_result($query);
    echo $id;
}
?>


<?php
mysqli_close($connection);
} else {echo "ADIM PERMISSION REQUIRED";}
?>