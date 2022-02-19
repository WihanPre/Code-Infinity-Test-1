<!-- 
    Basic PHP page/program to register users to a database using HTML form input.
    Build with XAMMP to run apache server and connect to SQL(lite).
    Create on: 14-02-202
    Author: Wihan.pre
    Version: 1.1.2

    Requires: PHP 5.5 ++
              SQL 14.0 ++
              Apache 2.4 ++

    Cennetion Page.
-->
<?php 
     //setting connection to SQL
    $connection = mysqli_connect("localhost","root","","register_db");

    //test connection
    if(!$connection){
        echo "Connection Error!!!: " . mysqli_connect_error();
    }
    else{
        //echo "Ok Buddy."; //control print statement to confirm connection.
    }
?>