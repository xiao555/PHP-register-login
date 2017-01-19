<?php
session_start();
require 'database.php';
$user = null;

if(!empty($_POST['user'])&&!empty($_POST['password'])) {

  $records = $db->prepare('SELECT user,password FROM users WHERE user = :user');
  $records->bindParam(':user', $_POST['user']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);
  $message = '';

  if(count($results) > 0){
    if($_POST['password'] == $results['password']){
      $user = $results['user'];
    } else {
      $message = 'Sorry,  your password is wrong!';
    }
  } else {
    $message = "Sorry, user gon't exist!";
  }
}

if( isset($_SESSION['user'])) {
  $records = $db->prepare('SELECT user,password FROM users WHERE user = :user');
  $records->bindParam(':user', $_POST['user']);
  $records->execute();
  $results = $records->fetch(PDO::FETCH_ASSOC);

  $user = $results['user'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Welcome</title>
</head>
<body>
  <div  class="main">
    <?php
      if(!empty($message)){
    ?> <p> <?php echo $message; ?> </p>
       <a href="./index.php">Back to Home</a>
    <?php
      }
    ?>
    <?php if( !empty($user) ): ?>

      <br />Welcome <?= $user; ?>
      <br /><br />You are successfully logged in!
      <br /><br />
      <a href="logout.php">Logout?</a>

    <?php else: ?>

      <form action="index.php" method="post">
        User: <input type="text" name="user">
        Password: <input type="password" name="password">
        <input type="submit" value="Login">
      </form>
      <a href="register.php">Register</a>

    <?php endif; ?>
    
  </div>
</body>
</html>