<?php


$dbstr = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 127.0.0.1)(PORT = 1521)))(CONNECT_DATA=(SID=orcl)))";

$user = 'test3';
$password = '123';
$conn = oci_connect($user, $password, $dbstr);
$te = oci_parse($conn, "ALTER SESSION SET nls_date_format = 'HH24:MI:SS'");
oci_execute($te);
$errors = array();
$msg = array();
$upd = array();
// create operation

if (isset($_POST['create'])) {

  $Flight_name = $_POST['Flight_name'];
  $Flight_ID = $_POST['Flight_ID'];
  $seats = $_POST['Seats'];
  $stmt = oci_parse($conn, 'BEGIN create_flight(:p_fid, :p_fname, :p_fseats); END;');
  oci_bind_by_name($stmt, ':p_fid', $Flight_ID);
  oci_bind_by_name($stmt, ':p_fname', $Flight_name);
  oci_bind_by_name($stmt, ':p_fseats', $seats);

  // Execute the statement
  oci_execute($stmt);
  // $query="INSERT INTO flight_info (Flight_ID,Flight_name,Seats)
  //       VALUES ('$Flight_ID','$Flight_name','$seats')";
  // if(oci_execute(oci_parse($conn, $query))){

  //Record Created messages!

  array_push($msg, "Recorded added sucessfully");
  // };

}

//update operation

if (isset($_POST['update'])) {
  $Flight_name = $_POST['Flight_name'];
  $Flight_ID = $_POST['Flight_ID'];
  $seats = $_POST['Seats'];
  $stmt = oci_parse($conn, 'BEGIN update_flight(:p_fid, :p_fname, :p_fseats); END;');
  oci_bind_by_name($stmt, ':p_fname', $Flight_name);
  oci_bind_by_name($stmt, ':p_fid', $Flight_ID);
  oci_bind_by_name($stmt, ':p_fseats', $seats);

  // Execute the statement
  oci_execute($stmt);
  // $query = "UPDATE flight_info SET Flight_name='$Flight_name', Seats='$seats'
  //             WHERE Flight_ID='$Flight_ID'";
  // if (oci_execute(oci_parse($conn, $query))) {
  //Record Updated messages!
  array_push($upd, "Recorded Updated sucessfully");
  // } else {
  // array_push($errors, "Unable to update");
  // }
}

//Delete opertaion

if (isset($_POST['delete'])) {
  $Flight_ID = $_POST['Flight_ID'];
  $stmt = oci_parse($conn, 'BEGIN delete_flight(:p_fid); END;');
  // oci_bind_by_name($stmt, ':p_fid', $Flight_name);
  oci_bind_by_name($stmt, ':p_fid', $Flight_ID);
  // oci_bind_by_name($stmt, ':p_fseats', $seats);

  // Execute the statement
  oci_execute($stmt);
  // $query="DELETE FROM flight_info WHERE Flight_ID='$Flight_ID'";
  // if(oci_execute(oci_parse($conn, $query))){
  //Record deleted messages!
  array_push($errors, "Recorded Deleted sucessfully");
}
// else{
// array_push($errors,"Unable to Delete");
// }
// }

// create operation

if (isset($_POST['t_create'])) {
  $Flight_ID = $_POST['Flight_ID'];
  $Arrival = $_POST['Arrival'];
  $Travel_code = $_POST['Travel_code'];
  $Departure = $_POST['Departure'];
  $Travel_type = $_POST['Travel_type'];
  $stmt = oci_parse($conn, 'BEGIN create_travel(:p_tcode, :p_tArrival, :p_tDeparture ,:p_iid  ,:p_ttype ); END;');
  oci_bind_by_name($stmt, ':p_tcode', $Travel_code);
  oci_bind_by_name($stmt, ':p_tArrival', $Arrival);
  oci_bind_by_name($stmt, ':p_tDeparture', $Departure);
  oci_bind_by_name($stmt, ':p_iid',  $Flight_ID);
  oci_bind_by_name($stmt, ':p_ttype', $Travel_type);
  // Execute the statement
  oci_execute($stmt);
  array_push($msg, "Recorded added sucessfully");
  // $query = "INSERT INTO travel_info (Travel_code,Arrival,Departure,Flight_id,Travel_type)
  //           VALUES ('$Travel_code','$Arrival','$Departure','$Flight_ID','$Travel_type')";
  // if (oci_execute(oci_parse($conn, $query))) {
  //   //Record Created messages!
  //   array_push($msg, "Recorded added sucessfully");
  // } else {
  //   array_push($errors, "Unable to create");
  // }
}



