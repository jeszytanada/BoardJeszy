<head>
    <style>
        #container {
           width:800px;
        }
        #center {
           text-align: center;
        }
        #box {
            background-color: #b0c4de;
            padding: 25px;
            border: 25px white;
        }
    </style>
</head>

<div style = "float: right; width: 185px; height: 10px; margin: -70px" >
    <a class = "btn btn-primary pull-right" href = "<?php entities(url('thread/logout'))?>" name = "logout"> Logout </a>
</div>

<div id = "container">
        <h1>
            <div style = "color:#0080FF"> Hi! <?php entities($_SESSION['username']);?>
            </div><br /> Threads 
        </h1>
    </div><br />

<!--Link of the threads-->
    <ul> 
        <?php foreach ($threads as $v): ?>
            <li><div class = "well" id = "box"><a href = "<?php entities(url('comment/view',array('thread_id'=> $v->id))) ?>">
                <?php entities($v->title) ?></a>
                </div>
            </li>
        <?php endforeach ?>
    </ul>

    <div id = "center">
        <a class = "btn btn-large btn-primary" href = "<?php entities(url('thread/create'))?>"> Create </a><br />
    </div>

    <!--Call out or display pagination (page numbers)-->
    <div id = "center" >
        <?php echo $pagination['paginationCtrls'];?>
    </div>  
</div>
