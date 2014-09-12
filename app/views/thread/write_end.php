<h2>
	<?php eh($thread->title) ?>
</h2>

<p class="alert alert-success"> Comment Succcess!
</p>

<a href="<?php eh(url('thread/view', array('thread_id' => $thread->id))) ?>">
&larr; Back to Thread </a>
