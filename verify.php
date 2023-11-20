<!DOCTYPE html>
<html lang="en">


<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>verify_password</title>
</head>
</script>


<body>
	<script type="text/javascript" color="255,192,202" opacity='0.7' zIndex="-2" count="150" src="js/canvas-next.min.js"></script>

	<?php
	date_default_timezone_set("Asia/Shanghai");
	$connect = mysqli_connect("localhost", "root", "wpj408123.", "users");
	mysqli_set_charset($connect, "utf8");


	$getName = htmlspecialchars($_POST["username"]);
	$getPassword = htmlspecialchars($_POST["password"]);

	$select = "select uname,upasswd from user_info where uname='$getName'";
	$result = mysqli_query($connect, $select);
	$object = mysqli_fetch_object($result);
	$hash = $object->upasswd;

	if (password_verify($getPassword, $hash)) {
		date_default_timezone_set("Asia/Shanghai");
		session_start();
		$_SESSION['lsp'] = $getName;
		setcookie("$getName", "$session_id()", time() + 3600 * 24);
		echo "<script>window.location.href='http://yourk.top/loveSpace/love.html';</script>";
	} else {
		echo "<script>alert('账号或密码错误');window.location.href='https://yourk.top/loveSpace/login.html';</script>";
	} ?>
</body>

</html>