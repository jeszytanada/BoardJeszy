<h2>
    Delete: by <?php entities($comment->username) ?><br />
    <div class = meta>
        <font size = "4px">"<?php entities($comment->body) ?>"</font>
    </div>
</h2>

<!--FORM to Delete-->
<form id = "back" method = "post" action = "<?php entities(url(''))?>">
     <div align = "center"><font size = "4">
        <br />
        <input type = "hidden" name = "page_next" value = "delete_end"><br />
        <button type = "submit" class = "btn btn-success" name = "reply" value = "yes"> Yes </button>
        <button type = "submit" class = "btn btn-danger" name = "reply" value = "no"> No </button>  
        <br /><br /><br /><br /><br /> 
    </div>
    <?php echo $position ?>
</form>