<h2>
    <?php entities($thread->title) ?>
</h2>    
    
<?php if($comment->hasError()): ?>
    <div class = "alert alert-block">
        <h4 class = "alert-heading"> Validation error! Please Try Again..</h4>

<<<<<<< HEAD
            <!--Validation for COMMENT-->
=======
        <!--Validation for COMMENT-->
>>>>>>> issue6
        <?php if (!empty($comment->validation_errors['body']['length'])): ?>
            <div><em>Comment</em> must be between
                <?php entities($comment->validation['body']['length'][1]) ?> and
                <?php entities($comment->validation['body']['length'][2]) ?> characters in length.
            </div>
        <?php endif ?>
    </div>
<?php endif ?>

<!--FORM to add Comments-->
<div id = "box">
    <form class = "well" method = "post" action = "<?php entities(url('')) ?>">
<<<<<<< HEAD
        <div style = "color:#0080FF"><?php echo $_SESSION['username'] ?>
        </div><br />
        
        <label> Comment: </label>
        <textarea name = "body" class = "span10" style = "height: 300px"><?php entities(Param::get('body')) ?></textarea><br />
    
=======
        <div style = "color:#0080FF"><?php echo entities($_SESSION['username']) ?>
        </div><br />
        <label> Post a reply: </label>
        <textarea name = "body" class = "span10" style = "height: 300px"><?php entities(Param::get('body')) ?></textarea><br />
>>>>>>> issue6
        <input type = "hidden" name = "thread_id" value = "<?php entities($thread->id) ?>">
        <input type = "hidden" name = "page_next" value = "write_end">
        <button type = "submit" class = "btn btn-primary"> Submit </button> 
    </form>
</div>
