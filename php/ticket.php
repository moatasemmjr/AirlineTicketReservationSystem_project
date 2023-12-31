<?php include('flightdb.php') ?>
<?php include('loginvalid.php'); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Ticket Summary</title>
  <link rel="stylesheet" href="../css/ticket.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@500&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/e4eecd86d3.js"></script>
</head>

<body>

  <section class="header">
    <section id="nav-bar">
      <nav class="navbar navbar-expand-lg navbar-light">
        <a class="navbar-brand" href="#"><img class="img" src="../img/travel.png">Airline reservation system</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <?php if (isset($_SESSION['uname'])) : ?>
                <a class="nav-link" id="user" href="#"><?php echo "Welcome " . $_SESSION['uname']; ?></a>
              <?php endif ?>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="homepage.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="usersearch.php"><i class="fa fa-plane" aria-hidden="true"></i>flight schedules</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fa fa-question-circle" aria-hidden="true"></i>about us</a>
            </li>
            <?php if (isset($_SESSION['uname'])) : ?>
              <li class="nav-item">
                <a class="nav-link" href="usersearch.php?searchlogout='1'"><i class="fa fa-sign-out" aria-hidden="true"></i>Sign Out</a>
              </li>
            <?php else : ?>
              <li class="nav-item">
                <a class="nav-link" href="signin.php"><i class="fa fa-sign-in" aria-hidden="true"></i>Sign In</a>
              </li>
            <?php endif ?>
          </ul>
        </div>
      </nav>
    </section>
  </section>
  <section id="php">


    <?php
    $paid_by = $_SESSION['uname'];

    $dbstr ="(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 127.0.0.1)(PORT = 1521)))(CONNECT_DATA=(SID=orcl)))";

    $user = "test3";
    $password = "123";

    $conn = oci_connect($user, $password, $dbstr);
    $te = oci_parse($conn, "ALTER SESSION SET nls_date_format = 'HH24:MI:SS'");
    oci_execute($te);
    $result = oci_parse($conn, "SELECT F.Flight_name,F.Seats,T.Departure,T.Arrival,cp.Price,cl.Cname,C.Departure_time,C.Arrival_time,D.Day,U.Pname,U.paid_by
    FROM flight_info F , travel_info T, cprice_info cp,time C,day_info D,passenger_info U, class cl
    WHERE  F.Flight_ID=T.Flight_ID AND cp.Travel_code=T.Travel_code AND C.Travel_code=T.Travel_code AND D.Day_ID=C.Day_ID AND U.Travel_code=T.Travel_code
    AND C.Time_ID=U.Time_ID AND U.paid_by='$paid_by'
    AND cp.Cno=U.Type AND cp.Cno IN (SELECT DISTINCT  TYPE FROM passenger_info WHERE paid_by='$paid_by')
    AND cl.Cno=Cp.Cno AND cl.Cno IN  (SELECT DISTINCT  TYPE FROM passenger_info WHERE paid_by='$paid_by')
    AND C.Time_ID IN  (SELECT DISTINCT Time_ID FROM passenger_info WHERE paid_by='$paid_by')");
    oci_execute($result);
    $d = array();
    
    $count = oci_fetch_all($result, $d);
    oci_execute($result);
    
    ?>
  </section>
  <section id="container">
    <div class="container text-center w-100">
      <h1 class="py-4 m-0 bg-primary text-light "><i class="fas fa-receipt"></i> Your Bookings</h1>
    </div>
    <?php if ($count > 0) { ?>
      <div class="text-center">
        <div class="alert alert-primary" role="alert">
          Have a happy journey!! Print your tickets
          <a href="#" onclick="window.print()">Here.</a>
        </div>
      </div>
      <?php for ($i = 0; $i < $count; $i = $i + 1) {
        $row = oci_fetch_array($result);

      ?>
        <div class="row" id="section-to-print">
          <div class="col-md-6 text-center fname">
            <h1><i class="fas fa-plane-departure"></i><?php echo $row[0]; ?></h1><br>
            <div class="cancel">

            </div>
          </div>
          <div class="col-md-3 content ">
            <p class="lead"><strong>Passenger Name: </strong><?php echo $row[9]; ?></p>
            <p class="lead"><strong>Departure: </strong><?php echo $row[2]; ?></p>
            <p class="lead"><strong>Arrival: </strong><?php echo $row[3]; ?></p>
            <p class="lead"><strong>Departure time: </strong><?php echo $row[6]; ?></p>
            <p class="lead"><strong>Arrival time: </strong><?php echo $row[7]; ?></p>
          </div>
          <div class="col-md-3 content">
            <p class="lead"><strong>Type: </strong><?php echo $row[5]; ?></p>
            <p class="lead"><strong>Day: </strong><?php echo $row[8]; ?></p>
            <p class="lead"><strong>Flight name: </strong><?php echo $row[0]; ?></p>
            <p class="lead"><strong>Price Paid: </strong><i class="fa fa-inr" aria-hidden="true"><?php echo $row[4]; ?></i></strong></p>
            <p class="lead"><strong>Paid by: </strong><?php echo $row[10]; ?></p>

          </div>
        </div>

      <?php
      }
      ?>
      <div class="extra text-center">

        <img src="extra.svg" alt="">
      </div><?php
          } else {
            ?>
      <div class="text-center">
        <div class="alert alert-primary" role="alert">
          Oops! such emptiness <a href="usersearch.php" class="alert-link">Book Now</a> and travel with joy.
        </div>
      </div>
      <div class="text-center">
        <div class="space">
          <img src="empty.svg" alt="">
        </div>
      </div>
    <?php
          }
    ?>
  </section>


  <section class="footer">
    <div class="container">
      <div class="row">
        <div class="col-md-3 footer-info">
          <div class="ftitle">
            <h3>Airline Reservation System.</h3>
          </div>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud.</p>
        </div>
        <div class="col-md-3 footer-links">
          <h3>Menu</h3>
          <ul>
            <li><i class="fa fa-home" aria-hidden="true"></i><a href="#">Home</a></li>
            <li><i class="fa fa-ticket" aria-hidden="true"></i><a href="#">Book tickets</a></li>
            <li><i class="fa fa-plane" aria-hidden="true"></i><a href="#">Flight Schedules</a></li>
            <li><i class="fa fa-question-circle" aria-hidden="true"></i><a href="#">About us</a></li>
            <li><i class="fa fa-phone" aria-hidden="true"></i><a href="#">Contct us</a></li>
          </ul>
        </div>
        <div class="col-md-3 footer-social">
          <h3>Follow us</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>

          <a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
          <a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
          <a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
          <a href="#" <i class="fa fa-whatsapp" aria-hidden="true"></i></a>
          <a href="#"><i class="fa fa-tumblr" aria-hidden="true"></i></a>
        </div>
        <div class="col-md-3 Newsletter">
          <h3>Our Newsletter</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore.</p>
          <form class="foot" method="post">
            <input type="email" class="email" name="" placeholder="Email">
            <input type="submit" class="submit" name="" value="Subscribe">
          </form>
        </div>
      </div>

    </div>
    <div class="box">
      <div class="copyright">
        &copy; copyright <strong>Airline Reservation system</strong>.All rights reserved.
        Designed with <i class="fa fa-heart" aria-hidden="true"></i> by 19CE1105,19BCE1460,19BCE1574
      </div>
    </div>
  </section>

</body>

</html>