<?php
    //this function is used to check the errors.using this function we can reduce if(result_set)loop
    function verify_query($result_set){
        global $connetion;

        if(!result_set){
            die("Database query failed: " . mysqli_error($connection));
        }
    }
?>