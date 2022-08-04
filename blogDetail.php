<?php
session_start();
require "config/config.php";

if(empty($_SESSION["user_id"]) && empty($_SESSION['logged_in']))  {
  header("Location:login.php");
}

// echo $_SESSION["user_id"];
// exit();

$blogId = $_GET["id"];
$stmt = $pdo -> prepare("SELECT * FROM posts WHERE id=$blogId");
$stmt -> execute();
$result = $stmt -> fetchAll();
// echo $result[0]["title"];

$authorId = $result[0]["author_id"];
$stmtau = $pdo -> prepare("SELECT * FROM users WHERE id=$authorId");
$stmtau -> execute();
$auResult = $stmtau -> fetchAll();

if($_POST) {
  $comment = $_POST["comment"];
  $stmt = $pdo -> prepare("INSERT INTO comments(content, author_id, post_id)VALUES(:content, :author_id, :post_id)");

  $result = $stmt -> execute(
    array(":content" => $comment, ":author_id" => $_SESSION['user_id'], ":post_id" => $blogId)
);
if ($result) {
    header("Location:blogDetail.php?id=".$blogId);
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
  <!-- Content Wrapper. Contains page content -->
  <div class="">

    <!-- Main content -->
    <section class="content">
    <div class="row">
      <div class="col-md-12">
        <!-- Box Comment -->
        <div class="card">
          <div class="card-header text-center">
            <h4><?php echo $result[0]["title"]; ?></h4>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <!-- <img class="img-thumbnail w-100 mb-4" src="dist/img/photo2.png" alt="Photo"> -->
            <img class="img-thumbnail w-100 h-50 d-block m-auto" style="height: 400px;" src="admin/images/<?php echo $result[0]['image']; ?>" alt="blog">
            <?php echo $result[0]["content"]; ?>
          </div>

          <h3 class="ml-4">Comments</h3><hr>
          <div class="mx-3 mb-3">
          <a href="index.php" type='button' class="btn btn-default">Go Back</a>
          </div>
          <!-- /.card-body -->
          <div class="card-footer card-comments">
            <!-- /.card-comment -->
            <div class="card-comment">
              <!-- User image -->
              <div class="">
                <span class="username">
                  <?php echo $auResult[0]["name"] ; ?>
                  <span class="text-muted float-right">8:03 PM Today</span>
                </span><!-- /.username -->
                It is a long established fact that a reader will be distracted
                by the readable content of a page when looking at its layout.
              </div>
              <!-- /.comment-text -->
            </div>
            <!-- /.card-comment -->
          </div>
          <!-- /.card-footer -->
          <div class="card-footer">
            <form action="" method="post">
              <!-- .img-push is used to add margin to elements next to floating images -->
              <div class="img-push">
                <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter to post comment">
              </div>
            </form>
          </div>
          <!-- /.card-footer -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    </section>
    <!-- /.content -->
    <a id="back-to-top" href="#" class="btn btn-primary mb-5 back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

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
