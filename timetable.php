<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="styles/table.css" />
<link rel="stylesheet" type="text/css" href="styles/modal.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<?php

	if(!isset($_SESSION['user_id'])) {
		header("Location:login.php");
	}

?>


<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="#"></a>
    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="#"><?php echo($_SESSION['user_name']); ?></a></li>
      <li><a href="#">Rooms</a></li>
    </ul>
    <form class="navbar-form navbar-left">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Room Search">
      </div>
      <button type="submit" class="btn btn-default">Search</button>
    </form>
    <form class="navbar-form navbar-right" action="logout.php" method="post">
      <button type="submit" class="btn btn-default">Logout</button>
    </form>
  </div>
</nav>

<?php
	if (isset($_POST['submit'])) {

		require('db_connect.php');
		require('room.class.php');

		$arr_times = array("8:00 AM", "9:00 AM", "10:00 AM", "11:00 AM", "1:00 PM", "2:00 PM", "3:00 PM", "4:00 PM");
		$from = $_POST['from'];
		$to = $_POST['to'];

		while ($arr_times[0] != $from) {
			array_shift($arr_times)."<br>";
		}

		$arr_times = array_slice($arr_times, 0, array_search($to, $arr_times)+1);

		$sql = "
			SELECT * FROM `timetable`.`rooms` WHERE num_students >= '{$_POST['num_students']}' AND has_pc = '{$_POST['has_pc']}' AND has_projector = '{$_POST['has_projector']}';
		";
		$result = $conn->query($sql);

		$arr_rooms = array();

		if ( $result->num_rows > 0 ) {
			while (list($id, $name, $num_students, $has_pc, $has_projector) = mysqli_fetch_array($result)) {
				$room = new Room($id, $name, $num_students, $has_pc, $has_projector);
				array_push($arr_rooms, $room);
			}
		}

		foreach ($arr_times as $time) {
			foreach ($arr_rooms as $room) {
				$room_id = $room->id;
				$weekday = $_POST['weekday'];
				$sql = "SELECT count(*) as count FROM `timetable`.`reservation` WHERE `room_id`='$room_id' AND `weekday`='$weekday' AND `time`='$time'";
				$result = $conn->query($sql);
				list($count) = mysqli_fetch_array($result);
				if ($count == 0) {
					$register[$time] = $room_id;
					break;
				}
			}
		}
                
                foreach ($register as $time => $room_id) {

                        $sql = "
				INSERT INTO `timetable`.`reservation` (`user_id`, `room_id`, `weekday`, `time`) VALUES ('{$_SESSION['user_id']}', '$room_id', '{$_POST['weekday']}', '$time');
			";
			
			if ($conn->query($sql) == FALSE) {
				echo($conn->error);
			}
                }
	}
?>

<?php
	require('db_connect.php');

	$sql = "SELECT `timetable`.`reservation`.`user_id`, `timetable`.`reservation`.`room_id`, `timetable`.`rooms`.`name`, `timetable`.`rooms`.`num_students`, `timetable`.`rooms`.`has_pc`, `timetable`.`rooms`.`has_projector`, `timetable`.`reservation`.`weekday`, `timetable`.`reservation`.`time` FROM `timetable`.`reservation` LEFT JOIN `timetable`.`rooms` ON `timetable`.`rooms`.`id`=`timetable`.`reservation`.`room_id` WHERE `timetable`.`reservation`.`user_id`='{$_SESSION['user_id']}';
	";

	$result = $conn->query($sql);

	if ( $result->num_rows > 0 ) {
		$table = array(array(), array(), array(), array(), array(), array(), array(), array());
		for ($i=0; $i < 8; $i++) { 
			for ($j=0; $j < 5 ; $j++) { 
				$table[$i][$j] = "";
			}
		}
		$x = 0;
		$y = 0;
		while (list($user_id, $room_id, $name, $num_students, $has_pc, $has_projector, $weekday, $time) = mysqli_fetch_array($result)) {
			switch ($time) {
			 	case '8:00 AM':
			 		$x = 0;
			 		break;
			 	case '9:00 AM':
			 		$x = 1;
			 		break;
			 	case '10:00 AM':
			 		$x = 2;
			 		break;
			 	case '11:00 AM':
			 		$x = 3;
			 		break;
			 	case '1:00 PM':
			 		$x = 4;
			 		break;
			 	case '2:00 PM':
			 		$x = 5;
			 		break;
			 	case '3:00 PM':
			 		$x = 6;
			 		break;
			 	case '4:00 PM':
			 		$x = 7;
			 		break;
			 	default:
			 		$x = 0;
			 		break;
			}

			switch ($weekday) {
			 	case 'Monday':
			 		$y = 0;
			 		break;
			 	case 'Tuesday':
			 		$y = 1;
			 		break;
			 	case 'Wednesday':
			 		$y = 2;
			 		break;
			 	case 'Thursday':
			 		$y = 3;
			 		break;
			 	case 'Friday':
			 		$y = 4;
			 		break;
			 	default:
			 		$y = 0;
			 		break;
			}

			$table[$x][$y] = $name;
		}
	}

