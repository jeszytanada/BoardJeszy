<style>
    #container {
       width:800px;
    }
   #leftcolumn { 
        width: 870px; 
        float: left;
        margin: 5px;
        padding: 10px;
        background: #b0c4de;
        font-size: 11px;
    }
    #pad {
        padding: 10px;
        width: 800px;
    }
</style>

<div id="container">
    <h2> Create Thread </h2>
</div>
    
<?php if($thread->hasError() || $comment->hasError()): ?>
<div class = "alert alert-block">
    <h4 class = "alert-heading"> Validation error! Please Try Again.. </h4>

    <!-- VALIDATION ERROR ON TITLE OF THREAD-->
    <?php if (!empty($thread->validation_errors['title']['length'])): ?>
        <div><em> Title </em> must be between
            <?php entities($thread->validation['title']['length'][1]) ?> and
            <?php entities($thread->validation['title']['length'][2]) ?> characters in length.
        </div>
    <?php endif ?>


    <!--VALIDATION ERROR ON COMMENT-->
    <?php if(!empty($comment->validation_errors['body']['length'])): ?>
        <div><em> Comment </em> must be between
            <?php entities($comment->validation['body']['length'][1]) ?> and
            <?php entities($comment->validation['body']['length'][2]) ?> characters in length.
        </div>
    <?php endif ?>  

</div>
<?php endif ?>

<!--FORM to create new Thread and Comments -->
<form class = "well" method = "post" action = "<?php entities(url(''))?>">
    <div id ="leftcolumn" style="min-height: 50px;"><br />
        <label> Title </label>
        <input type = "text" class = "span8" name = "title" value = "<?php entities(Param::get('title')) ?>">
        <label> Your name </label>
        <input type = "text" class = "span4" name = "username" value = "<?php echo $_SESSION['username'] ?>" disabled>
        <label> Comment </label>
        <textarea name = "body" class = "span8"><?php entities(Param::get('body')) ?></textarea><br />
        <input type = "hidden" name = "page_next" value = "create_end">
        <button type = "submit" class = "btn btn-primary"> Submit </button>
    </div>
</form>
