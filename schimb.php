<?php
 include 'server.php';

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: schimb.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: schimb.php");

}?>


<!DOCTYPE html>
<html>

<head>
  <title>Home</title>
  <link rel="stylesheet" type="text/css" href="style3.css">
</head>

<body>


  <div class="header">
    <h1>EXCHANGE</h1>
  </div>
 
   
<div class="content">
<!-- logged in user information -->
<?php if (isset($_SESSION['username'])): ?>
    <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong>

      <a href="index.php?logout='1'" style="float: right;">Log out</a>
    </p>
    <?php endif?>

    <form method="post" action="schimb.php">
    <?php include 'errors.php';?>
    <div class="greencolor">
<label>Schimba: <?php echo $_SESSION['val1'];?>&nbsp;<?php echo $_SESSION['combo1'];?>
&nbsp;in <?php echo $_SESSION['val2'];?>&nbsp;<?php echo $_SESSION['combo2'];?></label>
</div>
<div class="input-group">
<label>CNP</label>
</div>
<div class="select-cnp">
     
    <input type="text" name="cnpc" value="<?php echo $cnpc; ?>">
    <button class="btn" type="submit" name="VerificaCnp" style="width:100px;">Check</button>
</div>
<div class="input-group">
    <label>Nume</label> 
    <input type="text" name="numec" value="<?php echo $numec; ?>">
</div>
<div class="input-group">
    <label>Prenume</label> 
    <input type="text" name="prenumec" value="<?php echo $prenumec; ?>">
</div>

<div class="input-group">
    <label>Adresa</label> 
    <input type="text" name="adresac" value="<?php echo $adresac; ?>">
</div>
<div class="input-group">
    <label>Telefon</label> 
    <input type="text" name="telefonc" value="<?php echo $telefonc; ?>">
</div>
<div class="input-group wrapper">

        <button type="submit" class="btn" name="schimbac" onclick="return confirm('Esti sigur ca vrei sa finisezi Schimbul ?')" style="width: 100px; float:right;">OK</button>
      </div>
  
    </form>

    <form method="post" action="index.php">
    <div class="input-group">
        <button type="submit" class="btn" name="back" style="width: 100px; float:left;">Back</button>
        <br>
      </div>
    </form>
    
    

  

    </div>
</body>
</html>