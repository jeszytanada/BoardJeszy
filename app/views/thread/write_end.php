<h2>
	<?php entities($thread->title) ?>
</h2>

<p class = "alert alert-success"> Comment Succcess!
</p>

<a href = "<?php entities(url('thread/view', array('thread_id' => $thread->id))) ?>">
&larr; Back to Thread </a>
