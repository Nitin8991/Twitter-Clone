<?php

    session_start();

    $link = mysqli_connect("sql113.epizy.com", "epiz_25570024", "WcGjTkzUjoIjF2U", "epiz_25570024_twitter");

    if(mysqli_connect_error())
    die("Connection error");

    if($_GET["function"] == "logout")
    {
        unset($_SESSION["id"]);
    }

    function time_since($since) {
        $chunks = array(
            array(60 * 60 * 24 * 365 , 'yr'),
            array(60 * 60 * 24 * 30 , 'mnth'),
            array(60 * 60 * 24 * 7, 'week'),
            array(60 * 60 * 24 , 'day'),
            array(60 * 60 , 'hr'),
            array(60 , 'min'),
            array(1 , 'sec')
        );

        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
            $seconds = $chunks[$i][0];
            $name = $chunks[$i][1];
            if (($count = floor($since / $seconds)) != 0) {
                break;
            }
        }

        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
        return $print;
    }

    function displayTweets($type)
    {
        global $link;

        $present = "";

        if($type == 'public')
        {
            $whereclause = "";
        }
        else if($type == 'isFollowing')
        {
            $query = "SELECT * FROM isFollowing WHERE follower = '".mysqli_real_escape_string($link, $_SESSION['id'])."'";
            $result = mysqli_query($link, $query);

            $whereclause = "";

            if(mysqli_num_rows($result) > 0)
            {
                while($row = mysqli_fetch_assoc($result))
                {
                    if($whereclause == "") $whereclause = "WHERE";
                    else $whereclause .= " OR ";
                    $whereclause .= " userid =".$row['isfollowing'];
                }
            }
            else
            $present = "notpresent";        
        }
        else if($type == 'yourtweets')
        {
            $whereclause = "WHERE userid = '".mysqli_real_escape_string($link, $_SESSION['id'])."'";
        }
        else if($type == 'search')
        {
            echo '<p>Showing results for ';
            echo mysqli_real_escape_string($link, $_GET['q']);
            echo " :</p>";
            $whereclause = "WHERE tweet LIKE '%".mysqli_real_escape_string($link,$_GET['q'] )."%'";
        }
        else if(is_numeric($type))
        {
            $query = "SELECT * FROM users WHERE id='".mysqli_real_escape_string($link, $type)."'";
            $result = mysqli_query($link, $query);
            $row = mysqli_fetch_assoc($result);
            echo "<h2>".mysqli_real_escape_string($link, $row['email'])."'s Tweets</h2>";
            $whereclause = "WHERE userid = ".mysqli_real_escape_string($link, $type);
        }

        $query = "SELECT * FROM `tweets` ".$whereclause." ORDER BY `datetime` DESC";

        $result = mysqli_query($link, $query);

        if(mysqli_num_rows($result) == 0 || $present == "notpresent")
        {
            echo "There are no tweets to display";
        }
        else
        {
            while($row = mysqli_fetch_assoc($result))
            {
                $userquery = "SELECT * FROM `users` WHERE id = '".mysqli_real_escape_string($link, $row['userid'])."' LIMIT 1";
                $userqueryresult = mysqli_query($link, $userquery);
                $user = mysqli_fetch_assoc($userqueryresult);
                
                if($row["timeanddate"] == 0)
                echo "<div class='tweet'><p>".$user["email"]." <span class='time'>".time_since(time()-strtotime($row["datetime"]))." ago:</span></p>";
                else
                echo "<div class='tweet'><p>".$user["email"]." <span class='time'>".time_since(time()-$row["timeanddate"])." ago:</span></p>";
                echo "<p>".$row["tweet"]."</p>";

                echo "<p><a href='#' class='togglefollow' data-userid='".$row['userid']."'>";
                $isfollowingquery = "SELECT * FROM isFollowing WHERE follower = '".mysqli_real_escape_string($link, $_SESSION['id'])."' AND isfollowing='".mysqli_real_escape_string($link, $row['userid'])."'";

                $isfollowingqueryresult = mysqli_query($link, $isfollowingquery);

                if(array_key_exists('id',$_SESSION) && $row['userid'] != $_SESSION['id'])
                {
                    if(mysqli_num_rows($isfollowingqueryresult) > 0)
                    echo "Unfollow";
                    else
                    echo "Follow";
                }
                echo "</a></p></div>";
            }
        }
    }

    function displaySearch()
    {
        echo '<form class="form-inline">
  <div class="form-group">
  <input type="hidden" name="page" value="search">
    <input type="text" name="q" class="form-control" id="search" placeholder="search">
  </div>
  <button type="submit" class="btn btn-primary searchbutton">Search Tweets</button>
</form>';
    }

    function displayTweetBox()
    {
        if($_SESSION["id"] > 0)
        {
            echo '<div id="tweetsuccess" class="alert alert-success">Your tweet was posted successfully.</div>
            <div id="tweetfail" class="alert alert-danger"></div>
            <div class="form">
        <div class="form-group">
            <textarea class="form-control" id="tweetcontent"></textarea>
        </div>
        <button type="submit" id="posttweetbutton" class="btn btn-primary">Post Tweet</button>
        </div>';
        }
    }

    function displayUsers()
    {
        global $link;
        $query = "SELECT * From users LIMIT 50";

        $result = mysqli_query($link, $query);

        while($row = mysqli_fetch_assoc($result))
        {
            echo "<p><a href='?page=publicprofiles&userid=".$row['id']."'>".$row['email']."</a></p>";
        }
    }
?>