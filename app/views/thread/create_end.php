<h2>
    <?php entities($thread->title) ?>
</h2>

<p class = "alert alert-success"> Thread Successfully created!
</p>

<a href = "<?php entities(url('comment/view', array('thread_id' => $thread->id))) ?>">
&larr; Back to Threads </a>