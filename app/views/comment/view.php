<<<<<<< HEAD
<h1>
    <?php entities($thread->title) ?>
</h1>

<?php foreach ($comments as $k => $v): ?>
    <div id = "container">
        <div class = "meta">
            <h4>
                <?php entities($v->username) ?><br/><?php entities($v->created) ?>
            </h4>
        </div>
        <div class = "well" style = "width: 900px"><?php echo "Comment: "; entities($v->body) ?>
        </div>
=======
<h1> <div class = "well">
    <?php entities($thread->title) ?>
</h1>   </div>

<?php foreach ($comments as $k => $v): ?>
    <div id = "pad">
        <div class = "meta">
            <h4>
                <?php entities($v->username) ?>
                <div style = "text-align: right"><?php entities($v->created) ?>
                    <a href="<?php entities(url('comment/delete', array('comment_id'=> $v->id)))?>">
                        <i class = "icon-trash"></i>
                    </a>
                </div>
            </h4> 
        </div>
        <div class = "well" style = "width: 900px"><?php echo entities($v->body) ?></div>
>>>>>>> issue6
    </div>
<?php endforeach ?>

<!--Form for new Comment -->
<hr>
<<<<<<< HEAD
    <div>
        <form class = "well" method = "post" action = "<?php entities(url('comment/write')) ?>">
            <div style = "color:#0080FF"><?php echo $_SESSION['username'] ?></div><br />
            <label> Comment: </label>
=======
    <div id = "pad">
        <form class = "meta" method = "post" action = "<?php entities(url('comment/write')) ?>">
            <div style = "color:#0080FF">
                <?php echo entities($_SESSION['username']) ?>
            </div><br />
            <label> Post a reply: </label>
>>>>>>> issue6
            <textarea name = "body" class = "span10" style = "height: 250px"><?php entities(Param::get('body')) ?></textarea><br />
            <input type = "hidden" name = "thread_id" value = "<?php entities($thread->id) ?>">
            <input type = "hidden" name = "page_next" value = "write_end">
            <button type = "submit" class = "btn btn-primary"> Submit </button>
        </form>
    </div>
</hr><br />

<<<<<<< HEAD
<!--To display or echo out the recent / latest comment inside the thread-->
<div class = "well" id = "container" style = "width: 900px">
    <?php entities($v->username) ?><?php echo ": <br> ";  echo readable_text($v->body) ?>
</div>

<div style = "text-align: center">
    <a class = "btn btn-primary" href = "<?php entities(url('thread/index'))?>"> Back to Threads </a>
</div> 
=======
<div style = "text-align: center">
    <a class = "btn btn-primary" href = "<?php entities(url('thread/index'))?>"> Back to Threads 
    </a>
</div> 
>>>>>>> issue6
