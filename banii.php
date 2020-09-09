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
 }
 //connect to datebase
 $localhost = "localhost";
 $username = "root";
 $password = "";
 $datebaseName = "mydb";
 
 $connect = mysqli_connect($localhost, $username, $password, $datebaseName);
 
 $query1 = "select * from conturi";
 $result1 = mysqli_query($connect, $query1);
 
 
 ?>
<!DOCTYPE html>
<html>

<head>
  <title>Banii</title>
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

<form action="banii.php" method = "post">
<?php include 'errors.php';?>
<div class="select-valuta">
<label>Selecteaza valuta:</label>

<select name="selectvaluta" id="selectvaluta">
<?php while ($row1 = mysqli_fetch_array($result1)): ;?>
					<option><?php echo $row1[1]; ?></option>
					<?php endwhile?>
<option></option>
					</select>
          <button type="submit" class="btn" name="verifica" style="width: 100px">Selecteaza</button>
</div>

<div class="greencolor">
<?php $selectvaluta = isset($_POST['selectvaluta']) ? $_POST['selectvaluta'] : "";
$_SESSION['selectvaluta']=$selectvaluta;
?>
<label>Valuta selectata este: <?php echo $selectvaluta?></label>
</div>
<div class="input-group">
        <label>Valuta</label>
        <input type="text" name="valuta" id= "valuta" value="<?php echo $valuta; ?>">
      </div>

      <div class="input-group">
        <label>Suma</label>
        <input step = "any" type="number" name="suma" value="<?php echo $suma; ?>">
      </div>

      <div class="input-group">
        <label>Coeficientul de cumparare:</label>
        <input step = "any" type="number" name="coefc" value="<?php echo $coefc; ?>">
      </div>

      <div class="input-group">
        <label>Coeficientul de vanzare:</label>
        <input step = "any" type="number" name="coefv" id = "coefv" value="<?php echo $coefv; ?>">
      </div>

      <div class="input-group wrapper">
      <button type="submit" class="btn" name="clear" onclick="document.getElementById().value=''" style="width: 100px">Clear</button>
      <button type="submit" class="btn" name="sterge" style="width: 100px" onclick="return confirm('Esti sigur ca vrei sa stergi valuta')">Sterge</button>
      <button type="submit" class="btn" name="modific" style="width: 100px" onclick="return confirm('Esti sigur ca vrei sa modifici datele valutei')">Modifica</button>
        <button type="submit" class="btn" name="adauga" style="width: 100px" onclick="return confirm('Esti sigur ca vrei sa adugi o valuta noua')">Adauga</button>
       
      </div>
</form>

<form method="post" action="index.php">
    <div class="input-group">
        <button type="submit" class="btn" name="back2" style="width: 100px">Back</button>
      </div>
    </form>
</div>

 </body>   