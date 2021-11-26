<?php session_start() ?>
<?php require_once('include/connection.php'); //connection to the database?>
<?php //requre_once('inlude/function.php');//connect to the function.php file?>
<?php 

	// check for form submission
	if (isset($_POST['submit'])) {

		$errors = array();

		// check if the username and password has been entered
		if (!isset($_POST['email']) || strlen(trim($_POST['email'])) < 1 /*check the spaces int the field*/) {
			$errors[] = 'Username is Missing / Invalid';
		}

		if (!isset($_POST['password']) || strlen(trim($_POST['password'])) < 1 /*check the spaces int the field*/) {
			$errors[] = 'Password is Missing / Invalid';
		}

		// check if there are any errors in the form
		if (empty($errors)) {
			// save username and password into variables
			$email 		= mysqli_real_escape_string($connection, $_POST['email']);//assign database  data to variables
			$password 	= mysqli_real_escape_string($connection, $_POST['password']);
			$hashed_password = sha1($password);

			// prepare database query
            
			$query = "SELECT * FROM user 
						WHERE email = '{$email}' 
						AND password = '{$hashed_password}' 
						LIMIT 1";

			$result_set = mysqli_query($connection, $query);//match the data

			/* verify_query($result_set); we can use this function  insterd of below if*/
			if ($result_set) {
				// query succesfful

				if (mysqli_num_rows($result_set) == 1) {
					// valid user found

                    $user = mysqli_fetch_assoc($result_set);//get the user data to display in users.php
                    $_SESSION['user_id'] = $user['id'];//selct the relevent data fields
                    $_SESSION['first_name'] = $user['first_name'];
					// redirect to users.php

					//updating last log in

					$query = "UPDATE user SET last_login = NOW()/*this function return the current time*/";
					$query .= "WHERE id = {$_SESSION['user_id']}  LIMIT 1";//get the user id for identify

					$result_set = mysqli_query($connection, $query);//pass the data to the database

					if(!result_set){
						die("Database query failed");
					}
					header('Location: users.php');//send the data to user.php
				} else {
					// user name and password invalid
					$errors[] = 'Invalid Username / Password';
				}
			//we can delete this else when using verify_query function	
			} else {
				$errors[] = 'Database query failed';
			}
		}
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In</title>
    <link rel="stylesheet" href="CSS/main.css">
</head>
<body>
<!--this web page shows the log in apperance.-->

    <div class= "login">
        <form action= "index.php" method= "post">
            <fieldset>
            <legend><h1>Log In</h1></legend>

           <?php 
                if(isset($errors) && !empty($errors)){
                    echo "<p>Invalid username or password</P>";
                }

            ?>
            
            <?php 
                if(isset($_GET['logout'])){
                    echo '<p class="info"> You have successfully logged out from the system </p>';
                }
            ?>

            <p>
                <label>Username</label>
                <input type= "text" name= "email" placeholder= "email address">
            </p>

            <p>
                <label>password</label>
                <input type= "password" name= "password" placeholder= "password">
            </p>

            <p>
                <button type="submit" name= "submit">Log In</button>

            </fieldset>

                     
        </form>
    </div>
    
</body>
</html>
