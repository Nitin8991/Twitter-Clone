<?php
    include("views/functions.php");

    include("views/header.php");

    if($_GET['page'] == 'timeline')
    {
        include("views/timeline.php");
    }
    else if($_GET['page'] == 'yourtweets')
    {
        include("views/yourtweets.php");
    }
    else if($_GET['page'] == 'search')
    {
        include("views/search.php");
    }
    else if($_GET['page'] == 'publicprofiles')
    {
        include("views/publicprofile.php");
    }
    else
    {
        include("views/homepage.php");
    }

    include("views/footer.php");
?>