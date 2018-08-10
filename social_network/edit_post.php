<?php
session_start();
include("includes/connection.php");
include("functions/function.php");
?>

<?php
 if(!isset($_SESSION['user_email'])){
   header("location: index.php");
 }
 else { ?>
<html>
 <head>
     <title> Welcome Users </title>
     <link rel="stylesheet" type="text/css" href="styles/home_style.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
 </head>
 <body>
   <div class="container">
     <div id="head_wrap">
       <div id="header">
           <ul id="menu">
             <li><a class="fa fa-user" href="profile.php">&nbsp Profile</a></li>
             <li><a class="fa fa-home" href="home.php">&nbsp Home</a></li>
             <li><a class="fa fa-user-plus" href="members.php">&nbsp Find People</a></li>
             <li><a class="fa fa-envelope" href="my_messages.php?inbox">&nbsp Inbox</a></li>
             <li><a class="fa fa-paper-plane" href="my_messages.php?sent">&nbsp Sent Messagess</a></li>
           </ul>
           <form method="post" action="results.php" id="form1">
             <input type="text" name="user_query" placeholder="Search">
             <input type="submit" name="search" value="Search">
           </form>
       </div>
     </div>
       <div class="content">
         <div id="user_timeline">
           <div id="user_details">
             <?php
               $user = $_SESSION['user_email'];
               $get_user = "select * from users where user_email='$user'";
               $run_user = mysqli_query($conn,$get_user);
               $row = mysqli_fetch_array($run_user);

               $user_id = $row['user_id'];
               $user_name = $row['user_name'];
               $describe_user = $row['describe_user'];
               $user_image = $row['user_image'];

               // vo posts gi imame brojot na postovi na eden user
               $user_posts = "select * from posts where user_id='$user_id'";
               $run_posts = mysqli_query($conn,$user_posts);
               $posts = mysqli_num_rows($run_posts);

               //geting the number of unread Messages
               $sel_msg = "select * from messages where receiver='$user_id' and status='unread' order by 1 desc";
               $run_msg = mysqli_query($conn,$sel_msg);
               $count_msg = mysqli_num_rows($run_msg);

               echo "
                   <center>
                     <img src='users/$user_image' width='200' height='200'/>
                   </center>
                   <div id='user_mention'>
                     <p><center><h2>$user_name</h2></center>
                     <center><strong>$describe_user</strong></center></p>

                     <p class='fa fa-group'>&nbsp<a href='my_messages.php?inbox&u_id=$user_id'>Messages ($count_msg)</a></p>
                     <p class='fa fa-user-o'>&nbsp<a href='my_post.php?u_id=$user_id'>My Posts ($posts)</a></p>
                     <p class='fa fa-paint-brush'>&nbsp<a href='edit_profile.php?u_id=$user_id'>Edit Account</a></p>
                     <p class='fa fa-mouse-pointer'>&nbsp<a href='logout.php'>Logout</a></p>
                   </div>
               ";
              ?>
           </div>
         </div>
         <div id="content_timeline">
           <?php
            if (isset($_GET['post_id'])) {
              // code...
              $get_id = $_GET['post_id'];

              $get_post = "select * from posts where post_id='$get_id'";
              $run_post = mysqli_query($conn,$get_post);

              $row = mysqli_fetch_array($run_post);
            // gi predavame vrednostite na postot na lokalni promenlivi
              $post_con = $row['post_content'];

              }
            ?>

            <form id="f" action="" method="post">
              <center><h2> Edit Your Post </h2></center>
              <textarea name="content" rows="4" cols="83"><?php echo $post_con; ?></textarea>
              <input type="submit" name="update" value="Update Post">
            </form>

            <?php
                if (isset($_POST['update'])) {
                  // code...
                  $content = $_POST['content'];

                  $update_post = "update posts set post_content='$content' where post_id='$get_id'";
                  $run_update = mysqli_query($conn,$update_post);

                  if ($run_update) {
                    // code...
                    echo "<script>alert('Post has been Updated')</script>";
                    echo "<script>window.open('home.php','_self')</script>";
                  }
                }
            ?>
         </div>
       </div>
   </div>
 </body>
</html>
<?php } ?>
