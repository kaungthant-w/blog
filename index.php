<?php
session_start();
require "config/config.php";

if(empty($_SESSION["user_id"]) && empty($_SESSION['logged_in']))  {
  header("Location:login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Blog</title>

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
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Blog Title</h1>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <?php
      

    ?>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php
          // pagination code start
          if(!empty($_GET['pageno'])) {
            $pageno = $_GET['pageno'];
          } else {
            $pageno = 1;
          }
          $numOfrecs = 6;
          $offset = ($pageno - 1) * $numOfrecs;
          $stmt = $pdo -> prepare("SELECT * FROM posts ORDER BY id DESC");
          $stmt -> execute();
          $rawResult = $stmt -> fetchAll();
          $total_pages = ceil(count($rawResult) / $numOfrecs);

          $stmt = $pdo -> prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs");
          $stmt -> execute();
          $rawResult = $stmt -> fetchAll();
          
          // pagination code end

          if ($rawResult) {
            $i = 1;
            foreach($rawResult as $value ) { ?>
              <div class="col-md-4">
                <!-- Box Comment -->
                <div class="card card-widget">
                  <div class="card-header">
                    <div class="user-title">
                      <h4 class="text-center"><?php echo $value['title']; ?></h4>
                    </div>
                  </div>
                  <!-- /.card-header -->
                  <div class="card-body">
                    <a href="blogDetail.php?id=<?php echo $value['id']; ?>"><img class="img-thumbnail w-100" style="height: 400px;" src="admin/images/<?php echo $value['image'] ?>" alt="blog"></a>
                  </div>
                </div>
                <!-- /.card -->
              </div>
          <?php
          $i++;
            }
          }
        ?>
      </div>

      <!-- pagination -->
  <div class="card-footer clearfix">
    <ul class="pagination pagination-sm m-0 float-right">
      <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
      <li class="page-item <?php if($pageno <= 1){echo "disabled";} ?>">
        <a class="page-link" href="<?php if($pageno <= 1 ){echo "#";}else{echo "?pageno=".($pageno-1);} ?>">Previous</a>
      </li>
      <li class="page-item"><a class="page-link" href="#"><?php echo $pageno; ?></a></li>
      <li class="page-item <?php if($pageno >= $total_pages){echo "disabled";} ?>">
        <a class="page-link" href="<?php if($pageno >= $total_pages){echo "#";}else{echo "?pageno=".($pageno+1);} ?>">Next</a>
      </li>
      <li class="page-item"><a class="page-link" href="?pageno=<?php echo $total_pages; ?>">Last</a></li>
    </ul>
  </div>

    </section>
    <!-- /.content -->

    <a id="back-to-top" href="#" class="btn btn-primary back-to-top" role="button" aria-label="Scroll to top">
      <i class="fas fa-chevron-up"></i>
    </a>
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="float-right d-none d-sm-block">
      <a href="logout.php" class="btn btn-default">Logout</a>
    </div>
    <strong>Copyright &copy; 2022 <a href="#">Aprogrammer</a>.</strong> All rights reserved.
  </footer>

</div>


<!-- ./wrapper -->

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
