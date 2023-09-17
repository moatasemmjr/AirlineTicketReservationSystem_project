<?php
$dbstr ="(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 127.0.0.1)(PORT = 1521)))(CONNECT_DATA=(SID=orcl)))";

$user = 'test3';
$password = 'hr';
$conn = oci_connect($user, $password, $dbstr);





$result = oci_parse($conn, "SELECT F.Flight_name,F.Seats,T.Departure,T.Arrival,P.Price,P.Travel_type,C.Departure_time,C.Arrival_time,D.Day,U.Pname,U.Type,U.paid_by,U.ID
          FROM flight_info F , travel_info T, price P,time C,day_info D,passenger_info U
          WHERE  F.Flight_ID=T.Flight_ID AND P.Travel_code=T.Travel_code AND C.Travel_code=P.Travel_code AND D.Day_ID=C.Day_ID AND U.Travel_code=C.Travel_code  AND C.Time_ID=U.Time_ID AND U.paid_by='$paid_by'
          AND C.Time_ID IN  (SELECT DISTINCT Time_ID FROM passenger_info WHERE paid_by='$paid_by')");
oci_execute($result);
$te = oci_parse($conn, "ALTER SESSION SET nls_date_format = 'HH24:MI:SS'");
oci_execute($te);
for ($i=0; $i<$count ; $i++) {
  if(isset($_POST[$i])){
    for ($j=0; $j <$i+1 ; $j++) {
    $row=oci_fetch_row($result);
    if($j==$i){
      $ID=$row['ID'];
      $del=oci_parse($conn,"DELETE FROM passenger_info WHERE ID='$ID'");
      if($del){


        break;
      }
}
    }

  }
}
header("Location:ticket.php");
?>
