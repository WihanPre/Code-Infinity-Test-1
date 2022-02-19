<!-- 
    Basic PHP page/program to register users to a database using HTML form input.
    Build with XAMMP to run apache server and connect to SQL(lite).
    Create on: 14-02-202
    Author: Wihan.pre
    Version: 1.1.2

    Requires: PHP 5.5 ++
              SQL 14.0 ++
              Apache 2.4 ++

    Home Page
-->
<?php
    //Including connection to sql
    include("db_connection.php");

    //Creating sql command to collect all data
    $sqlq = 'SELECT name, surname, id_number, date_of_birth FROM register_info';

    //execute query and saving result
    $result = mysqli_query($connection, $sqlq);

    //isset action to display all people registerd on index page.
    if(isset($_POST['submit'])){
        $l_n = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    //counter variable to number each person in loop out.
    $count = 0;
?>

<!--Basic HTML Template as home page where user can select
    if they wan to register to databse or see all regisered 
    people Additional feature, included a action button to 
    retieve and display all registered people--> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Start</title>
</head>
<body>
    <h1 style = "text-align:center;" >Registration Main Page</h1>
    <p  style = "text-align:center;" >Good day user.</p>

    <h3 style = "text-align:center;">Please clink on button to register.</h3>
    <form style = "text-align:center;" method= "POST", action="reg_page.php">
        <input style = "text-align:center;" type="submit", name="register", value="Register">
    </form>
    <br>

    <h3 style = "text-align:center;">Please clink on button to view all people registered.</h3>
    <form style = "text-align:center;" method= "POST", action="index.php">
        <input style = "text-align:center;" type="submit", name="submit", value="View All">
    </form>
    <br>
    
    <div style = "text-align:center;">
        <!-- running for each loop to display data from database.-->
        <?php foreach($l_n as $l_n) {?>
                    <?php $count += 1?>
            <div><h3><?php echo htmlspecialchars("Person ".$count. ":")?></h3></div>        
            <div><p><?php echo htmlspecialchars("Name: ".$l_n["name"])?></p></div>
            <div><p><?php echo htmlspecialchars("Surname: ".$l_n["surname"])?></p></div>
            <div><p><?php echo htmlspecialchars("ID Number: ".$l_n["id_number"])?></p></div>
            <div><p><?php echo htmlspecialchars("Date of Birth: ".date("d-m-Y",strtotime($l_n["date_of_birth"])))?></p></div>

        <?php }?>
    </div>
    <br>
    <p style = "text-align:center;">Thank you for registring, have a great day.</p>
</body>
</html>