//update operation

if (isset($_POST['t_update'])) {
  $Flight_ID = $_POST['Flight_ID'];
  $Arrival = $_POST['Arrival'];
  $Travel_code = $_POST['Travel_code'];
  $Departure = $_POST['Departure'];
  $Travel_type = $_POST['Travel_type'];

  $stmt = oci_parse($conn, 'BEGIN update_travel(:p_tcode, :p_tArrival, :p_tDeparture ,:p_iid  ,:p_ttype); END;');
  oci_bind_by_name($stmt, ':p_tcode', $Travel_code);
  oci_bind_by_name($stmt, ':p_tArrival', $Arrival);
  oci_bind_by_name($stmt, ':p_tDeparture', $Departure);
  oci_bind_by_name($stmt, ':p_iid',  $Flight_ID);
  oci_bind_by_name($stmt, ':p_ttype', $Travel_type);

  // Execute the statement
  oci_execute($stmt);
  //Record Updated messages!
  array_push($upd, "Recorded Updated sucessfully");


  //  $query = "UPDATE travel_info SET Arrival='$Arrival', Departure='$Departure',Flight_id='$Flight_ID',
  //                 Travel_type='$Travel_type'  WHERE Travel_code='$Travel_code'";
  //   if (oci_execute(oci_parse($conn, $query))) {
  //     //Record Updated messages!
  //     array_push($upd, "Recorded Updated sucessfully");
  //   } else {
  //     array_push($errors, "Unable to update");
  //   }
}

//Delete opertaion

if (isset($_POST['t_delete'])) {
  $Flight_ID = $_POST['Flight_ID'];
  $Arrival = $_POST['Arrival'];
  $Travel_code = $_POST['Travel_code'];
  $Departure = $_POST['Departure'];
  $Travel_type = $_POST['Travel_type'];

  $stmt = oci_parse($conn, 'BEGIN delete_travel(:p_tcode); END;');
  oci_bind_by_name($stmt, ':p_tcode', $Travel_code);
  oci_execute($stmt);
  array_push($errors, "Recorded Deleted sucessfully");

  // $query = "DELETE FROM travel_info WHERE Travel_code='$Travel_code'";
  // if (oci_execute(oci_parse($conn, $query))) {
  //   //Record deleted messages!
  //   array_push($errors, "Record Deleted sucessfully");
  // } else {
  //   array_push($errors, "Unable to Delete");
  // }
}


// create operation

if (isset($_POST['P_create'])) {
  $Travel_code = $_POST['Travel_code'];
  $Price = $_POST['Price'];
  $Cno = $_POST['Cno'];
  $stmt = oci_parse($conn, 'BEGIN create_cprice(:p_ccode, :p_ccno , :p_cprice ); END;');
  oci_bind_by_name($stmt, ':p_ccode', $Travel_code);
  oci_bind_by_name($stmt, ':p_ccno', $Cno);
  oci_bind_by_name($stmt, ':p_cprice', $Price);
  // Execute the statement
  oci_execute($stmt);
  array_push($msg, "Recorded added sucessfully");

  // $query = "INSERT INTO cprice_info (Travel_code,Price,Cno)
  //               VALUES ('$Travel_code','$Price','$Cno')";
  // if (oci_execute(oci_parse($conn, $query))) {
  //   //Record Created messages!
  //   array_push($msg, "Recorded added sucessfully");
  // } else {
  //   array_push($errors, "Unable to create");
  // }
}

//update operation

