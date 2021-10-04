<footer class="footer">
    <p>&copy; My Website 2020</p>  
</footer>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>    
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Log In</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="alert alert-danger" id="loginalert">
                        </div>
                        <input type="hidden" id="loginactive" name="loginactive" value="1">
                        <div class="form-group row">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control-plaintext" id="email" placeholder="email@example.com">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" id="password">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <a id="secondbutton">Sign up</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="mainbutton">Log In</button>
                </div>
            </div>
        </div>
    </div>

    
  <script type="text/javascript">

        $("#secondbutton").click(function(){
            if($("#loginactive").val() == "1")
            {
                $("#secondbutton").html("Log in");
                $("#mainbutton").html("Sign up");
                $("#exampleModalLabel").html("Sign Up");
                $("#loginactive").val("0");
            }
            else
            {
                $("#secondbutton").html("Sign up");
                $("#mainbutton").html("Log in");
                $("#exampleModalLabel").html("Log In");
                $("#loginactive").val("1");
            }
        })


        $("#mainbutton").click(function(){
            $.ajax({
                method: "POST",
                url: "views/action.php?action=loginsignup",
                data: "email=" + $("#email").val() + "&password=" +$("#password").val() + "&loginactive=" + $("#loginactive").val(),
                success: function(result){
                    if(result == "1")
                    {
                        window.location.assign("http://goblin.epizy.com/twitter.php");
                    }
                    else
                    {
                        $("#loginalert").html(result).show();
                    }
                }
                });
        });

        $(".togglefollow").click(function(){

            var id = $(this).attr("data-userid");
            $.ajax({
                method: "POST",
                url: "views/action.php?action=togglefollow",
                data: "userid=" + $(this).attr("data-userid"),
                success: function(result){
                    
                    if(result == '1')
                    {
                        $("a[data-userid='" + id + "']").html("Follow");
                    }
                    else
                    {
                        $("a[data-userid='" + id + "']").html("Unfollow");
                    }
                }
                });
        })

        $("#posttweetbutton").click(function(){
            $.ajax({
                method: "POST",
                url: "views/action.php?action=posttweet",
                data: "tweet=" + $("#tweetcontent").val(),
                success: function(result){
                    
                    if(result == "1")
                    {
                        $("#tweetsuccess").show();
                        $("#tweetfail").hide();
                    }
                    else
                    {
                        $("#tweetfail").html(result).show();
                        $("#tweetsuccess").hide();
                    }
                }
                });
        })
  </script>
  </body>

</html>