?>
<table>
	<thead>
		<tr>
			<th>Time Table</th>
			<th>Monday</th>
			<th>Tuesday</th>
			<th>Wednesday</th>
			<th>Thursday</th>
			<th>Friday</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<th>8:00 AM</th>
			<td><?php echo($table[0][0]); ?></td>
			<td><?php echo($table[0][1]); ?></td>
			<td><?php echo($table[0][2]); ?></td>
			<td><?php echo($table[0][3]); ?></td>
			<td><?php echo($table[0][4]); ?></td>
		</tr>
		<tr>
			<th>9:00 AM</th>
			<td><?php echo($table[1][0]); ?></td>
			<td><?php echo($table[1][1]); ?></td>
			<td><?php echo($table[1][2]); ?></td>
			<td><?php echo($table[1][3]); ?></td>
			<td><?php echo($table[1][4]); ?></td>
		</tr>
		<tr>
			<th>10:00 AM</th>
			<td><?php echo($table[2][0]); ?></td>
			<td><?php echo($table[2][1]); ?></td>
			<td><?php echo($table[2][2]); ?></td>
			<td><?php echo($table[2][3]); ?></td>
			<td><?php echo($table[2][4]); ?></td>
		</tr>
		<tr>
			<th>11:00 AM</th>
			<td><?php echo($table[3][0]); ?></td>
			<td><?php echo($table[3][1]); ?></td>
			<td><?php echo($table[3][2]); ?></td>
			<td><?php echo($table[3][3]); ?></td>
			<td><?php echo($table[3][4]); ?></td>
		</tr>
		<tr>
			<th>12:00 PM</th>
			<td>Lunch Time</td>
		</tr>
		<tr>
			<th>1:00 PM</th>
			<td><?php echo($table[4][0]); ?></td>
			<td><?php echo($table[4][1]); ?></td>
			<td><?php echo($table[4][2]); ?></td>
			<td><?php echo($table[4][3]); ?></td>
			<td><?php echo($table[4][4]); ?></td>
		</tr>
		<tr>
			<th>2:00 PM</th>
			<td><?php echo($table[5][0]); ?></td>
			<td><?php echo($table[5][1]); ?></td>
			<td><?php echo($table[5][2]); ?></td>
			<td><?php echo($table[5][3]); ?></td>
			<td><?php echo($table[5][4]); ?></td>
		</tr>
		<tr>
			<th>3:00 PM</th>
			<td><?php echo($table[6][0]); ?></td>
			<td><?php echo($table[6][1]); ?></td>
			<td><?php echo($table[6][2]); ?></td>
			<td><?php echo($table[6][3]); ?></td>
			<td><?php echo($table[6][4]); ?></td>
		</tr>
		<tr>
			<th>4:00 PM</th>
			<td><?php echo($table[7][0]); ?></td>
			<td><?php echo($table[7][1]); ?></td>
			<td><?php echo($table[7][2]); ?></td>
			<td><?php echo($table[7][3]); ?></td>
			<td><?php echo($table[7][4]); ?></td>
		</tr>
	</tbody>
</table>

