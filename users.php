<?php session_start() //start the seesion?>
<?php require_once('include/connection.php'); //connection to database ?>
<?php require_once('include/function.php'); //connect to the function.php?>
<?php
   //check if the user logged in
   if(!isset($_SESSION['user_id'])){
       header('Location : index.php');
   }

   $user_list = '';
   //getting the list of users

   $query = "SELECT * FROM user WHERE is_deleted=0 ORDER BY first_name";
   $users = mysqli_query($connection, $query);

   if($users){
        while($user = mysqli_fetch_assoc($users))//assign data one by one to user varable
        {
            /*$user_list .= "<tr>";
            $user_list .= "<td>{$user['first_name']}</td>";//add first name
            $user_list .= "<td>{$user['last_name']}</td>";//add last name
            $user_list .= "<td>{$user['last_login']}</td>";//add last login
            $user_list .= "<td><a href  \"modify-user.php?user_id={$user=['id']}\">Edit</a></td>";//link to the modify-user.php with data from id
            $user_list .= "<td><a href \"delete-user.php?user_id={$user=['id']}\">Delete</a><td>";//link to the delete-user.php with data from id
            $user_list .= "</tr>";*/

            $user_list .= "<tr>";
			$user_list .= "<td>{$user['first_name']}</td>";//add first name
			$user_list .= "<td>{$user['last_name']}</td>";//add last name
			$user_list .= "<td>{$user['last_login']}</td>";//add last login
			$user_list .= "<td><a href=\"modify-user.php?user_id={$user['id']}\">Edit</a></td>";//link to the modify-user.php with data from id
			$user_list .= "<td><a href=\"delete-user.php?user_id={$user['id']}\">Delete</a></td>";//link to the delete-user.php with data from id
			$user_list .= "</tr>";

        }
   }else{
       echo "Database Query faild"; //display the error
   }
   ?>
   
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="CSS/main.CSS">
</head>
<body>
    <header>
        <div class="appname">User management system</div>
        
        <div class="log">Welcome <?php echo $_SESSION['first_name']; //display the logged user name?> ! <a href="logout.php">Log Out</a> </div>
    </header>
        <main>
        <h1>Users<span><a href="add-user.php">+ Add new</a></span></h1>

        <table class="masterlist">
            <tr>
                <th>First name</th>
                <th>Last name</th>
                <th>Last Login</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>

            <?php echo $user_list;?>
        </table>

        </main>
</body>
</html>