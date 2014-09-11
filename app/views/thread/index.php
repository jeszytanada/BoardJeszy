<style>
#container {
    width:100px;
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

<div style="float: right; width: 185px; height: 10px; margin: -70px" >
<a class="btn btn-primary pull-right" href="<?php eh(url('thread/logout'))?>" name="logout">Logout</a>
</div>


<div id="container">
<h1>Threads </h1></div><br /> <br />
<!--Link of the threads-->
<ul> 
<?php foreach($threads as $v): ?>
<li> <div class="well" id="box">	
<a href="<?php eh(url('thread/view',array('thread_id'=> $v->id))) ?>">
<?php eh($v->title) ?></a>
</li>
<?php endforeach ?>
</ul></div>
<div id="center">
<a class="btn btn-large btn-primary" href="<?php eh(url('thread/create'))?>">Create</a> </div>
<!--Call out or display pagination (page numbers)-->
<br />
<div id="center" >
<?php echo $pagination['paginationCtrls'];?> </div>
</div>