<form action="timetable.php" method="post">
	Room Size(Number of Students):<br><input type="text" name="num_students" placeholder="name" /><br>
	Has PC:<label for="has_pc">N <input type="radio" name="has_pc" value="N" /></label>  <label for="has_pc">Y <input type="radio" name="has_pc" value="Y" checked="checked" /></label><br>
	Has Projector:<label for="has_projector">N <input type="radio" name="has_projector" value="N" /></label>  <label for="has_projector">Y <input type="radio" name="has_projector" value="Y" checked="checked" /></label><br>
	WeekDay:
	<select name="weekday">
		<option value="Monday">Monday</option>
		<option value="Tuesday">Tuesday</option>
		<option value="Wednesday">Wednesday</option>
		<option value="Thursday">Thursday</option>
		<option value="Friday">Friday</option>
	</select>
	Duration:<br>
	From:
	<select name="from">
		<option value="8:00 AM">8:00 AM</option>
		<option value="9:00 AM">9:00 AM</option>
		<option value="10:00 AM">10:00 AM</option>
		<option value="11:00 AM">11:00 AM</option>
		<option value="1:00 PM">1:00 PM</option>
		<option value="2:00 PM">2:00 PM</option>
		<option value="3:00 PM">3:00 PM</option>
	</select>
	<br>
	To:
	<select name="to">
		<option value="9:00 AM">9:00 AM</option>
		<option value="10:00 AM">10:00 AM</option>
		<option value="11:00 AM">11:00 AM</option>
		<option value="1:00 PM">1:00 PM</option>
		<option value="2:00 PM">2:00 PM</option>
		<option value="3:00 PM">3:00 PM</option>
		<option value="4:00 PM">4:00 PM</option>
	</select>
	<br>
	<input type="submit" name="submit" value="submit" />
</form>

<div id="room_reservation" class="modal">
	<!-- Modal content -->
	<div class="modal-content">
		<span id="room_reservation_close" class="close">&times;</span>

		<div>
			<h3>Select Weekday</h3>
			<section class="section">
				<div>
					<input type="radio" name="group1" checked="1">
					<label for="radio-1"><span class="radio">Monday</span></label>
				</div>
				<div>
					<input type="radio" name="group1">
					<label for="radio-2"><span class="radio">Tuesday</span></label>
				</div>
				<div>
					<input type="radio" name="group1">
					<label for="radio-3"><span class="radio">Wednesday</span></label>
				</div>
				<div>
					<input type="radio" name="group1">
					<label for="radio-3"><span class="radio">Thursday</span></label>
				</div>
				<div>
					<input type="radio" name="group1">
					<label for="radio-3"><span class="radio">Friday</span></label>
				</div>
			</section>
		</div>

		<div>
			<h3>Select Time</h3>
			<section class="section">
				<div>
					<input type="radio" name="group2" checked="1">
					<label for="radio-1"><span class="radio">8:00 AM</span></label>
				</div>
				<div>
					<input type="radio" name="group2">
					<label for="radio-2"><span class="radio">9:00 AM</span></label>
				</div>
				<div>
					<input type="radio" name="group2">
					<label for="radio-3"><span class="radio">10:00 AM</span></label>
				</div>
				<div>
					<input type="radio" name="group2">
					<label for="radio-3"><span class="radio">11:00 AM</span></label>
				</div>
				<div>
					<input type="radio" name="group2">
					<label for="radio-3"><span class="radio">1:00 PM</span></label>
				</div>
				<div>
					<input type="radio" name="group2">
					<label for="radio-3"><span class="radio">2:00 PM</span></label>
				</div>
				<div>
					<input type="radio" name="group2">
					<label for="radio-3"><span class="radio">3:00 PM</span></label>
				</div>
				<div>
					<input type="radio" name="group2">
					<label for="radio-3"><span class="radio">4:00 PM</span></label>
				</div>
			</section>
		</div>
			
		<button id="room_reservation_submit" class="btn btn-success">Reserve</button>
		<button id="room_reservation_cancel" class="btn btn-success">Cancel</button>
	</div>
</div>

<script>
	$(document).on("click","tr.room", function(e){
		$('#room_reservation').css("display", "block");
		$('#room_reservation_submit').data("room_id", $(this).attr("id"));
	});

	$(document).on("click","#room_reservation_close", function(e){
		$('#room_reservation').css("display", "none");
	});

	$(document).on("click","#room_reservation_cancel", function(e){
		$('#room_reservation').css("display", "none");
	});

	window.onclick = function(event) {
        if (event.target == document.getElementById('room_reservation')) {
            $('#room_reservation').css("display", "none");
        }
    }

    $(document).on("click","#room_reservation_submit", function(e){

		var weekday = $('input[name=group1]:checked').next('label').text();
		var time = $('input[name=group2]:checked').next('label').text();

		var data = new FormData();
		data.append('user_id', "<?php echo($_SESSION['user_id']); ?>");
		data.append('room_id', $(this).data("room_id"));
		data.append('weekday', weekday);
		data.append('time', time);

		$.ajax({
			url:'add_reservation.php',
			type:'POST',
			processData: false,
			contentType: false,
			data: data,
			success: function(resp){
				if (resp == "success") {
					$('#room_reservation').css("display", "none");
					location.reload();
				}
				else {
					alert(resp);
				}
			}
		});
	});
</script>