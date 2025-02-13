<?php
@include "../config_connection.php";
	setcookie("admin", "", time() - 3600, '/');
    setcookie("rescuer", "", time() - 3600, '/');
    setcookie("civilian", "", time() - 3600, '/');		

	if($_SERVER["REQUEST_METHOD"] == "POST"){
	$username = mysqli_real_escape_string($conn, $_POST["username"]);
	$password = md5($_POST["password"]);

	$query = " SELECT * FROM user WHERE username = '$username' && password = '$password' ";
	$result = mysqli_query($conn, $query);

	if(mysqli_num_rows($result) > 0){
		$row = mysqli_fetch_array($result);

		if($row["role"] == "ADMIN"){
			$cookie_name = "admin";
			$cookie_value = $row["id"];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
			echo json_encode(['value' => true, 'message' => '/src/html/admin/map.html']);
		}elseif($row["role"] == "RESCUER"){
			$cookie_name = "rescuer";
			$cookie_value = $row["id"];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
			echo json_encode(['value' => true, 'message' => '/src/html/rescuer/map.html']);
		}elseif($row["role"] == "CIVILIAN"){
			$cookie_name = "civilian";
			$cookie_value = $row["id"];
			setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 86400 = 1 day
			echo json_encode(['value' => true, 'message' => '/src/html/civilian/announcements_list.html']);
		}
	}else{
		echo json_encode(['value' => false, 'message' => 'Incorrect Username or Password!']);
	}
};
