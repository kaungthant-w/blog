<?php
session_start();
require("../config/config.php");
require("../config/common.php");

if(empty($_SESSION["user_id"]) && empty($_SESSION['logged_in'])) {
  header("Location:login.php");
}

if($_SESSION["role"] != 1) {
  header("Location:login.php");
}

if($_POST) {

  // if (!hash_equals($_SESSION['_token'], $_POST['_token'])) die();
  if(empty($_POST["title"]) || empty($_POST["content"]) || empty($_FILES["image"])) {
    if(empty($_POST["title"])) {
      $titleError = 'Title cannot be empty';
    }
    if(empty($_POST["content"])) {
      $contentError = "Content cannot be empty";
    }

    if(empty($_FILES["image"])) {
      $imageError = "Image cannot be empty";
    }
  }else{
    $file = 'images/'.($_FILES['image']['name']);
    $imageType = pathinfo($file, PATHINFO_EXTENSION);

    if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
        echo "<script>alert('Image must be png, jpg, jpeg.')</script>";
    }else{
      $title = $_POST['title'];
      $content = $_POST['content'];
      $image = $_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'],$file);

      $stmt = $pdo->prepare("INSERT INTO posts(title,content,author_id,image) VALUES (:title,:content,:author_id,:image)");
      $result = $stmt->execute(
          array(':title'=>$title,':content'=>$content,':author_id'=>$_SESSION['user_id'],':image'=>$image)
      );
      if ($result) {
        echo "<script>alert('Successfully added');window.location.href='index.php';</script>";
      }
    }
  }
}

?>
<?php include "header.php"; ?>
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
              <form action="add.php" method="post" enctype="multipart/form-data">
              <input name="_token" type="hidden" value="<?php echo $_SESSION['_token']; ?>">
                <div class="form-group">
                    <label for="title">Title</label><span class="text-danger ml-3"><?php echo empty($titleError) ? '': "*".$titleError; ?></span>
                    <input type="text" name="title" id="title" class="form-control" >
                </div>

                <div class="form-group">
                    <label for="content">Content</label><span class="text-danger ml-3"><?php echo empty($contentError) ? '': "*".$contentError; ?></span>
                    <textarea name="content" class="form-control" id="content" cols="10" rows="10"></textarea>
                </div>

                <div class="form-group">
                    <label for="">Image</label><span class="text-danger ml-3"><?php echo empty($imageError) ? '': "*".$imageError; ?></span>
                    <input type="file" name="image" class="form-control" value="" >
                </div>

                <div class="form-group">
                    <input type="submit" class="btn btn-success" name="" value="Submit">
                    <a href="index.php" class="btn btn-warning">Back</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  <aside class="control-sidebar control-sidebar-dark">
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
<?php
include "footer.php";
?>