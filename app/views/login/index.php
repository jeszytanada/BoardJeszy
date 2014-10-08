<div id = "box" class = "body">
<!--Form Log In-->
<br /><br />
    <h1>  Login  <?php echo $status ?>
        <form class = "form-signin" action = "<?php entities(url(''));?>" method = "POST"><br />
            <h4>
                <p class = "sansserif"> Username <br /> 
                    <input type = "text" class = "span3" name = "username" placeholder = "Username" required>
                </p>
                <p class="sansserif"> Password &nbsp;&nbsp;<br />
                    <input type = "password" name = "password" placeholder = "Password" required>
                </p>
            </h4>
            <button class = "btn-large btn-primary" type = "submit" name = "login" id = "login" > Login </button>
            <a class = "btn btn-large btn-primary" href = "<?php entities(url('login/register'))?>"> Register </a>
        </form>
    </h1>
</div>
