<div id="container">
    <h2> Thread: </h2>
</div>
    
<?php if ($thread->hasError() || $comment->hasError()): ?>
<div class = "alert alert-block">
    <h4 class = "alert-heading"> Validation error! Please Try Again.. </h4>

    <!-- VALIDATION ERROR ON TITLE OF THREAD-->
    <?php if (!empty($thread->validation_errors['title']['length'])): ?>
        <div><em> Title </em> must be between
            <?php entities($thread->validation['title']['length'][1]) ?> and
            <?php entities($thread->validation['title']['length'][2]) ?> characters in length.
        </div>
    <?php endif ?>
    <div>
        <em>Title: Does not accept whitespace only</em>
            <?php if ($thread->validation_errors['title']['format']): ?>
            <?php endif ?>
    </div>


    <!--VALIDATION ERROR ON COMMENT-->
    <?php if (!empty($comment->validation_errors['body']['length'])): ?>
        <div><em> Open Up: </em> must be between
            <?php entities($comment->validation['body']['length'][1]) ?> and
            <?php entities($comment->validation['body']['length'][2]) ?> characters in length.
        </div>
    <?php endif ?>
    <div>
        <em>Open up: Does not accept whitespace only</em>
            <?php if ($comment->validation_errors['body']['format']): ?>
            <?php endif ?>
    </div>

</div>
<?php endif ?>

<!--FORM to create new Thread and Comments -->
<form class = "body" method = "post" action = "<?php entities(url(''))?>">
    <div id ="leftcolumn" style="min-height: 50px;"><br />
        <label> Title </label>
        <input type = "text" class = "span8" name = "title" value = "<?php entities(Param::get('title')) ?>"><br /><br />
            <img src = "/bootstrap/img/flag.png" height="30" width="30">
            <font size="3">Flag:
                <font size = "5" color = "#0080FF"><?php echo entities($_SESSION['username']) ?></font><br />
                <input type = "radio" name = "username" value = "<?php entities($_SESSION['username']) ?>" required> Username
                <input type = "radio" name = "username" value = "Anonymous" required> Anonymous user 
            </font>
        <label><br /> Open Up: </label>
        <textarea name = "body" class = "span10" style = "height: 300px"><?php entities(Param::get('body')) ?></textarea><br />
        <input type = "hidden" name = "page_next" value = "create_end">
        <button type = "submit" class = "btn btn-primary"> Submit </button>
        <div style = "text-align: left">
            <a class = "btn btn-primary" href = "<?php entities(url('thread/index'))?>"> Cancel</a>
        </div>
    </div>
</form>
