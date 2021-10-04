<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <title>Twitter</title>
    
    <style type="text/css">
        <?php include("style.css") ?>
    </style>   
  </head>
  <body>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="http://goblin.epizy.com/twitter.php">Twitter</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                <?php if(array_key_exists('id',$_SESSION)) { ?>
                <li class="nav-item active">
                    <a class="nav-link" href="?page=timeline">Your timeline<span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="?page=yourtweets">Your tweets</a>
                </li>

                <?php } ?>
                <li class="nav-item">
                    <a class="nav-link" href="?page=publicprofiles">Public Profiles</a>
                </ul>
                <div class="form-inline my-2 my-lg-0">
                <?php if($_SESSION["id"]){ ?>
                    <a class="btn btn-outline-success my-2 my-sm-0" href="?function=logout">LogOut</a>
                <?php } else{ ?>
                <button class="btn btn-outline-success my-2 my-sm-0" data-toggle="modal" data-target="#exampleModal">LogIn/SignUp</button>
                <?php } ?>             
                </div>
            </div>
        </nav>