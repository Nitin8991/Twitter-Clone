<?php

    include("functions.php");

    if($_GET["action"] == "loginsignup")
    {
        $error="";

        if(!$_POST["email"])
        {
            $error = "An email address is required";
        }
        else if(!$_POST["password"])
        {
            $error = "A password is required";
        }
        else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $error = "Invalid email format";
        }

        if($error != ""){
            echo $error;
            exit();
        } 

        if($_POST["loginactive"] == "0")
        {
            $query = "SELECT * FROM `users` WHERE `email` = '".mysqli_real_escape_string($link, $_POST["email"])."'";
            $result = mysqli_query($link, $query);
            if(mysqli_num_rows($result) > 0)
            $error = "This email address is already taken"; 
            else
            {
                $query = "INSERT INTO users (`email`, `password`) VALUES('".mysqli_real_escape_string($link, $_POST["email"])."','".mysqli_real_escape_string($link, $_POST["password"])."')";

                if(mysqli_query($link, $query))
                {
                    $_SESSION["id"] = mysqli_insert_id($link);
                    echo 1;
                }
                else
                $error = "Couldn't signup try again later";
            }
        }
        else
        {
            $query = "SELECT * FROM `users` WHERE `email` = '".mysqli_real_escape_string($link, $_POST["email"])."'";

            $result = mysqli_query($link, $query);

            $row = mysqli_fetch_array($result);

            if($row["password"] == $_POST["password"])
            {
                $_SESSION["id"] = $row["id"];
                echo "1";
            }
            else
            $error = "Couldn't log in try again later";
        }

        if($error != ""){
            echo $error;
            exit();
        } 
    }

    if($_GET['action'] == 'togglefollow')
    {
        $query = "SELECT * FROM `isFollowing` WHERE follower = '".mysqli_real_escape_string($link, $_SESSION['id'])."' AND isfollowing = '".mysqli_real_escape_string($link, $_POST['userid'])."' LIMIT 1";

        $result = mysqli_query($link, $query);

        if(mysqli_num_rows($result) > 0)
        {
            $row = mysqli_fetch_array($result);

            mysqli_query($link, "DELETE FROM isFollowing WHERE id ='".mysqli_real_escape_string($link, $row['id'])."'LIMIT 1");
            echo "1";
        }   
        else
        {
            mysqli_query($link, "INSERT INTO isFollowing (`follower`, `isfollowing`) VALUES (".mysqli_real_escape_string($link, $_SESSION['id']).", ".mysqli_real_escape_string($link, $_POST['userid']).")");
            echo "2";
        }
    }

    if($_GET['action'] == 'posttweet')
    {
        if(!$_POST['tweet'])
        echo "Your tweet is empty";
        else if(strlen($_POST['tweet']) > 100)
        echo "Your tweet is too lengthy";
        else
        {
            $curr = time();
            $query = "INSERT INTO `tweets` (`tweet`, `userid`, `datetime`,`timeanddate`) VALUES ('".$_POST['tweet']."','".mysqli_real_escape_string($link, $_SESSION['id'])."',NOW(),'".time()."')";
            mysqli_query($link, $query);
            echo "1";
        }
    }

?>