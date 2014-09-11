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

<h1><?php eh($thread->title) ?></h1>
<?php foreach ($comments as $k => $v): ?>
<div class="comment">
    <div class="meta">
    <h4><?php eh($v->username) ?> <?php eh($v->created) ?></h4></div>
    <div class="well" id="box"><?php echo "Comment: "; eh($v->body) ?></div>
</div>
<?php endforeach ?>


<!--Form for new Comment -->
<hr>
<div id="box">
    <form class="well" method="post" action="<?php eh(url('thread/write')) ?>">
	    <label>Your name </label>
	    <input type="text" class="span4" name="username" value="<?php eh(Param::get('username')) ?>" >
	    <label>Comment</label>
	    <textarea name="body" class="span8"><?php eh(Param::get('body')) ?></textarea>
	    <br />
	    <input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
	    <input type="hidden" name="page_next" value="write_end">
	    <button type="submit" class="btn btn-primary">Submit</button>
</form></hr></div><br />

<!--To display or echo out the recent / latest comment inside the thread-->
<div class="well" id="box">
    <?php eh($v->username) ?><?php echo ": "; echo readable_text($v->body) ?>
</div>

<div id="center">
<button class="btn btn-primary" type="button" onclick="window.location.href='index'">Back to Threads</button>
</div>
