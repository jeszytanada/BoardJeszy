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
          <input type = "text" class = "span3" id = "username" name = "username" placeholder = "New username" required>
          <span class="icon-asterisk"></span>                 

          <label> Password </label>
          <input type ="Password" class = "span3" name = "password" id = "password" placeholder = "New Password (6-15 length)" required>
          <span class="icon-asterisk"></span>

          <label> First Name</label>
          <input type = "text" class = "span3" name = "fname" id = "fname" placeholder = "New First Name" required>
          <span class = "icon-asterisk"></span>

          <label> Last Name</label>
          <input type = "text" class = "span3" name = "lname" id = "lname" placeholder = "New Last Name" required>
          <span class = "icon-asterisk"></span>

          <label> Email </label>
          <input type = "email" class = "span3" id = "email" name = "email" placeholder = "New Email" required>
          <span class = "icon-asterisk"></span><br />  
          <input type = "submit" name = "submit" id = "submit" value = "Submit" class = "btn-large btn-primary">
          <br />
          <a size = "5px" href = "<?php entities(url('thread/index')) ?>">
          &larr; Back to Threads</a>   
      </form>
  </h1>    
  <?php echo $position; ?>
</div>
