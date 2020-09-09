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
 

 
 
 ?>
<!DOCTYPE html>
<html>

<head>
  <title>Tranzactii</title>
  <link rel="stylesheet" type="text/css" href="style3.css">
</head>

<body>


  <div class="header2">
    <h1>Tranzactii</h1>
  </div>
   
<div class="content2">
<!-- logged in user information -->
<?php if (isset($_SESSION['username'])): ?>
    <p>Welcome <strong><?php echo $_SESSION['username']; ?></strong>

      <a href="index.php?logout='1'" style="float: right;">Log out</a>
    </p>
    <?php endif?>
    <br><br>
<table id="dataTables-example">
 <thead>
     <tr>
         <th>CodTranzactie&emsp;</th>
         <th>CodClient&emsp;</th>
         <th>CodOperator&emsp;</th>
         <th>Din&emsp;&emsp;&emsp;</th>
         <th>In&emsp;&emsp;&emsp;</th>
         <th>SumaDin&emsp;</th>
         <th>SumaIn&emsp;</th>
         <th>Coeficientul&emsp;</th>
         <th>Data&emsp;</th>

     </tr>
 </thead>
 <tbody>
       <?php
     $query_table="select * from tranzactie";
     $re = mysqli_query($connect, $query_table);
     while ($row = mysqli_fetch_array($re)) {

         $id = $row['codt'];
         $state = $row['datat'];
                 echo "<tr>
	<td>" . $row['codt'] . "</td>
	<td>" . $row['client_codc'] . "</td>
	<td>" . $row['operator_codo'] . "</td>
	<td>" . $row['id_din'] . "</td>
  <td>" . $row['id_in'] . "</td>
  <td>" . $row['sum_din'] . "</td>
  <td>" . $row['sum_in'] . "</td>
  <td>" . $row['curs_curent'] . "</td>
	<td>" . $row['datat'] . "</td>

</tr>";

                   
          }

          ?>

      </tbody>
  </table>
  <br>
  <form method="post" action="index.php">
   <div class="input-group">
   <button type="submit" class="btn" name="back4" style="width: 100px; margin: 0px, 20px">Back</button>
   </form>
   </div>

</div>

<body>