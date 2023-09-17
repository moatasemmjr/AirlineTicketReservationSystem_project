<?php session_start(); ?>
<?php if (isset($_POST['checkout'])) {


  $dbstr = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 127.0.0.1)(PORT = 1521)))(CONNECT_DATA=(SID=orcl)))";

  $user = 'test3';
  $password = '123';
  $conn = oci_connect($user, $password, $dbstr);

  // $te = oci_parse($conn, "ALTER SESSION SET nls_date_format = 'HH24:MI:SS'");
  // oci_execute($te);
  

  $Pname = array();
  $Gender = array();
  $type = $_GET['type'];
  $paid_by = $_SESSION['uname'];
  $Day_ID = $_SESSION['dayid'];
  $p_type = $_SESSION['class'];
  $Time_ID = $_SESSION['Time_ID'];
  $Pname = $_POST['Pname'];
  $Gender = $_POST['Gender'];
  $reduce = "UPDATE flight_info
  SET Seats = Seats - :num
  WHERE Flight_ID = (SELECT Flight_ID FROM travel_info WHERE Travel_code = :tcode)";



  $stmt = oci_parse($conn, $reduce);
  oci_bind_by_name($stmt, ':num', $_SESSION['num']);
  oci_bind_by_name($stmt, ':tcode', $_SESSION['tcode']);
  oci_execute($stmt);

  
  for ($i = 0; $i < $_SESSION['num']; $i++) {

    $query = "begin add_passenger_info(:p_tcode, :p_Pname, :p_Gender, :p_Day_ID, :p_type, :p_paid_by, :p_Time_ID); end;";
    // $query = "INSERT INTO passenger_info  VALUES ({$_SESSION['tcode']},'$Pname[$i]','$Gender[$i]','$paid_by',$Day_ID,'$Class','$Time_ID')";


    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ':p_tcode', $_SESSION['tcode']);
    oci_bind_by_name($stmt, ':p_Pname', $Pname[$i]);
    oci_bind_by_name($stmt, ':p_Gender', $Gender[$i]);
    oci_bind_by_name($stmt, ':p_Day_ID', $Day_ID);
    oci_bind_by_name($stmt, ':p_type', $p_type);
    oci_bind_by_name($stmt, ':p_paid_by', $paid_by);

    oci_bind_by_name($stmt, ':p_Time_ID', $Time_ID);
    oci_execute($stmt);


    //Record Created messages!
    echo "Recorded added sucessfully";
  }

  $re = oci_parse($conn, "SELECT Price FROM cprice_info WHERE Travel_code={$_SESSION['tcode']} AND Cno='$type'");
  oci_execute($re);

  $row = oci_fetch_row($re);
  $Price = $row[0];
  header("Location:payment.php?Price=$Price");
}
if (isset($_POST['pbtn'])) {
  echo '<script>alert("Welcome to Geeks for Geeks")</script>';

  header("Location:homepage.php");
}

?>
