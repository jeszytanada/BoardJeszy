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
 
<h1>
    <?php entities($thread->title) ?>
</h1>

<?php foreach ($comments as $k => $v): ?>
    <div class = "comment">
        <div class = "meta">
            <h4>
                <?php entities($v->username) ?><br/><?php entities($v->created) ?>
            </h4>
        </div>
        <div class = "well" id = "box" ><?php echo "Comment: "; entities($v->body) ?>
        </div>
    </div>
<?php endforeach ?>

<!--Form for new Comment -->
<hr>
    <div id = "box">
        <form class = "well" method = "post" action = "<?php entities(url('thread/write')) ?>">
            <div style = "color:#0080FF"><?php echo $_SESSION['username'] ?></div><br />
            <label> Comment: </label>
            <textarea name = "body" class = "span8"><?php entities(Param::get('body')) ?></textarea><br />
            <input type = "hidden" name = "thread_id" value = "<?php entities($thread->id) ?>">
            <input type = "hidden" name = "page_next" value = "write_end">
            <button type = "submit" class = "btn btn-primary"> Submit </button>
        </form>
    </div>
</hr><br />

<!--To display or echo out the recent / latest comment inside the thread-->
<div class = "well" id = "box">
    <?php entities($v->username) ?><?php echo ": <br> ";  echo readable_text($v->body) ?>
</div>

<div id = "center">
    <a class = "btn btn-primary" href = "<?php entities(url('thread/index'))?>"> Back to Threads </a>
</div> 