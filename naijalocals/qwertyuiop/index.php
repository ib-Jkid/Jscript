<?php ob_start();
require("../session.php");
require("../functions.php");
$connection = connect_DB();
if (cleared(1)) {
include_once("header.php");
?>

<?php
mysqli_close($connection);
include_once("footer.php");
} else {echo "ADIM PERMISSION REQUIRED";}
?>