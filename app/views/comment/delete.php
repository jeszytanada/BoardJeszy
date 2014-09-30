<h2>
    Delete: <?php entities($comment->username) ?><?php entities($comment->body) ?>
</h2>

<!--FORM to Delete-->
<form id = "back" method = "post" action = "<?php entities(url(''))?>">
        <div align = "center"><font size = "4">
            <br />
            <input type = "hidden" name = "page_next" value = "delete_end"><br />
            <input type = "hidden" name = "comment_id" value = "<?php entities($comment->id) ?>">
            <input type = "hidden" name = "username" value = "<?php entities($comment->username) ?>">

            <button type = "submit" class = "btn btn-success" name = "reply" value = "yes"> Yes </button>
            <button type = "submit" class = "btn btn-danger" name = "reply" value = "no"> No </button>  
            <br /><br /><br /><br /><br /> 
        </div>
</form>