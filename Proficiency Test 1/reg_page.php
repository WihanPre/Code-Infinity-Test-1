<!-- 
Basic PHP page/program to register users to a database using HTML form input.
Build with XAMMP to run apache server and connect to SQL(lite).
Create on: 14-02-202
Author: Wihan.pre
Version: 1.1.2

    Requires: PHP 5.5 ++
          SQL 14.0 ++
          Apache 2.4 ++

Input Page
-->
<?php
    //Including connection to sql
    include("db_connection.php");

    //Empty variables and associated array for persistant data and appropriate error message.
    $name = $surname = $id_number = $dob = "";
    
    $associate_error = array("name" => "", "surname"=>"", "id_number"=>"", "DoB"=>"","dup_error"=>"");

    //Will change to POST, leave as GET for testing. (PN: POST is more secure)
    //HMTMLSpecChars == prevents XXS attack
    //Conditional if with isset() to action conditional checks.
    if(isset($_POST['submit'])){

        //Level 1 validation == empty fields, 
        //Level 2 Validation == check input with regex.
        //For each input field
        if(empty($_POST ['name'])){
            $associate_error["name"] = "Please enter a name.";
        }
        else{ 
            $name = $_POST["name"];
            if(!preg_match("/^[a-zA-Z\s]+$/", $name)){
                $associate_error["name"] = "Name must be letters only.";
            }
        }

        if(empty($_POST ['surname'])){
            $associate_error["surname"] = "Please enter your surname.";
        }
        else{ 
            $surname = $_POST["surname"];
            if(!preg_match("/^[a-zA-Z\s]+$/", $surname)){
                $associate_error["surname"] = "Surname must be letters.";
            }
        }

        if(empty($_POST ['id_number'])){
            $associate_error["id_number"] = "Please enter your ID Number!";
        }
        elseif (strlen($_POST ['id_number']) < 13){
            $id_number = $_POST["id_number"];
            $associate_error["id_number"] = "ID Number entered is less than 13 characters.";
        }
        else{ 
            $id_number = $_POST["id_number"];
            if(!preg_match("/^[1-9][0-9]{0,12}$/", $id_number)){
                $associate_error["id_number"] = "ID Number can not contain letters.";              
            }
        }

        if(empty($_POST ['DoB'])){
            $associate_error["DoB"] = "Please enter date of birth";
        }
        else{ 
            $dob = $_POST["DoB"];
            if(!preg_match("^\\d{1,2}/\\d{2}/\\d{4}^", $dob)){
                $associate_error["DoB"] = "Please enter date in correct foramt: DD/MM/YYYY";
            }
        }
        //the below should return to home page after registration is successful, technically the echo here should never display.
        if(array_filter($associate_error)){
            //echo "There are error inputs";  //control print statement.       
        }
        //Else to set variable values (and poorly corrected date format) and execute SQL command, 
        //If successful, DB is updated and user is returned to "home page".
        //Implamented try catch to avoid crash if dupicate ID is entered. Try populates the 
        //associative array with the appropriate error message to be echoed out.
        else{
            try{
                $name = $_REQUEST["name"];
                $surname = $_REQUEST["surname"];
                $id_number = $_REQUEST["id_number"];
                $dob = $_REQUEST["DoB"];
                //This is not the ideal solution, on final test strtotime() function changed all dates to 01-01-1970.
                $DoB = $dob[6].$dob[7].$dob[8].$dob[9].$dob[5].$dob[3].$dob[4].$dob[2].$dob[0].$dob[1];
                //$DoB = date("Y-m-d", strtotime($dob)); 
                
                //Creating SQL command
                $sql = "INSERT INTO register_info VALUES ('$name', '$surname', '$id_number', '$DoB')";

                //Conditional statement to execute SQL if all valiations are passed.
                if(mysqli_query($connection, $sql)){
                header("location: index.php");
                }else{
                    echo "Error. Person Did not Register!";
                }
            }catch (Exception $dup_error){
                //echo $dup_error->getMessage(); //control print statement
                $associate_error["dup_error"] = "ID Number has already been registered.";
            }
        }
    }
    //Cancel action will return user to "home page."
    if (isset($_POST['cancel'])){
        header("location: index.php");
    }
?>

<!--Basic HTML Template with form to capture user input
    and send to PHP, to be added to databse. To ensure 
    persistant incorrect inputs are stored in empty variables
    and "echoed" to the relevant field is validation does not 
    pass. Associative array with empty values are use to display
    apporpiate error message to user. Values are assigned according
    to what valdiation fails. Cancel button included to return 
    user to home page.--> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Start</title>
</head>
<body>
    <h1 style = "text-align:center;">Registration Form</h1>
    <br>
    <form  style = "text-align:center;" action="reg_page.php", method="POST">
        <br>

        <div><label>Name</label>
            <input type="text", name="name", value="<?php echo htmlspecialchars($name) ?>"></div>
            <div><p style="color: red"><?php echo $associate_error['name']; ?></p></div>
            <br>

        <div><label>Surname</label>
            <input type="text", name="surname", value="<?php echo htmlspecialchars($surname) ?>"></div>
            <div><p style="color: red"><?php echo $associate_error['surname']; ?></p></div>
            <br>

        <div><label for="id_number">ID Number</label>
            <input type="text", name="id_number", maxlength="13" value="<?php echo htmlspecialchars($id_number) ?>"></div>
            <div><p style="color: red"><?php echo $associate_error['id_number']; ?></p></div>
            <div><p style="color: red"><?php echo $associate_error['dup_error']; ?></p></div>
            <br>

        <div><label>Date of Birth </label>
            <input type="text", name="DoB", placeholder="DD/MM/YYYY", value="<?php echo htmlspecialchars($dob)?>"></div>
            <div><p style="color: red"><?php echo $associate_error['DoB']; ?></p></div>
            <br>

            <button type="submit", name="submit", value="submit">Submit</button>
            <button type="cancel", name="cancel", value="cancel">Cancel</button>
            <br>
        </form>

</body>
</html>