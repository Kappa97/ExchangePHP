<?php
session_start();

// initializing variables
//pentru inregistrare
$nume = "";
$prenume = "";
$cnp = "";
$username = "";
$adresa = "";
$telefon = "";
$admin = "";
$errors = array();

//pentru client
$numec = "";
$prenumec = "";
$cnpc = "";
$adresac = "";
$telefonc = "";

//pentru bani 
$valuta = "";
$suma = "";
$coefc = "";
$coefv = "";

//pentru modificari operator
$nume_m = "";
$prenume_m = "";
$cnp_m = "";
$username_m = "";
$adresa_m = "";
$telefon_m = "";
$admin_m = "";

// connect to the database
$db = mysqli_connect('localhost', 'root', '', 'mydb');


//verifica opertor
if (isset($_POST['verificao'])){
    $combo_operator = isset($_POST['selectoperator']) ? $_POST['selectoperator'] : '';
    $query8 = "select * from operator where operator.username ='" . $combo_operator . "'";
    $result8 = mysqli_query($db, $query8);
    $selecteazao = mysqli_fetch_assoc($result8);
    
    $nume = $selecteazao['nume'];
    $prenume = $selecteazao['prenume'];
    $cnp = $selecteazao['cnp'];
    $username = $selecteazao['username'];
    $adresa = $selecteazao['adresa'];
    $telefon = $selecteazao['telefon'];
    $admin = $selecteazao['admin'];
    $password="";
   
}
// REGISTER USER
else if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $nume = mysqli_real_escape_string($db, $_POST['nume']);
    $prenume = mysqli_real_escape_string($db, $_POST['prenume']);
    $cnp = mysqli_real_escape_string($db, $_POST['cnp']);
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $adresa = mysqli_real_escape_string($db, $_POST['adresa']);
    $telefon = mysqli_real_escape_string($db, $_POST['telefon']);
    $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
    $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
    $admin = mysqli_real_escape_string($db, $_POST['admin']);
   

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($nume)) {array_push($errors, "Nume is required");}
    if (empty($prenume)) {array_push($errors, "Prenume is required");}
    if (empty($cnp)) {array_push($errors, "Cnp is required");}
    if (empty($username)) {array_push($errors, "Username is required");}
    if (empty($password_1)) {array_push($errors, "Password is required");}

    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    if (empty($adresa)) {array_push($errors, "Adresa is required");}
    if (empty($telefon)) {array_push($errors, "Telefon is required");}
    //if (empty($admin)) {array_push($errors, "Admin is required");}
    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM operator WHERE username='$username'";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1); //encrypt the password before saving in the database

        $query = "INSERT INTO operator (nume, prenume, cnp, username, parola, adresa, telefon, admin)
  			  VALUES('$nume', '$prenume', '$cnp', '$username', '$password', '$adresa', '$telefon', '$admin')";
        mysqli_query($db, $query);
        //$_SESSION['username'] = $username;
        //$_SESSION['success'] = "You are now logged in";
        header('location: register.php');
    }
}
//Modifica user
else if (isset($_POST['modific_operator'])){
   
// receive all input values from the form
$nume_m = mysqli_real_escape_string($db, $_POST['nume']);
$prenume_m = mysqli_real_escape_string($db, $_POST['prenume']);
$cnp_m = mysqli_real_escape_string($db, $_POST['cnp']);
$username_m = mysqli_real_escape_string($db, $_POST['username']);
$adresa_m = mysqli_real_escape_string($db, $_POST['adresa']);
$telefon_m = mysqli_real_escape_string($db, $_POST['telefon']);
$password_1_m = mysqli_real_escape_string($db, $_POST['password_1']);
$password_2_m = mysqli_real_escape_string($db, $_POST['password_2']);
$admin_m = mysqli_real_escape_string($db, $_POST['admin']);

 // by adding (array_push()) corresponding error unto $errors array
 if (empty($nume_m)) {array_push($errors, "Nume is required");}
 if (empty($prenume_m)) {array_push($errors, "Prenume is required");}
 if (empty($cnp_m)) {array_push($errors, "Cnp is required");}
 if (empty($username_m)) {array_push($errors, "Username is required");}
 if (empty($adresa_m)) {array_push($errors, "Adresa is required");}
 if (empty($telefon_m)) {array_push($errors, "Telefon is required");}
 //if (empty($admin_m)) {array_push($errors, "Admin is required");}
 if ($password_1 != $password_2) {
    array_push($errors, "The two passwords do not match");
}

  
        if (count($errors) == 0) {
            //echo "in if ";
        $password_m = md5($password_1_m); //encrypt the password before saving in the database
        
        $erw = $_SESSION['selectoperator'];

        $query_m = "UPDATE operator SET 
        nume = '$nume_m', 
        prenume = '$prenume_m',
        cnp = '$cnp_m',
        username = '$username_m', 
        parola = '$password_m',
        adresa = '$adresa_m',
        telefon = '$telefon_m',
        admin = '$admin_m'
         where username='$erw' ";
        mysqli_query($db, $query_m);
        header('location: register.php');
    }

    
 
}

