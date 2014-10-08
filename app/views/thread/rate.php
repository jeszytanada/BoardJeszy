<h2>
    Title: <?php entities($thread->title) ?>
</h2>

<!--FORM to Rate-->
<form id = "back" method = "post" action = "<?php entities(url(''))?>">
    <div class = "well" align = "center">
        <font size="4">
            <input type = "radio" name = "rating" value = "0" required>
                0<img src = "/bootstrap/img/star.jpg" height="30" width="30">
            <input type = "radio" name = "rating" value = "1" required>
                1<img src = "/bootstrap/img/star.jpg" height="30" width="30">
            <input type = "radio" name = "rating" value = "2" required>
                2<img src = "/bootstrap/img/star.jpg" height="30" width="30">
            <input type = "hidden" name = "page_next" value = "rate_end">
                <br /><br /><br />
            <button type = "submit" class = "btn btn-primary"> OK </button>
        </font>
    </div>
</form>