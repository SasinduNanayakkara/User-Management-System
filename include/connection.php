
<?php 
//this is the connection page. this page used to connect database.

  $dbhost = 'localhost';
  $dbuser = 'root';
  $dbpass = '';
  $dbname = 'userdb';

  $connection = mysqli_connect('localhost', 'root', '', 'userdb');//connect to the database

  //checking the connection

  if(mysqli_connect_errno()){

        die('Database connection failed ' . mysqli_connect_error() );//this function is used to dislpay the error
  }

?>