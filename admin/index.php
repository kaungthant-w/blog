<?php
session_start();
require("../config/config.php");

if(empty($_SESSION["user_id"]) && empty($_SESSION['logged_in'])) {
  header("Location:login.php");
}

include "header.php";

?>


    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Blog Listing</h3>
              </div>
              
              <?php
                $stmt = $pdo -> prepare("SELECT * FROM posts ORDER BY id DESC");
                $stmt -> execute();
                $result = $stmt -> fetchAll();
                
                // print_r($result);
                ?>
              <!-- /.card-header -->
              <div class="card-body">
                <a href="add.php" class="btn btn-success mb-3">New Blog Post</a>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Content</th>
                      <th style="width: 40px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php

                      if ($result) {

                        $i = 1;
                        foreach($result as $value ) { ?>

                    <tr>
                      <td><?php echo $i; ?></td>
                      <td><?php echo $value["title"]; ?></td>
                      <td>
                      <?php echo substr($value["content"],0,50); ?>
                      </td>
                      <td>
                        <div class="btn-group">
                          <a href="edit.php?id=<?php echo $value['id'] ?>" class="btn btn-warning">Edit</a>
                          <a href="delete.php?id=<?php echo $value['id'] ?>"
                          onclick="return confirm('Are you sure you want to delete this item')"
                           class="btn btn-danger">Delete</a>
                        </div>
                      </td>
                    </tr>

                      <?php
                      $i++;
                        }
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <!-- <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
              </div> -->
            </div>
            <!-- /.card -->
          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->
<?php
include "footer.php";
?>