<style>
#center {
	text-align: center;
}
#box {
    background-color: #b0c4de;
    padding: 25px;
    border: 25px white;
}
</style>

<h2><?php eh($thread->title) ?></h2>
    <?php if($comment->hasError()): ?>

<div class="alert alert-block">
    <h4 class="alert-heading">Validation error! Please Try Again..</h4>

    <!--Validation for COMMENT-->
    <?php if(!empty($comment->validation_errors['body']['length'])): ?>
        <div><em>Comment</em> must be between
        <?php eh($comment->validation['body']['length'][1]) ?> and
        <?php eh($comment->validation['body']['length'][2]) ?> characters in length.
        </div>
    <?php endif ?>

</div>
<?php endif ?>

<!--FORM to add Comments-->
<div id="box">
    <form class="well" method="post" action="<?php eh(url('thread/write')) ?>">
	    <div style="color:#0080FF"><?php echo $_SESSION['username'] ?></div><br />
	    
	    <label>Comment:</label>
	    <textarea name="body" class="span8"><?php eh(Param::get('body')) ?></textarea><br />
	
	    <input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
	    <input type="hidden" name="page_next" value="write_end">
	    <button type="submit" class="btn btn-primary">Submit</button> 
    </form>
</div>
