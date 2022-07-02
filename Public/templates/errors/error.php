<!doctype html>
<html lang="ru">
<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="/Public/css/bootstrap.min.css">
  <link rel="stylesheet" href="/Public/css/bootstrap-utilities.css">
  <link rel="stylesheet" href="/Public/css/style.css">
  <title>Ошибочка</title>
</head>
<body>

<div class="content">
  <div class="container">
    <h1><?php echo $error; ?></h1>
      <p><?php echo $description ?? ''; ?></p>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4"
        crossorigin="anonymous"></script>

</body>
</html>