if (isset($_POST['P_update'])) {
  $Travel_code = $_POST['Travel_code'];
  $Price = $_POST['Price'];
  $Cno = $_POST['Cno'];
  $stmt = oci_parse($conn, 'BEGIN update_cprice(:p_ccode, :p_ccno , :p_cprice ); END;');
  oci_bind_by_name($stmt, ':p_ccode', $Travel_code);
  oci_bind_by_name($stmt, ':p_ccno', $Cno);
  oci_bind_by_name($stmt, ':p_cprice', $Price);

  // Execute the statement
  oci_execute($stmt);
  // Record Updated messages!
  array_push($upd, "Recorded Updated sucessfully");

  // $query = "UPDATE cprice_info SET Price='$Price'
  //               WHERE Travel_code='$Travel_code' AND Cno='$Cno'";
  // if (oci_execute(oci_parse($conn, $query))) {
  //   //Record Updated messages!
  //   array_push($upd, "Recorded Updated sucessfully");
  // } else {
  //   array_push($errors, "Unable to update");
  // }
}

//Delete opertaion

if (isset($_POST['P_delete'])) {
  $Travel_code = $_POST['Travel_code'];
  $Price = $_POST['Price'];
  $Cno = $_POST['Cno'];
  $stmt = oci_parse($conn, 'BEGIN delete_cprice(:p_ccode , :p_ccno); END;');
  oci_bind_by_name($stmt, ':p_ccode', $Travel_code);
  oci_bind_by_name($stmt, ':p_ccno', $Cno);
  oci_execute($stmt);
  array_push($errors, "Recorded Deleted sucessfully");


  // $query = "DELETE FROM cprice_info WHERE Travel_code='$Travel_code' AND Cno='$Cno'";
  // if (oci_execute(oci_parse($conn, $query))) {
  //   //Record deleted messages!
  //   array_push($errors, "Record Deleted sucessfully");
  // } else {
  //   array_push($errors, "Unable to Delete");
  // }
}



// create operation

if (isset($_POST['ti_create'])) {
  $Travel_code = $_POST['Travel_code'];
  $Arrival_time = $_POST['Arrival_time'];
  echo $Arrival_time;
  $Departure_time = $_POST['Departure_time'];
  $Day_ID = $_POST['Day_ID'];
  $Time_ID = $_POST['Time_ID'];

  $stmt = oci_parse($conn, 'BEGIN create_time(:p_tcode, :p_tdep, :p_tarrival, :p_tdid , :p_tid); END;');
  oci_bind_by_name($stmt, ':p_tcode', $Travel_code);
  oci_bind_by_name($stmt, ':p_tdep', $Departure_time);
  oci_bind_by_name($stmt, ':p_tarrival', $Arrival_time);
  oci_bind_by_name($stmt, ':p_tdid',  $Day_ID);
  oci_bind_by_name($stmt, ':p_tid', $Time_ID);

  // Execute the statement
  oci_execute($stmt);
  array_push($msg, "Recorded added sucessfully");

  // $query = "INSERT INTO time (Travel_code,Arrival_time,Departure_time,Day_ID,Time_ID)
  //           VALUES ('$Travel_code','$Arrival_time','$Departure_time','$Day_ID','$Time_ID')";
  // if (oci_execute(oci_parse($conn, $query))) {
  //   //Record Created messages!
  //   array_push($msg, "Recorded added sucessfully");
  // } else {
  //   array_push($errors, "Unable to create");
  // }
}

//update operation

if (isset($_POST['ti_update'])) {

  $Travel_code = $_POST['Travel_code'];
  $Arrival_time = $_POST['Arrival_time'];

  $Departure_time = $_POST['Departure_time'];
  $Day_ID = $_POST['Day_ID'];
  $Time_ID = $_POST['Time_ID'];


  $stmt = oci_parse($conn, 'BEGIN update_time(:p_tcode, :p_tdep, :p_tarrival, :p_tdid , :p_tid); END;');
  oci_bind_by_name($stmt, ':p_tcode', $Travel_code);
  oci_bind_by_name($stmt, ':p_tdep', $Departure_time);
  oci_bind_by_name($stmt, ':p_tarrival', $Arrival_time);
  oci_bind_by_name($stmt, ':p_tdid',  $Day_ID);
  oci_bind_by_name($stmt, ':p_tid', $Time_ID);

  // Execute the statement
  oci_execute($stmt);
  // Record Updated messages!
  array_push($upd, "Recorded Updated sucessfully");


  // $query = "UPDATE time SET Travel_code='$Travel_code', Arrival_time='$Arrival_time',Departure_time='$Departure_time'
  //                 WHERE  Time_ID='$Time_ID' AND Day_ID='$Day_ID'";
  // if (oci_execute(oci_parse($conn, $query))) {
  //   //Record Updated messages!
  //   array_push($upd, "Recorded Updated sucessfully");
  // } else {
  //   array_push($errors, "Unable to update");
  // }
}

