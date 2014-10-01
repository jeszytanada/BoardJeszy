<?php if ($user->hasError()): ?>
    <div class = "alert alert-block">
        <h4 class = "alert-heading"> Validation error! Please Try again..
        </h4>

        <!-- Validation for USERNAME-->
        <?php if ($user->validation_errors['username']['length']): ?>
            <div><em>Your name</em> must be between
              <?php entities($user->validation['username']['length'][1]) ?> and
              <?php entities($user->validation['username']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>
    
        <!-- Validation for PASSWORD-->
        <?php if ($user->validation_errors['password']['length']): ?>
            <div><em>Your password</em> must be between
                <?php entities($user->validation['password']['length'][1]) ?> and
                <?php entities($user->validation['password']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>

        <!-- Validation for First Name-->
        <?php if ($user->validation_errors['fname']['length']): ?>
             <div><em>First Name</em> must be between
                 <?php entities($user->validation['fname']['length'][1]) ?> and
                 <?php entities($user->validation['fname']['length'][2]) ?> characters in length.
             </div>
        <?php endif ?>

        <!-- Validation for Last Name-->
        <?php if ($user->validation_errors['lname']['length']): ?>
             <div><em>Last Name</em> must be between
                 <?php entities($user->validation['lname']['length'][1]) ?> and
                 <?php entities($user->validation['lname']['length'][2]) ?> characters in length.
             </div>
        <?php endif ?>
    </div>
<?php endif ?>

<!-- Edit / Update Form-->
<div id = "box" class = "register-form">
  <h1> Edit / Update Profile
      <form class = "body" method = "post" action = "<?php entities(url('')) ?>">

          <label> Username </label>
          <input type = "text" class = "span3" name = "username" value = "<?php echo entities($_SESSION['username']) ?>" >
          </span>                 

          <label> Password </label>
          <input type ="Password" class = "span3" name = "password" value = "<?php echo entities($_SESSION['password']) ?>" >
          </span><font size = "3px" color = "gray" >Password (6-15 characters)</font>

          <label> First Name</label>
          <input type = "text" class = "span3" id = "fname" name = "fname" value = "<?php echo entities($_SESSION['fname']) ?>" >
          </span>

          <label> Last Name</label>
          <input type = "text" class = "span3" id = "lname" name = "lname" value = "<?php echo entities($_SESSION['lname']) ?>" >
          </span>

          <label> Email </label>
          <input type = "email" class = "span3" id = "email" name = "email" value = "<?php echo entities($_SESSION['email']) ?>" >
          <br />  
          <input type = "submit" name = "submit" value = "Submit" class = "btn-large btn-primary">
          <br />
          <a size = "5px" href = "<?php entities(url('thread/index')) ?>">
          &larr; Back to Threads</a>   
      </form>
  </h1>    
  <?php echo $position; ?>
</div>
