<h2>
	<?php entities($thread->title) ?>
</h2>

<p class = "alert alert-success"> Thread Successfully created!
</p>

<a href = "<?php entities(url('thread/view', array('thread_id' => $thread->id))) ?>">
&larr; Go to Thread </a>	
