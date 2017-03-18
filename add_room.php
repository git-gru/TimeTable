<?php 
	if (isset($_POST)) {
		require('db_connect.php');
		$name = $_POST['name'];
		$num_students = $_POST['num_students'];
		if (!empty($name) && !empty($num_students)) {
			$sql = "SELECT count(*) as count FROM `timetable`.`rooms` WHERE name='$name'";
			$result = $conn->query($sql);
			list($count) = $result -> fetch_array(MYSQLI_BOTH);
			if ($count > 0) {
				$sql = "UPDATE `timetable`.`rooms` SET `num_students`='$num_students', `has_pc`='{$_POST['has_pc']}', `has_projector`='{$_POST['has_projector']}' WHERE `name`='$name';";
				if ($conn->multi_query($sql) != FALSE) {
					$message = "Room " . $name . " has been updated.";
				}
				else {
					$message = $conn->error;
				}
			} else {
				$sql = "INSERT INTO `timetable`.`rooms` (`name`, `num_students`, `has_pc`, `has_projector`) VALUES ('$name', '$num_students', '{$_POST['has_pc']}', '{$_POST['has_projector']}');";
				if ($conn->multi_query($sql) != FALSE) {
					$message = "Room " . $name . " has been added.";
				}
				else {
					$message = $conn->error;
				}
			}
		}
		else {
			$message = "<span style='color: red'>Please enter room name and number of students.</span>";
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Add Member</title>
		<style>
			body {
				font-family: Arial, Helvetica, sans-serif;
			}
		</style>
	</head>
	<body>
		<h1>Add Room</h1>
		<?php if (!empty($message)): ?>
			<strong><?php echo $message; ?></strong>
		<? endif ?>
		<form action="add_room.php" method="post">
			<table>
				<tr>
					<td>Room Name: </td>
					<td>
						<input type="text" name="name" placeholder="name" />
					</td>
				</tr>

				<tr>
					<td>Students: </td>
					<td>
						<input type="text" name="num_students" placeholder="name" />
					</td>
				</tr>

				<tr>
					<td>Has PC: </td>
					<td><label for="has_pc">N <input type="radio" name="has_pc" value="N" /></label>  <label for="has_pc">Y <input type="radio" name="has_pc" value="Y" checked="checked" /></label> </td>
				</tr>
				<tr>
					<td>Has Projector: </td>
					<td><label for="has_projector">N <input type="radio" name="has_projector" value="N" /></label>  <label for="has_projector">Y <input type="radio" name="has_projector" value="Y" checked="checked" /></label> </td>
				</tr>
			</table>
			<input type="submit" name="submit" value="submit" />
		</form>
	</body>
</html>