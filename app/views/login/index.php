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
	  <h1>  Login  <?php echo $pos;?> 
	  <form class ="form-signin" action="<?php eh(url(''));?>" method="POST"><br />
	  
	  <h4><p class="sansserif"> Username </p>
	  <input type="text" class="span3" name="username" required/></p>
	  
	  <p class="sansserif">Password&nbsp;&nbsp; </p></h4>
	  <input type="password" name="password" required /></p>
	  
	  <button class="btn-large btn-primary" type="submit" name="login" id="login" >Login</button>
	  <a class="btn btn-large btn-primary" href="<?php eh(url('login/register'))?>">Register</a></h1>
	  </form>
</div>