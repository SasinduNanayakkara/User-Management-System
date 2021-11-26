<?php
    session_start();//start session

    $_SESSION = array();//delete the the user data got in index.php
    if(isset($_COOKIE[session_name()])){
        setcookie(session_name()/*name*/,''/*value*/,time()/*current time*/-86400,'/'/*affect to the root*/);//delete the cookie data

    }
    session_destroy();//end the session

    header('Location: index.php?logout=yes');

?>