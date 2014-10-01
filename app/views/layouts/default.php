<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DietCakeTanada</title>

    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bootstrap/css/style.css" rel="stylesheet">
    <style>
      body {
        padding-top: 120px;
      }
    </style>
  </head>

  <body>

    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" >DietCake Board Exercise M.Tanada</a>
          <a class="brand pull-right" href="<?php entities(url('login/update'))?>">Profile</a>
        </div>
      </div>
    </div>
    <div class="container">

      <?php echo $_content_ ?>

    </div>

    <script>
    console.log(<?php entities(round(microtime(true) - TIME_START, 3)) ?> + 'sec');
    </script>

  </body>
</html>
