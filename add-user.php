<?php session_start() //start the seesion?>
<?php require_once('include/connection.php'); //connection to database ?>
<?php require_once('include/function.php'); //connect to the function.php?>
<?php
   
   
    $errors = array();

    $first_name = '';
    $last_name = '';
    $email = '';
    $password = '';

 
    if(isset($_POST['submit']))/*check the user press the submit button*/{

        $first_name = $_POST['first_name'];//assing user iput value to  variables
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        //checking required fields
        $requre_field = array('first_name','last_name','email','password');

        //we can make a function for this foreach
        foreach($requre_field as $field){
            if(empty(trim($_POST[$field]))){
                $errors[] = $field . "is required";
            }
        }
        //checking max length

        $max_len_fields = array('first_name' => 50 , 'last_name' => 100 , 'email' => 100 , 'password' => 40);
        
       // foreach($max_len_fields as $field/*variable name */ => //$max_len/*variable value*/){
        foreach($max_len_fields as $field => $max_len){//we can make a function for this foreach
            if(strlen(trim($_POST[$field])) > $max_len){
                $errors[] = $field .'must be less than ' . $max_len . 'characters' ; 
            }
        }    
        
    

        /*foreach ($max_len_fields as $field => $max_len) {
			if (strlen(trim($_POST[$field])) > $max_len) {
				$errors[] = $field . ' must be less than ' . $max_len . ' characters';
			}
		 }*/

        
        

        //checking if email address is already  exists
        /* sanitized email.(without any queries)*/
         $email =  mysqli_real_escape_string($connection, $_POST['email']);//this function used to avoid user inputted sql queries
         $query = "SELECT * FROM user WHERE email = '{$email}' LIMIT 1 ";//sql command to select email

         $result_set = mysqli_query($connection , $query);//pass the data to database

         if($result_set){//check the errors
            if(mysqli_num_rows($result_set) == 1){//check if there are some records
                //this if true there have some error
                $errors[] = "Email address already exists";
            }
         }

         if(empty($errors)){
             
             //no errors found... add new record

            //sanitize the user inputs(avoid the sql hacking commands)
             $first_name = mysqli_real_escape_string($connection , $_POST['first_name']);
             $last_name = mysqli_real_escape_string($connection , $_POST['last_name']);
             $password = mysqli_real_escape_string($connection , $_POST['password']);

             //$email already sanitized

             $hashed_password = sha1($password);//encrypted password

             //adding new query to database

             

             $query = "INSERT INTO user ( ";
			$query .= "first_name, last_name, email, password, is_deleted";
			$query .= ") VALUES (";
			$query .= "'{$first_name}', '{$last_name}', '{$email}', '{$hashed_password}', 0";
			$query .= ")";

			$result = mysqli_query($connection, $query);

			if ($result) {
				// query successful... redirecting to users page
				header('Location: users.php?user_added=true');
			} else {
				$errors[] = 'Failed to add the new record.';
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
    <title>Add new user</title>
    <link rel="stylesheet" href="CSS/main.CSS">
    <style>
        .userform label{
        width: 30%;
        float: left;
        }

        .userform input{
        width: 60%;
    
        }   

        .userform button{
        width: 200px;
        }
        .password{
            width: 60%;
            float:right;
            position: absolute;
            margin-left:100px;
        }
        .errmsg{
        color: red;
       
    }
    </style>
</head>
<body>
    <header>
        <div class="appname">User management system</div>
        
        <div class="log">Welcome <?php echo $_SESSION['first_name']; //display the logged user name?> ! <a href="logout.php">Log Out</a> </div>
    </header>
        <main>
        <h1>Users<span><a href="users.php">+ Back to user list</a></span></h1>

        <?php
            if(!empty($errors)){//check there were any empty field
                echo "<div class='errmsg' >";
                echo "Tehere were error in your form";
                foreach($errors as $error){

                }
                echo "</div>";
            }

        ?>

        <form action="add-user.php" method="post" class="userform">
            <p>
                <label >First name : </label>
                <input type="text" name="first_name" <?php echo 'value =" ' . $first_name . '"'//if we do some mistake input data will not be deleted ?> >
            </p>

            <p>
            <label >Last name : </label>
            <input type="text" name="last_name" <?php echo 'value=" ' . $last_name . '"'//if we do some mistake input data will not be deleted ?> >
            </p>

            <p>
            <label >Email : </label>
            <input type="email" name="email"  <?php echo 'value=" ' . $email . '"' //if we do some mistake input data will not be deleted?>>
            </p>

            <p>
            <label>New password : </lablel>
            
            <input type="password" name="password" class="password" >
            </p>

            <p>
                <br><br><br><br><br>
            <label>&nbsp;</label>
            <button type="submit" name="submit">Save</button>
            </p>
        </form>
       

        </main>
</body>
</html>