//sterge operator
if (isset($_POST['stergeo'])) {
    $val = $_SESSION['selectoperator'];
    $query10 = "DELETE FROM operator where username = '$val' ";
    mysqli_query($db, $query10);
    header('location: register.php');
}

// LOGIN USER
if (isset($_POST['login_user'])) {
    
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
      
        $password = md5($password);
        $query = "SELECT * FROM operator WHERE username='$username' AND parola='$password'";
        $results = mysqli_query($db, $query);
        $results2 = mysqli_query($db, $query);
        
        
        
      
        
        
        if (mysqli_num_rows($results) == 1) {
           
         
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            $info_admin = mysqli_fetch_assoc($results2);
            $_SESSION['checkAdmin'] = $info_admin['admin'];
            
            header('location: index.php');
        } else {
            array_push($errors, "Wrong username/password combination");
        }
      
    }
}
//nu s-a facut calculul
if (isset($_POST['calculeaza'])) {
    
    $valuta1 = mysqli_real_escape_string($db, $_POST['valuta1']);
    $valuta2 = mysqli_real_escape_string($db, $_POST['valuta2']);
    $combo1 = mysqli_real_escape_string($db, $_POST['combobox1']);
    $combo2 = mysqli_real_escape_string($db, $_POST['combobox2']);
    
    $_SESSION['valuta1'] = $valuta1;
    $_SESSION['valuta2'] = $valuta2;
    $_SESSION['combo1'] = $combo1;
    $_SESSION['combo2'] = $combo2;

    if (empty($valuta1)) {
        array_push($errors, "Introduceti suma pe care doriti sa o schimbati");
    }

    if ($combo1 == $combo2 || ($combo1 != 'RON' && $combo2 != 'RON')) {
        array_push($errors, "puteti schimba doar din RON in VALUTA sau invers");
    }

}
else if (isset($_POST["clear"])) {
$valuta1="";
$valuta2="";
$_SESSION['valuta1'] = $valuta1;
$_SESSION['valuta2'] = $valuta2;
}

//inregistreaza client
else if (isset($_POST['schimbac'])) {
    $numec = mysqli_real_escape_string($db, $_POST['numec']);
    $prenumec = mysqli_real_escape_string($db, $_POST['prenumec']);
    $cnpc = mysqli_real_escape_string($db, $_POST['cnpc']);
    $adresac = mysqli_real_escape_string($db, $_POST['adresac']);
    $telefonc = mysqli_real_escape_string($db, $_POST['telefonc']);
    

    if (empty($numec)) {array_push($errors, "Nume is required");}
    if (empty($prenumec)) {array_push($errors, "Prenume is required");}
    if (empty($cnpc)) {array_push($errors, "Cnp is required");}
    if (empty($adresac)) {array_push($errors, "Adresa is required");}
    if (empty($telefonc)) {array_push($errors, "Telefon is required");}
   

    
    if (count($errors) == 0) {
        $query1 = "INSERT INTO  client (nume, prenume, cnp, adresa, telefon)
        VALUES('$numec', '$prenumec', '$cnpc', '$adresac', '$telefonc')";
        mysqli_query($db, $query1);
               
        
        $sm1=$_SESSION['val1'];
        $sm2=$_SESSION['val2'];
        $co1=$_SESSION['combo1'];
        $co2=$_SESSION['combo2'];

        $query2 = "UPDATE conturi SET suma=suma+'$sm1' WHERE valuta='$co1'" ;
        mysqli_query($db, $query2);
        
        $query3 = "UPDATE conturi SET suma=suma-'$sm2' WHERE valuta='$co2'" ;
        mysqli_query($db, $query3);
       
       //scoate codc din client
        $cod_cquery = "select * from client where client.cnp ='" . $cnpc . "'";
       $cod_cresult = mysqli_query($db, $cod_cquery);
       $codul_cl = mysqli_fetch_assoc($cod_cresult);
       $cod_client=$codul_cl['codc'];
      
       //scoate codo din operator
       $username_operator=$_SESSION['username'];
       $cod_oquery = "select * from operator where operator.username ='" . $username_operator . "'";
       $cod_oresult = mysqli_query($db, $cod_oquery);
       $codul_op = mysqli_fetch_assoc($cod_oresult);
       $cod_operator=$codul_op['codo'];
        //scoate coeficientul
        $coef_vanzare=$_SESSION['coef_vanzare'];
        //scoate data curenta    
        date_default_timezone_set('Europe/Bucharest'); 
      $date1 = date("Y-m-d H:i:s"); 
      //introduce in tranzactii
      $tranzactii_query = "INSERT INTO  tranzactie (client_codc, operator_codo, id_din, id_in, sum_din, sum_in, curs_curent, datat)
      VALUES('$cod_client', '$cod_operator', '$co1', '$co2', '$sm1', '$sm2', '$coef_vanzare', '$date1')";
      mysqli_query($db, $tranzactii_query);
      

        

       $aduga_tranzactie = "INSERT INTO tranzactie (client_codc) VALUES ('$cod_client') ";
       mysqli_query($db, $aduga_tranzactie);

        header('location: index.php');
        
    
}

}

