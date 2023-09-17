<?php
session_start();
$dbstr ="(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 127.0.0.1)(PORT = 1521)))(CONNECT_DATA=(SID=orcl)))";

$user = 'test3';
$password = '123';
$conn = oci_connect($user, $password, $dbstr);
$errors=array();
$p=0;
if(isset($_POST['button'])){

  $uname = $_POST['uname'];

  $password = $_POST['password'];


  $sql = 'BEGIN :result := user_valid(:uname, :password); END;';

// Parse the SQL statement
$stmt = oci_parse($conn, $sql);

// Bind the input parameters
oci_bind_by_name($stmt, ':uname', $uname);
oci_bind_by_name($stmt, ':password', $password);

// Bind the output parameter
oci_bind_by_name($stmt, ':result', $result, 32);

// Execute the statement
oci_execute($stmt);

//   $query="SELECT * FROM us WHERE uname='$uname' AND password ='$password'";
//   $array = oci_parse($conn, $query);
//   $d = array();
// oci_execute($array);
// $result = oci_fetch_all($array, $d);


  if ($result){
    if(isset($_SESSION['mesage']))  {
      $Time_ID=$_GET['Time_ID'];
      $Book=$_GET['Book'];
      $Day=$_GET['Day'];
      header("Location:booking.php?Book=$Book&Day=$Day&Time_ID=$Time_ID");
      unset($_SESSION['mesage']);
      $_SESSION['uname']= $uname;
    }
    else{
    $_SESSION['uname']= $uname;
    header("Location:homepage.php");
  }
  }
  else{
    array_push($errors,"Wrong user or password. Try again");

  }
}

if (isset($_POST['dbutton'])){
  $E_name= $_POST['E_name'];
  $E_password= $_POST['E_password'];

  $sql = 'BEGIN :result := admin_valid(:E_name, :E_password); END;';

  // Parse the SQL statement
  $stmt = oci_parse($conn, $sql);
  
  // Bind the input parameters
  oci_bind_by_name($stmt, ':E_name', $E_name);
  oci_bind_by_name($stmt, ':E_password', $E_password);
  
  // Bind the output parameter
  oci_bind_by_name($stmt, ':result', $result, 32);
  
  // Execute the statement
  oci_execute($stmt);
  // $query="SELECT * FROM admin WHERE E_name='$E_name' AND E_password ='$E_password'";
  // $array=oci_parse($conn,$query);
  // $d = array();
  // oci_execute($array);
  // $result = oci_fetch_all($array, $d);
  if($result){
    header("Location:employeecrud.php");
  }
  else{
    array_push($errors,"Wrong user or password. Try again");}
}
if (isset($_POST['pbutton'])){
  $E_name= $_POST['E_name'];
  $E_password= $_POST['E_password'];
  $sql = 'BEGIN :result := admin_valid(:E_name, :E_password); END;';

  // Parse the SQL statement
  $stmt = oci_parse($conn, $sql);
  
  // Bind the input parameters
  oci_bind_by_name($stmt, ':E_name', $E_name);
  oci_bind_by_name($stmt, ':E_password', $E_password);
  
  // Bind the output parameter
  oci_bind_by_name($stmt, ':result', $result, 32);
  
  // Execute the statement
  oci_execute($stmt);
  // $query="SELECT * FROM admin WHERE E_name='$E_name' AND E_password ='$E_password'";
  // $array=oci_parse($conn,$query);
  // $d = array();
  // oci_execute($array);
  // $result = oci_fetch_all($array, $d);
  if($result){
    header("Location:eusersearch.php");
  }
  else{
    array_push($errors,"Wrong user or password. Try again");}
}

//logout
  if(isset($_GET['homelogout'])){
    session_destroy();
    unset($_SESSION['uname']);
    header("Location:homepage.php");
  }
  if(isset($_GET['searchlogout'])){
    session_destroy();
    unset($_SESSION['uname']);
    header("Location:usersearch.php");
  }
  if (isset($_SESSION['mesage'])){
    array_push($errors,$_SESSION['mesage']);

  }
