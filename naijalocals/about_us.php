<?php ob_start();
/*******************************************
 * creating mysql connection 
 * calling the functions.php file
 * including the header file.
 ******************************************/
    require("functions.php");
    require("session.php");
    $connection = connect_DB();
    include("header.php");
    /*************************************
     * 
     * perform sql query for about use page
     */
    $query = "select * from about_us";
    $result = get_result($query);
    $row = mysqli_fetch_assoc($result);
?>
<div class="items">
    <h1>OUR VISION</h1>
    <div class="text">
        <?php echo $row['vision']; ?>
    </div>
</div>

<div class="items">
    <h1>contact us</h1>
    <form action="about_us.php" method="post">
        <input type="text" name="name" placeholder="NAME" required/><br />
        <input type="text" name="email" placeholder="EMAIL" required/><br />
        <textarea name="message" placeholder="MESSAGE" required></textarea><br />
        <input type="submit" name="send" value="SEND" />
        <?php 
            if(isset($_POST['send'])) {
                $name = mysqli_real_escape_string($connection,$_POST['name']);
                $email = mysqli_real_escape_string($connection,$_POST['email']);
                $message = mysqli_real_escape_string($connection,$_POST['message']);
                $query = "insert into feedbacks (name,email,message) ";
                $query .= "values('{$name}','{$email}','{$message}')";
                if($result = get_result($query)) {echo "<p>Your Feedback is appreciated</p>";}
            }



        ?>
    </form>
</div>



<?php
     include("footer.php");
    mysqli_close($connection);
   

?>