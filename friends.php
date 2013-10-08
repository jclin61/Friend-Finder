<?php
	session_start();

	if(!isset($_SESSION['logged_in']))
	{
		header("Location: index.php");
	}
?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>My Friends</title>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
	<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script>
		$(document).ready(function(){
			// $(".add_action").click(function(){
				
			// $(document).on('click','.add_action',function(){

				$(".add_action").children(".add").submit(function(){
					var addfriend=$(this);
					$.post(addfriend.attr('action')
						,addfriend.serialize()
						,function(data)
						{
							addfriend.parent(".add_action").html(data.friends);
							$("#friend_list").html(data.friend_list);
						}, "json");
					return false;
				});
			// });

		});
	</script>
</head>
<body>
	
<h5>Welcome , <?= $_SESSION['user']['first_name'] ."! " . "<br>" . " " . $_SESSION['user']['email']  ?>! <a href="process.php">Log Off</a></h5>

<div id="friends">
<h4>List of Friends</h4>
	<table border="1px">
		<thead>
			<th>Name</th>
			<th>Email</th>
		</thead>
		<tbody id="friend_list">
<?php
		$myfriends=$_SESSION['myfriend']; 
		$id="";
		foreach($myfriends as $myfriend)
		{
			$id .=$myfriend['id']." ";
			echo"<tr>
					<td>{$myfriend['name']}</td>
					<td>{$myfriend['email']}</td>
				<tr>";
		}
		$friend_ids = explode(" ",$id);
?>
		</tbody>
	<table>
</div>

<div id="users">
	<h4>List of Users who surbscribed to Friend Finder:</h4>
<?php
	$allusers = $_SESSION['allusers'];
?>
	<table border= "1px" >
		<thead>
			<th>Name</th>
			<th>Email</th>
			<th>Action</th>
		</thead>
<?php foreach ($allusers as $alluser) 
		{
		echo "<tbody>
				<tr>
			    	<td>{$alluser['name']}</td>
			    	<td>{$alluser['email']}</td>
					<td class='add_action'>";	
			
			if(count(array_intersect($friend_ids, $alluser)) > 0)
			{
				echo "Friends";
				
			}
			else
			{
				echo"
				<form class='add' action='process.php' method='post'>
					<input type='hidden' name='addfriend' value='{$alluser['id']}'>
					<input type='submit' value='Add as Friend'>
				</form>";
			}
					echo "</td>
					</tr>
				</tbody>";
			}	
		
				
		
?>					
		
	</table>	
</div>



</body>
</html>