//Delete opertaion

if (isset($_POST['ti_delete'])) {
  $Travel_code = $_POST['Travel_code'];
  $Arrival_time = $_POST['Arrival_time'];
  $Departure_time = $_POST['Departure_time'];
  $Day_ID = $_POST['Day_ID'];
  $Time_ID = $_POST['Time_ID'];

  $stmt = oci_parse($conn, 'BEGIN delete_time(:p_tid); END;');
  oci_bind_by_name($stmt, ':p_tid', $Travel_code);
  oci_execute($stmt);

  array_push($errors, "Recorded Deleted sucessfully");

  // $query = "DELETE FROM time WHERE Day_ID='$Day_ID' AND Time_ID='$Time_ID' ";
  // if (oci_execute(oci_parse($conn, $query))) {
  //   //Record deleted messages!
  //   array_push($errors, "Record Deleted sucessfully");
  // } else {
  //   array_push($errors, "Unable to Delete");
  // }
}

//create operation

if (isset($_POST['D_create'])) {

  $Day = $_POST['Day'];
  $Day_ID = $_POST['Day_ID'];
  $stmt = oci_parse($conn, 'BEGIN create_day(:p_did, :p_day ); END;');
  oci_bind_by_name($stmt, ':p_did', $Day_ID);
  oci_bind_by_name($stmt, ':p_day', $Day);
  // Execute the statement
  oci_execute($stmt);
  array_push($msg, "Recorded added sucessfully");

  // $query = "INSERT INTO Day_info (Day_ID,Day)
  //               VALUES ('$Day_ID','$Day')";
  // if (oci_execute(oci_parse($conn, $query))) {

  //   //Record Created messages!

  //   array_push($msg, "Recorded added sucessfully");
  // };
}

//update operation

if (isset($_POST['D_update'])) {
  $Day = $_POST['Day'];
  $Day_ID = $_POST['Day_ID'];

  $stmt = oci_parse($conn, 'BEGIN update_Day(:p_did, :p_day ); END;');
  oci_bind_by_name($stmt, ':p_did', $Day_ID);
  oci_bind_by_name($stmt, ':p_day', $Day);

  // Execute the statement
  oci_execute($stmt);
  // Record Updated messages!
  array_push($upd, "Recorded Updated sucessfully");

  // $query = "UPDATE Day_info SET Day='$Day'
  //               WHERE Day_ID='$Day_ID'";
  // if (oci_execute(oci_parse($conn, $query))) {
  //   //Record Updated messages!
  //   array_push($upd, "Recorded Updated sucessfully");
  // } else {
  //   array_push($errors, "Unable to update");
  // }
}

//Delete opertaion

if (isset($_POST['D_delete'])) {
  $Day = $_POST['Day'];
  $Day_ID = $_POST['Day_ID'];


  $stmt = oci_parse($conn, 'BEGIN delete_day(:p_did , :p_day); END;');
  oci_bind_by_name($stmt, ':p_did', $Day_ID);
  oci_bind_by_name($stmt, ':p_day', $Day);
  oci_execute($stmt);
  array_push($errors, "Recorded Deleted sucessfully");


  // $query = "DELETE FROM Day_info WHERE Day_ID='$Day_ID'";
  // if (oci_execute(oci_parse($conn, $query))) {
  //   //Record deleted messages!
  //   array_push($errors, "Recorded Deleted sucessfully");
  // } else {
  //   array_push($errors, "Unable to Delete");
  // }
}
