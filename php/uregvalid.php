<?php

session_start();

$dbstr = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 127.0.0.1)(PORT = 1521)))(CONNECT_DATA=(SID=orcl)))";

$user = 'test3';
$password = '123';
$conn = oci_connect($user, $password, $dbstr);
$errors = array();
$te = oci_parse($conn, "ALTER SESSION SET nls_date_format = 'HH24:MI:SS'");
oci_execute($te);
if (isset($_POST['signup'])) {
  $username = $_POST['name'];
  $uname = $_POST['uname'];
  $dob = $_POST['dob'];
  $eid = $_POST['eid'];
  $password = $_POST['password'];
  $cpassword = $_POST['cpassword'];
  $sql = 'BEGIN :result := get_uname_password(:uname); END;';

  // Parse the SQL statement
  $stmt = oci_parse($conn, $sql);

  // Bind the input parameters
  // Bind the variables
  oci_bind_by_name($stmt, ":uname", $uname);
  oci_bind_by_name($stmt, ":result", $result, 32);

  // Execute the statement
  oci_execute($stmt);

  // Split the returned result into uname and password
  // list($returned_uname, $returned_password) = explode(',', $add_user);
  // echo gettype($returned_uname);
  // echo gettype($uname);


  // $checkuni="SELECT * FROM us WHERE uname='$uname' and rownum = 1";
  // $result = oci_parse($conn, $checkuni);
  // oci_execute($result);
  // $user=oci_fetch_array($result);
  // oci_bind_by_name($stmt, ':add_user', $add_user, 32);

  // echo $returned_uname . " " . $uname . " <br>";
  // echo $returned_password . " " . $cpassword;

  $p = 0;
  if ($result) {
    
      array_push($errors, "Username already exists ");
      $p = 1;
    
  }
  if ($password != $cpassword) {
    array_push($errors, "password doesn't match");
    $p = 1;
  }

  if ($p == 0) {
    $stmt = oci_parse($conn, 'BEGIN insert_us(:p_name, :p_uname, :p_eid, :p_dob, :p_password); END;');
    oci_bind_by_name($stmt, ':p_name', $username);
    oci_bind_by_name($stmt, ':p_uname', $uname);
    oci_bind_by_name($stmt, ':p_dob', $dob);
    oci_bind_by_name($stmt, ':p_eid', $eid);
    oci_bind_by_name($stmt, ':p_password', $password);
    oci_bind_by_name($stmt, ':cp_password', $cpassword);
    
    // Execute the statement
    oci_execute($stmt);

    $_SESSION['register'] = "Registered Sucessfully! Please Login.";
    header("Location:signin.php");
  }
}
