<link type="text/css"  media="all" href="styles/login.css"  rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

<?php
  if(isset($_POST['create'])) {
    header("Location:timetable.php"); 
  }
  if(isset($_POST['login'])) {
    header("Location:timetable.php"); 
  }
?>

<div class="login-page">
  <div class="form">
    <form class="register-form" action="login.php" method="post">
      <input type="text" placeholder="name"/>
      <input type="password" placeholder="password"/>
      <input type="text" placeholder="email address"/>
      <button name="create">create</button>
      <p class="message">Already registered? <a href="#">Sign In</a></p>
    </form>
    <form class="login-form" action="login.php" method="post">
      <input type="text" placeholder="username"/>
      <input type="password" placeholder="password"/>
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