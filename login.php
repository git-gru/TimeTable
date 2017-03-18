<link type="text/css"  media="all" href="styles/login.css"  rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<?php
  if(isset($_POST['create'])) {

    require('db_connect.php');

    $password = crypt($_POST['password']);
    $sql = "
      CREATE TABLE IF NOT EXISTS `timetable`.`users`
      (
        id int NOT NULL AUTO_INCREMENT,
        name varchar(255) NOT NULL,
        email varchar(255) NOT NULL,
        password TEXT,
        level int NOT NULL,
        PRIMARY KEY (ID)
      );

      INSERT INTO `timetable`.`users` (`name`, `email`, `password`, `level`) VALUES ('{$_POST['name']}', '{$_POST['email']}', '$password', 2);
    ";

    if ($conn->multi_query($sql) != FALSE) {
      $_POST['login'] = "";
    }
    else {
      echo($conn->error);
    }
  }
  if(isset($_POST['login'])) {

    require('db_connect.php');

    $sql = "
      SELECT * FROM `timetable`.`users` WHERE email='{$_POST['email']}';
    ";
    
    $result = $conn->query($sql);

    if ( $result->num_rows > 0 ) {
      list($id, $name, $email, $password, $level) = $result -> fetch_array(MYSQLI_BOTH);

      if (crypt($_POST['password'], $password) === $password) {
        $_SESSION['user_id'] = $id;
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;
        $_SESSION['user_password'] = $password;
        $_SESSION['user_level'] = $level;
        if ($level == 1) {
          header("Location:admin_panel.php");
        }
        elseif ($level == 2) {
          header("Location:timetable.php");
        }
        
      }
      else {
        echo "Email or password is incorrect. Please try again.";
      }
    }
  }

?>

<div class="login-page">
  <div class="form">
    <form class="register-form" action="login.php" method="post">
      <input type="text" name="name" placeholder="name"/>
      <input type="password" name="password" placeholder="password"/>
      <input type="email" name="email" placeholder="email address"/>
      <button name="create">create</button>
      <p class="message">Already registered? <a href="#">Sign In</a></p>
    </form>
    <form class="login-form" action="login.php" method="post">
      <input type="email" name="email" placeholder="email"/>
      <input type="password" name="password" placeholder="password"/>
      <button name="login">login</button>
      <p class="message">Not registered? <a href="#">Create an account</a></p>
    </form>
  </div>
</div>

<script>
$('.message a').click(function(){
   $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
});
</script>