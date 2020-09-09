<?php
 include 'server.php'; 
//session_start();

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    header("location: login.php");
}

//connect to datebase
$localhost = "localhost";
$username = "root";
$password = "";
$datebaseName = "mydb";

$connect = mysqli_connect($localhost, $username, $password, $datebaseName);
$query1 = "select * from conturi";
$result1 = mysqli_query($connect, $query1);
$result2 = mysqli_query($connect, $query1);

//scoate valoarea din comobox
$combo1 = isset($_POST['combobox1']) ? $_POST['combobox1'] : 'EUR';
$combo2 = isset($_POST['combobox2']) ? $_POST['combobox2'] : 'EUR';
//$val1 = isset($_POST['valuta1']) ? $_POST['valuta1'] : '1';


//pentru coeficienti
$query3 = "select * from conturi where conturi.valuta ='" . $combo1 . "'";
$result3 = mysqli_query($connect, $query3);
$result3a = mysqli_query($connect, $query3);
$query4 = "select * from conturi where conturi.valuta ='" . $combo2 . "'";
$result4 = mysqli_query($connect, $query4);
$result4a = mysqli_query($connect, $query4);
?>
<!--scoatere coeficientilor-->
<?php $coefc = mysqli_fetch_array($result3);
      $coefv = mysqli_fetch_assoc($result4);
      $suma1 = mysqli_fetch_assoc($result3a);
      $suma2 = mysqli_fetch_assoc($result4a)
 ?>


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
    
    
    <?php $val1 = isset($_POST['valuta1']) ? $_POST['valuta1'] : '';
     if ($val1 == null):
     $val2 = "";
     else:
      $coef_vanzare = $coefc['coefc'] / $coefv['coefv'];
      $_SESSION['coef_vanzare'] = $coef_vanzare;
    $val2 = $val1 * $coefc['coefc'] / $coefv['coefv'];
    $val2 = round($val2, 2);
       endif;
     
     ?>


    <form action="index.php" method="post">
    <?php include 'errors.php';?>
      <!--first combobox-->
      <div class="select-valuta">
        <label>Din:</label>
        <select name="combobox1">
          <?php while ($row1 = mysqli_fetch_array($result1)): ;?>
					<option><?php echo $row1[1]; ?></option>
					<?php endwhile?>
        </select>

        <input type="number" name="valuta1" id="valuta1" style="text-align: right;" value="<?php echo $val1 ?>">
        <br>
      </div>

<div class="greencolor">

      <label><?php echo $combo1 ?></label>
      <label><?php echo $combo2 ?></label>
      </div>
      


      <!--second combobox-->
      <div class="select-valuta">
        <label>In:&nbsp;&nbsp;&nbsp;</label>
        <select name="combobox2">
          <?php while ($row2 = mysqli_fetch_array($result2)): ;?>
					<option><?php echo $row2[1]; ?></option>
					<?php endwhile?>
        </select>
        <input readonly type="number" name="valuta2" id="valuta2" style="text-align: right;" value="<?php echo $val2?>">
      </div>
           <!--variabile -->
<?php 
$_SESSION['combo1'] = $combo1;
$_SESSION['combo2'] = $combo2;
$_SESSION['val1'] = $val1;
$_SESSION['val2'] = $val2;
?>
       <!--button-->
      <div class="input-group wrapper">
        <div class="wrapper ">

          <button class="btn" type="submit" onclick="document.getElementById('valuta1').value = ''" name="clear" style="width: 95px">Clear</button>
          <button class="btn" type="submit" name="calculeaza">Calculeaza</button>
           
        </div>
      </div>
    </form>
    <form action="schimb.php" method="post">
    <div class="input-group" >
    <div class="wrapper">
    <button class="btn" type="submit" name="schimba" style="width: 94px; float: right;">Schimba</button>
        </div>
    </div>
    </form>

    <!-- Afisaza butoanele in functie de admin-->
    <?php 
    if ($_SESSION['checkAdmin'] == true){
      ?>
      <form action="register.php" method="post">
    <div class="input-group" >
    <div class="wrapper">
    <button class="btn" type="submit" name="operatori" style="width: 94px; float:right; margin: 0px 5px;">Operatori</button>
        </div>
    </div>
    </form>
      
    <form action="banii.php" method="post">
    <div class="input-group" >
    <div class="wrapper">
    <button class="btn" type="submit" name="conturi" style="width: 94px ; float:right; margin: 0px 0px;">Banii</button>
        </div>
    </div>
    </form>

    
    
    <?php } 
?>
    <form action="tranzactii.php" method="post">
    <div class="input-group" >
    <div class="wrapper">
    <button class="btn" type="submit" name="tranzactii" style="width: 94px; float:right; margin: 0px 5px;">Tranzactii</button>
    <br>
        </div>
    </div>
    </form>
        
   </div>


 <!-- <script>
  function clearInputs() {
    let resetInput1 = document.getElementById("valuta1");
    let resetInput2 = document.getElementById("valuta2");
    if (resetInput1 || resetInput2) {
      resetInput1.value = "";
      resetInput2.value = "";
    }
  }
  </script> -->

</body>

</html>