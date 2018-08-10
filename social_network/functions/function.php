<?php
	$conn = mysqli_connect("localhost","root","","social_media");
            // Check connection
            if (mysqli_connect_errno())
            {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            }
            // MySqli connection ends here

  function insertPost(){
    if(isset($_POST['sub'])){
      global $conn;
      global $user_id;
      $content = addslashes($_POST['content']);

      if($content == ''){
        echo "<h2>Please Enter your Post</h2>";
        exit();
      }else {
        $insert = "insert into posts (user_id,post_content,post_date)
        value('$user_id','$content',NOW())";
        $run = mysqli_query($conn,$insert);

        if($run){
          echo "<script>alert('Your Post has been updated Succesfully')</script>";
          $update = "update users set posts='yes' where user_id='$user_id'";
          $run_update = mysqli_query($conn,$update);
        }
      }
    }
  }

// this function display the posts only 4 in one page and also pagination is included
  function get_posts(){
    global $conn;
		$per_page = 4;

  if(isset($_GET['page'])){
    $page = $_GET['page'];
  }else {
    $page = 1;
  }
  $start_from = ($page-1) * $per_page;
  $get_posts = "select * from posts ORDER by 1 DESC LIMIT $start_from,$per_page";
  $run_posts = mysqli_query($conn,$get_posts);

  while($row_posts=mysqli_fetch_array($run_posts)){
    $post_id = $row_posts['post_id'];
    $user_id = $row_posts['user_id'];
    $content = substr($row_posts['post_content'],0,70);
    $post_date = $row_posts['post_date'];

    // userot so postiral
    $user = "select * from users where user_id='$user_id' and posts='yes'";
    $run_user = mysqli_query($conn,$user);
    $row_user = mysqli_fetch_array($run_user);

    $user_name = $row_user['user_name'];
    $user_image = $row_user['user_image'];

    //displaying all at once

    echo "
      <div id='posts'>
        <p><img src='users/$user_image' width='80' height='80'></p>
        <h3><a href='user_profile.php?u_id=$user_id'>$user_name </a>&nbsp<small style='color:black;'>Updated post on $post_date</small></h3>
        <p style='color:white;'>$content</p>
        <a href='single.php?post_id=$post_id' style='float:right;'><button class='fa fa-comment'>&nbspComment</button></a>
      </div><br><br>
    ";
  }
	  include("pagination.php");
}

	function single_post(){
		if(isset($_GET['post_id'])){
			global $conn;

			$get_id = $_GET['post_id'];
			$get_posts = "select * from posts where post_id='$get_id'";
			$run_posts = mysqli_query($conn,$get_posts);
			$row_post = mysqli_fetch_array($run_posts);

			$post_id = $row_post['post_id'];
			$user_id = $row_post['user_id'];
			$content = $row_post['post_content'];
			$post_date = $row_post['post_date'];

			// da go zememe userot sto postiral
			$user = "select * from users where user_id='$user_id' and posts='yes'";
			$run_user = mysqli_query($conn,$user);
			$row_user = mysqli_fetch_array($run_user);

			$user_name = $row_user['user_name'];
			$user_image = $row_user['user_image'];

			// getting user email by using session
			$user_com = $_SESSION['user_email'];

			$get_com = "select * from users where user_email='$user_com'";
			$run_com = mysqli_query($conn,$get_com);
			$row_com = mysqli_fetch_array($run_com);

			$user_com_id = $row_com['user_id'];
			$user_com_name = $row_com['user_name'];

			//displaying all data

			echo "
					<div id='posts'>
						<p><img src='users/$user_image' width='80' height='80'></p>
						<h3><a href='user_profile.php?user_id=$user_id'>$user_name</a></h3>
						<p>Posted On :$post_date</p>
						<p>$content</p>
					</div>
			";



			include("comments.php");

			echo "
					<br>
					<form id='reply' method='post'>
					  <textarea cols='50' rows='5' name='comment' placeholder='Comment......'></textarea><br>
						<input type='submit' name='reply' value='Comment'>
					</form>
			";

				if (isset($_POST['reply'])) {
					// code...
					$comment = $_POST['comment'];

					$insert = "insert into comments (post_id,user_id,comment,comment_author,date)
					values('$post_id','$user_id','$comment','$user_com_name',NOW())";

					$run = mysqli_query($conn,$insert);

					echo "<script>alert('Your reply is Added!!')</script>";
					echo "<script>window.open('single.php?post_id=$post_id','_self')</script>";

				}

		}
	}

	function find_people(){
		global $conn;

		//select all the users
		$user = "select * from users";
		$run_user = mysqli_query($conn,$user);

		while ($row_user=mysqli_fetch_array($run_user)) {
			// code...
			$user_id = $row_user['user_id'];
			$user_name = $row_user['user_name'];
			$user_image = $row_user['user_image'];

			echo "
					<span>
						<a href='user_profile.php?u_id=$user_id'><hr>
						<strong><h2>$user_name</h2></strong>
						<img src='users/$user_image' width='150px' height='140px' title='$user_name' style='float:left; margin:1px;'/>
						<br><br><br><br><br><br><br><br><br><br>
						</a>
					</span>
			";
		}

	}

	function user_posts(){
		global $conn;

		if (isset($_GET['u_id'])) {
			// code...
			$u_id = $_GET['u_id'];
		}
		$get_posts = "select * from posts where user_id='$u_id' ORDER by 1 DESC LIMIT 5";
		$run_posts = mysqli_query($conn,$get_posts);

		while ($row_posts=mysqli_fetch_array($run_posts)) {
			// code...
			$post_id = $row_posts['post_id'];
			$user_id = $row_posts['user_id'];
			$content = $row_posts['post_content'];
			$post_date = $row_posts['post_date'];

			//getting the user who posted
			$user = "select * from users where user_id='$user_id' and posts='yes'";
			$run_user = mysqli_query($conn,$user);
			$row_user = mysqli_fetch_array($run_user);

			$user_name = $row_user['user_name'];
			$user_image = $row_user['user_image'];

			// display all user post
			echo "
				<div id='posts'>
					<p><img src='users/$user_image' width='50' height='50'></p>
					<h3><a href='user_profile.php?user_id=$user_id'>$user_name</a></h3>
					<p>$post_date</p>
					<p>$content</p>
					<a href='single.php?post_id=$post_id' style='float:right;'><button class='fa fa-address book'>&nbspView</button>
					<a href='edit_post.php?post_id=$post_id' style='float:right;'><button class='fa fa-edit'>&nbspEdit</button>
						<a href='functions/delete_post.php?post_id=$post_id' style='float:right;'><button class='fa fa-trash-o'>&nbspDelete</button></a>
				</div><br>
			";

			include("delete_post.php");
		}
	}

	function user_profile(){

		if (isset($_GET['u_id'])) {
			// code...
			global $conn;

			$user_id = $_GET['u_id'];

			$select = "select * from users where user_id='$user_id'";
			$run = mysqli_query($conn,$select);
			$row = mysqli_fetch_array($run);

			$id = $row['user_id'];
			$name = $row['user_name'];
			$describe_user = $row['describe_user'];
			$country = $row['user_country'];
			$image = $row['user_image'];
			$register_date = $row['user_reg_date'];
			$gender = $row['user_gender'];

		if ($gender == "Male") {
			// code...
			$msg='Send him a message';
		}else {
			$msg="Send her a message";
		}

		echo "
			<div id='user_profile'>
				<img src='users/$image' width='150' height='150'><br/>
				<p><strong>Name: </strong> $name</p><br/>
				<p><strong>Gender: </strong> $gender</p><br/>
				<p><strong>Country: </strong> $country</p><br/>
				<p><strong>Gender: </strong> $gender</p><br/>
				<p><strong>Status: </strong> $describe_user</p><br/>
				<p><strong>Member: </strong> $register_date</p>
				<a href='messages.php?u_id=$id'><button>$msg</button></a><hr>

			</div>
		";

		}
	}
?>
