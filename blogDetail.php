<?php
session_start();
require "config/config.php";

if(empty($_SESSION["user_id"]) && empty($_SESSION['logged_in']))  {
  header("Location:login.php");
}

// echo $_SESSION["user_id"];
// exit();

$stmt = $pdo -> prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt -> execute();
$result = $stmt -> fetchAll();
// echo $result[0]["title"];

$blogId = $_GET["id"];
$stmtmt = $pdo -> prepare("SELECT * FROM comments WHERE post_id=$blogId");
$stmtmt -> execute();
$cmResult = $stmtmt -> fetchAll();


$auResult = [];
if($cmResult) {
  foreach($cmResult as $key => $value) {
    $authorId = $cmResult[$key]["author_id"];
    $stmtau = $pdo -> prepare("SELECT * FROM users WHERE id=$authorId");
    $stmtau -> execute();
    $auResult[] = $stmtau -> fetchAll();
  }
}

// print_r($auResult[1]);

if($_POST) {
  if(empty($_POST["comment"])) {
    if(empty($_POST["comment"])) {
      $commentError = 'comment cannot be empty';
    }
    
  } else {
    $comment = $_POST["comment"];
    $stmt = $pdo -> prepare("INSERT INTO comments(content, author_id, post_id)VALUES(:content, :author_id, :post_id)");

    $result = $stmt -> execute(
        array(":content" => $comment, ":author_id" => $_SESSION['user_id'], ":post_id" => $blogId)
    );
    if ($result) {
        header("Location:blogDetail.php?id=".$blogId);
    }
  }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog Details</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="">
  <div class="">

    <section class="content">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header text-center">
            <h4><?php echo $result[0]["title"]; ?></h4>
          </div>
          <div class="card-body">
            <!-- <img class="img-thumbnail w-100 mb-4" src="dist/img/photo2.png" alt="Photo"> -->
            <img class="img-thumbnail w-100 h-50 d-block m-auto" style="height: 400px;" src="admin/images/<?php echo $result[0]['image']; ?>" alt="blog">
            <?php echo $result[0]["content"]; ?>
          </div>

          <h3 class="ml-4">Comments</h3><hr>
          <div class="mx-3 mb-3">
          <a href="index.php" type='button' class="btn btn-default">Go Back</a>
          </div>
          <div class="card-footer card-comments">
            <div class="card-comment">
              <?php if($cmResult){?>
                <div class="">
                  <?php foreach($cmResult as $key => $value){ ?>
                    <span class="username">
                      <?php echo $auResult[0][0]["name"]; ?>
                      <span class="text-muted float-right"><?php $value['created_at']; ?></span>
                    </span>
                    <?php echo $value['content']; ?>

                    <?php
                    }
                    ?>
                </div>
              <?php } ?>
            </div>
          </div>
          <div class="card-footer">
            <form action="" method="post">
            <p class="text-danger ml-3"><?php echo empty($commentError) ? '': "*".$commentError; ?></p>
              <div class="img-push">
                <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    </section>
    <a id="back-to-top" href="#" class="btn btn-primary mb-5 back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <footer class="p-2">
    <div class="float-right d-none d-sm-block">
      <b>Version</b> 3.2.0
    </div>
    <strong>Copyright &copy; 2022 <a href="#">Aprogrammer</a>.</strong> All rights reserved.
  </footer>

</div>

<!-- jQuery -->
<script src="plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
