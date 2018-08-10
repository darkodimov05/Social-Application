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
               $Relationship_status = $row['relationship'];
               $user_pass = $row['user_pass'];
               $user_email = $row['user_email'];
               $user_country = $row['user_country'];
               $user_gender = $row['user_gender'];
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
           <form id="f" method="post" class="ff" enctype="multipart/form-data">
             <table>

               <tr align="center">
                 <td colspan="6"><h2>Edit Your Profile</h2></td>
               </tr>

               <tr>
                 <td align="right">Name:</td>
                 <td>
                    <input type="text" name="u_name" value="<?php echo $user_name; ?>" required="required"/>
                 </td>
               </tr>

               <tr>
                 <td align="right">Description:</td>
                 <td>
                    <input type="text" name="describe_user" value="<?php echo $describe_user; ?>" required="required"/>
                 </td>
               </tr>

               <tr>
                 <td align="right">Relationship Status:</td>
                 <td>
                   <select name="Relationship">
                     <option ><?php echo $Relationship_status; ?></option>
                     <option>Engaged</option>
                     <option>Married</option>
                     <option>Single</option>
                     <option>In a relationship</option>
                     <option>It's complicated </option>
                     <option>Separated</option>
                     <option>Divorced</option>
                     <option>Engaged</option>
                     <option>Widowed</option>
                   </select>
                 </td>
               </tr>

               <tr>
                 <td align="right">Password:</td>
                 <td>
                  <input type="password" name="u_pass" id="mypass" required="
                  required" value="<?php echo $user_pass; ?>">
                  <input type="checkbox" onclick="show()">Show Password
                 </td>
               </tr>

               <tr>
                 <td align="right">Email:</td>
                 <td>
                  <input type="email" name="u_email"  required="
                  required" value="<?php echo $user_email; ?>">
                 </td>
               </tr>

               <tr>
                 <td align="right">Country:</td>
                 <td>
                  <select name="u_country" disabled="disabled">
                    <option><?php echo $user_country; ?></option>
                    <option>USA</option>
                    <option>UK</option>
                    <option>Macedonia</option>
                    <option>Sweden</option>
                    <option>Norway</option>
                    <option>Serbia</option>
                  </select>
                 </td>
               </tr>

               <tr>
                 <td align="right">Gender:</td>
                 <td>
                  <select name="u_gender" disabled="disabled">
                    <option><?php echo $user_gender; ?></option>
                    <option>Male</option>
                    <option>Female</option>
                  </select>
                 </td>
               </tr>

               <tr align="center">
                 <td colspan="6">
                  <input style="width:100px;" type="submit" name="update" value="Update">
                 </td>
               </tr>

             </table>
           </form>

           <?php
              if (isset($_POST['update'])) {
                // code...
                $u_name = $_POST['u_name'];
                $describe_user = $_POST['describe_user'];
                $Relationship_status = $_POST['Relationship'];
                $u_pass = $_POST['u_pass'];
                $u_email = $_POST['u_email'];

                $update = "update users set user_name='$u_name',describe_user='$describe_user',relationship='$Relationship_status',user_pass='$u_pass',user_email='$u_email'
                where user_id='$user_id'";

                $run = mysqli_query($conn,$update);

                if ($run) {
                  // code...
                  echo "<script>alert('Your Profile is Updated')</script>";
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

<script>
  function show(){
    var x = document.getElementById("mypass");
    if (x.type === "password") {
      x.type = "text";
    }else {
      x.type = "password";
    }
  }
</script>
