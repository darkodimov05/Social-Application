<?php

$conn = mysqli_connect("localhost","root","","social_media");
          // Check connection
          if (mysqli_connect_errno())
          {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }
          // MySqli connection ends here

          if (isset($_GET['post_id'])) {
            // code...
            $post_id = $_GET['post_id'];

            $delete_post = "delete from posts where post_id='$post_id'";
            $run_delete = mysqli_query($conn,$delete_post);

            if ($run_delete) {
              // code...
              echo "<script>alert('Post has been deleted')</script>";
              echo "<script>window.open('../home.php','_self')</script>";
            }
          }

 ?>
