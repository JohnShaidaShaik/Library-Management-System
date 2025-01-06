<?php
	$connection = mysqli_connect("localhost","root","");
	$db = mysqli_select_db($connection,"ims");
	$query = "delete from users where id = $_GET[aid]";
	$query_run = mysqli_query($connection,$query);
?>
<script type="text/javascript">
	alert("User Deleted successfully...");
	window.location.href = "manage_user.php";
</script>