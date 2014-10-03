<div style = "float: right; width: 185px; height: 10px; margin: -70px" >
    <a class = "btn btn-primary pull-right" href = "<?php entities(url('login/logout'))?>" name = "logout"> Logout </a>
</div>

<div id = "container">
    <h1>
        <div style = "color:#0080FF"> Hello <?php entities($_SESSION['username']);?> !
        </div><br /> 
        Freedom Board <br />      
    </h1>
</div>

<!--Link of the threads-->
<ul> 
    <?php foreach ($threads as $v): ?>
        <li>
            <div class = "well" style="font-family:Sans Serif">
                <a href = "<?php entities(url('comment/view',array('thread_id'=> $v->id))) ?>">
                    <?php entities($v->title) ?>
                </a>
                <div align = "right">
                    <?php echo $v->rating; ?><img src = "/bootstrap/img/star.jpg" height="35" width="35">
                    <a href = "<?php entities(url('thread/rate', array('thread_id'=> $v->id)))?>" class = "btn-primary"> Rate this!</a>
                    <a href="<?php entities(url('thread/delete', array('thread_id'=> $v->id)))?>">
                        <i class = "icon-trash"></i>
                    </a>
                    <a href="<?php entities(url('thread/update', array('thread_id'=> $v->id)))?>">
                        <i class = "icon-pencil"></i>
                    </a>     
                </div>
            </div>
        </li>
    <?php endforeach ?>
</ul>
<input type = "hidden" name = "thread_id" value = "<?php entities($thread->id) ?>">
<div style = "text-align: center">
    <a class = "btn btn-large btn-primary" href = "<?php entities(url('thread/create'))?>"> Create </a><br />
</div>

<!--Call out or display pagination (page numbers)-->
<div style = "text-align: center"> <br />
    <?php echo $pagination_links['paginationCtrls'];?>
</div>  
