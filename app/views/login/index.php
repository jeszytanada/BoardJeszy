<div class="register-form">
    <style>
        p.sansserif {
            font-family: Arial, Helvetica, sans-serif;
        }
        body {
            background-color: #b0c4de;
        }
    </style>

<!--Form Log In-->
<br /><br /> 
    <h1>  Login  <?php echo $position;?> 
        <form class = "form-signin" action = "<?php entities(url(''));?>" method = "POST"><br />
            <h4>
                <p class = "sansserif"> Username <br /> 
                    <input type = "text" class = "span3" name = "username" required>
                </p>
                <p class="sansserif"> Password &nbsp;&nbsp;<br />
                    <input type = "password" name = "password" required>
                </p>
            </h4>
            <button class = "btn-large btn-primary" type = "submit" name = "login" id = "login" > Login </button>
            <a class = "btn btn-large btn-primary" href = "<?php entities(url('login/register'))?>"> Register </a>
        </form>
    </h1>
</div>
