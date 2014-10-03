<?php if($thread->hasError()): ?>
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

</div>
<?php endif ?>

<!--FORM to Update Thread -->
<form class = "body" method = "post" action = "<?php entities(url(''))?>">
    <div id ="leftcolumn" style="min-height: 50px;"><br />
        <label> Edit Title </label>
        <input type = "text" class = "span8" name = "title" value = "<?php entities(Param::get('title')) ?>" placeholder = "New Title">
            <br /><br />
            <div style = "color: #0080FF">
                <font size="5"><?php echo entities($_SESSION['username']) ?></font>
            </div><br />
            <br />  
        <input type = "submit" name = "submit" value = "Submit" class = "btn-large btn-primary"><br />
        <input type = "hidden" class = "span4" name = "user_id" value = "<?php entities($_SESSION['id']) ?>">
        <a href = "<?php entities(url('thread/index')) ?>">
          &larr; Back to Threads</a>
    </div>
    <?php echo $position; ?>
</form>

