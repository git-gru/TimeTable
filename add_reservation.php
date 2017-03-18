<?php 
	require('db_connect.php');

	$user_id = $_POST['user_id'];
	$room_id = $_POST['room_id'];
	$weekday = $_POST['weekday'];
	$time = $_POST['time'];

	$sql = "
		CREATE TABLE IF NOT EXISTS `timetable`.`reservation`
		(
			id int NOT NULL AUTO_INCREMENT,
			user_id int NOT NULL,
			room_id int NOT NULL,
			weekday varchar(255) NOT NULL,
			time varchar(255) NOT NULL,
			PRIMARY KEY (ID)
		);
	";

	if ($conn->query($sql) != FALSE) {
		$sql = "
			SELECT * FROM `timetable`.`reservation` WHERE room_id = '$room_id' AND weekday = '$weekday' AND time = '$time';
		";
		$result1 = $conn->query($sql);

		$sql = "
			SELECT * FROM `timetable`.`reservation` WHERE user_id = '$user_id' AND weekday = '$weekday' AND time = '$time';
		";
		$result2 = $conn->query($sql);
		
		if ($result2->num_rows > 0) {
			echo "Sorry. You already reserved a room in that time.";
		}
		elseif ( $result1->num_rows > 0 ) {
			echo "Sorry. Somebody else already reserved that room in that time.";
		}
		else {
			$sql = "
				INSERT INTO `timetable`.`reservation` (`user_id`, `room_id`, `weekday`, `time`) VALUES ('$user_id', '$room_id', '$weekday', '$time');
			";
			
			if ($conn->query($sql) != FALSE) {
				echo "success";
			}
			else {
				echo($conn->error);
			}
		}
	}
    else {
		echo($conn->error);
    }

?>