//banii
//Afiseaza valuta
if (isset($_POST['verifica'])){
    $combo = isset($_POST['selectvaluta']) ? $_POST['selectvaluta'] : '';
    $query4 = "select * from conturi where conturi.valuta ='" . $combo . "'";
    $result4 = mysqli_query($db, $query4);
    $selecteaza = mysqli_fetch_assoc($result4);
    $valuta = $selecteaza['valuta']; 
    $suma = $selecteaza['suma'];
    $coefc = $selecteaza['coefc'];
    $coefv = $selecteaza['coefv'];
   
}
//modifica valuta
else if (isset($_POST['modific'])){
    
    $valuta_m = mysqli_real_escape_string($db, $_POST['valuta']);
    $suma_m = mysqli_real_escape_string($db, $_POST['suma']);
    $coefc_m = mysqli_real_escape_string($db, $_POST['coefc']);
    $coefv_m = mysqli_real_escape_string($db, $_POST['coefv']);

    if (empty($valuta_m)) {array_push($errors, "Valuta is required");}
    if (empty($suma_m)) {array_push($errors, "Suma is required");}
    if (empty($coefc_m)) {array_push($errors, "Coefc is required");}
    if (empty($coefv_m)) {array_push($errors, "Coefv is required");}
    
    if (count($errors) == 0){
        
        $erw = $_SESSION['selectvaluta'];
        $query5 = "UPDATE conturi SET valuta = '$valuta_m', suma = '$suma_m', coefc = '$coefc_m', coefv = '$coefv_m' where valuta='$erw' " ;
        mysqli_query($db, $query5);

      // header('location: banii.php');
        
    }
}
//sterge valuta
else if (isset($_POST['sterge'])){
    
    $erw = $_SESSION['selectvaluta'];
    $query6 = "DELETE FROM conturi where valuta = '$erw' ";
    mysqli_query($db, $query6);
    header('location: banii.php');

}//adauga valuta
else if (isset($_POST['adauga'])){
    $valuta_m = mysqli_real_escape_string($db, $_POST['valuta']);
    $suma_m = mysqli_real_escape_string($db, $_POST['suma']);
    $coefc_m = mysqli_real_escape_string($db, $_POST['coefc']);
    $coefv_m = mysqli_real_escape_string($db, $_POST['coefv']);

    if (empty($valuta_m)) {array_push($errors, "Valuta is required");}
    if (empty($suma_m)) {array_push($errors, "Suma is required");}
    if (empty($coefc_m)) {array_push($errors, "Coefc is required");}
    if (empty($coefv_m)) {array_push($errors, "Coefv is required");}
   
    if (count($errors) == 0){
       
        $erw = $_SESSION['selectvaluta'];
        $query7 = "INSERT INTO conturi (valuta, suma, coefc, coefv) values ('$valuta_m', '$suma_m', '$coefc_m', '$coefv_m')" ;
        mysqli_query($db, $query7);
        header('location: banii.php');
        
    }
}
//clear in banii
if (isset($_POST['VerificaCnp'])){
    $cnpc = mysqli_real_escape_string($db, $_POST['cnpc']);
    $client_check_query = "SELECT * FROM client WHERE cnp='$cnpc'";
    $result_check = mysqli_query($db, $client_check_query);
    $client_check = mysqli_fetch_assoc($result_check);
    $cnpClient = $client_check['nume'];
  

    if ($cnpClient) { // if cnp exists
        $numec = $client_check['nume'];
$prenumec = $client_check['prenume'];
$cnpc = $client_check['cnp'];
$adresac = $client_check['adresa'];
$telefonc = $client_check['telefon'];

    }
   
}

