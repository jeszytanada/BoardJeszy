<?php if ($user->hasError()): ?>
    <div class="alert alert-block">
    <h4 class="alert-heading">Validation error! Please Try again..</h4>


<!-- Validation for NAME-->
<?php if ($user->validation_errors['name']['length']): ?>
	   <div><em>Name</em> must be between
	   <?php eh($user->validation['name']['length'][1]) ?> and
	   <?php eh($user->validation['name']['length'][2]) ?> characters in length.
     </div>
<?php endif ?>


<!-- Validation for USERNAME-->
<?php if ($user->validation_errors['username']['length']): ?>
      <div><em>Your name</em> must be between
      <?php eh($user->validation['username']['length'][1]) ?> and
      <?php eh($user->validation['username']['length'][2]) ?> characters in length.
      </div>
<?php endif ?>

       
<!-- Validation for PASSWORD-->
<?php if ($user->validation_errors['password']['length']): ?>
      <div><em>Your password</em> must be between
      <?php eh($user->validation['password']['length'][1]) ?> and
      <?php eh($user->validation['password']['length'][2]) ?> characters in length.
      </div>
<?php endif ?>

<?php endif ?>
      </div>


<!-- Registration Form-->
<div class="register-form">
<style>
p.sansserif {
    font-family: Arial, Helvetica, sans-serif;
}
body {
    background-color: #b0c4de;
}

</style>
  <h1> Registration
	<form class="well" method="post" action="<?php eh(url('')) ?>" onSubmit = "register()">
	<a name = "login" href="<?php eh(url('login/index'));?>">
  <font size = "2">Already Registered? Log in</font></a>

    
    <label>Username</label>
    <input type="text" class="span3" id="username" name="username" placeholder="Username"required>
    <span class="icon-asterisk"></span>                 

    <label>Password</label>
    <input type ="Password" class="span3" name="password" id="password" placeholder="Password (6-15 length)"required>
    <span class="icon-asterisk"></span>

 	  <label>Name</label>
    <input type="text" class="span3" name="name" id="name" placeholder="Name" required>
    <span class="icon-asterisk"></span>

    <label>Email</label>
    <input type="email" class="span3" id="email" name="email" placeholder="Email"required>
    <span class="icon-asterisk"></span><br />  
    
    <input type="submit" name="submit" id="submit" value="Submit" class="btn-large btn-primary"> </h1>
            
</form>
<?php echo $pos; ?>