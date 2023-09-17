<?php
$dbstr ="(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 127.0.0.1)(PORT = 1521)))(CONNECT_DATA=(SID=orcl)))";

$user = 'test3';
$password = '123';
$conn = oci_connect($user, $password, $dbstr);
$te = oci_parse($conn, "ALTER SESSION SET nls_date_format = 'HH24:MI:SS'");
oci_execute($te);
$errors=array();
$msg=array();
$upd=array();
// create operation

if(isset($_POST['create'])){
  $Arrival= $_POST['Arrival'];
  $T_ID= $_POST['T_ID'];
  $Departure= $_POST['Departure'];
  $query="INSERT INTO travel_info (T_ID,Arrival,Departure)
         VALUES ('$T_ID','$Arrival','$Departure')";
  $array = oci_parse($conn, $query);
  oci_execute($query);
  if(oci_num_rows($array)){

    //Record Created messages!

    array_push($msg,"Recorded added sucessfully");
  };
}

//update operation

if(isset($_POST['update'])){
  $Arrival= $_POST['Arrival'];
  $T_ID= $_POST['T_ID'];
  $Departure= $_POST['Departure'];
  $query="UPDATE travel_info SET Arrival='$Arrival', Departure='$Departure'
              WHERE T_ID='$T_ID'";
      $array = oci_parse($conn, $query);
      oci_execute($query);
  if(oci_num_rows($array)){
    //Record Updated messages!
    array_push($upd,"Recorded Updated sucessfully");}
    else{
      array_push($errors,"Unable to update");
    }
  }

  //Delete opertaion

  if(isset($_POST['delete'])){
    $Arrival = $_POST['Arrival'];
    $T_ID = $_POST['T_ID'];
    $Departure = $_POST['Departure'] ;
    $query="DELETE FROM travel_info WHERE T_ID='$T_ID'";
    $array = oci_parse($conn, $query);
    oci_execute($query);
    if(oci_num_rows($array)){
      //Record deleted messages!
      array_push($errors,"Recorded Deleted sucessfully");}
      else{
        array_push($errors,"Unable to Delete");
      }
    }
