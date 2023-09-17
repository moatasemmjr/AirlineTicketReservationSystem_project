<?php include('flightdb.php') ?>
<?php include('loginvalid.php'); ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
  <meta charset="utf-8">
  <title>Search Flights</title>
  <link rel="stylesheet" href="../css/usersearch.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
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
              <a class="nav-link" href="#"><i class="fa fa-plane" aria-hidden="true"></i>flight schedules</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#"><i class="fa fa-question-circle" aria-hidden="true"></i>about us</a>
            </li>
            <?php if (isset($_SESSION['uname'])) : ?>
              <li class="nav-item">
                <a class="nav-link" href="ticket.php"><i class="fas fa-receipt" aria-hidden="true"></i>Your Bookings</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="usersearch.php?searchlogout='1'"><i class="fa fa-sign-out" aria-hidden="true"></i>Sign Out</a>
              </li>
            <?php else : ?>
              <li class="nav-item">
                <a class="nav-link" href="signin.php?logout=1"><i class="fa fa-sign-in" aria-hidden="true"></i>Sign In</a>
              </li>
            <?php endif ?>
          </ul>
        </div>
      </nav>

      <section id="box">
        <div class="container text-center ">
          <h1 class="py-4 bg-dark text-light "> <i class="fas fa-paper-plane" aria-hidden="true"></i> Search Flights</h1>
          <section id="Alertmsg">
            <div class="alertmsg ">
              <div class="alert alert-info alert-dismissible fade show " role="alert">
                <strong>Hey User!</strong> Feel free to leave any input field(s) empty. Our server is User Friendly.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            </div>
            <script type="text/javascript">
              $('.alert').alert()
            </script>
          </section>
          <div class="d-flex justify-content-center ">
            <form class="w-50" action="" method="post">
              <div class="row">
                <div class="col">
                  <div class="input-group mb-2 ">
                    <div class="input-group-prepend">
                      <div class="input-group-text bg-warning"><i class="fas fa-plane-departure"></i></div>
                    </div>
                    <input type="text" autocomplete="off" name="From" placeholder="From" class="form-control" id="inlineFormInputGroup">
                  </div>
                </div>
                <div class="col">
                  <div class="input-group mb-2 ">
                    <div class="input-group-prepend">
                      <div class="input-group-text bg-warning"><i class="fas fa-plane-arrival" aria-hidden="true"></i></div>
                    </div>
                    <input type="text" autocomplete="off" name="To" placeholder="To" class="form-control" id="inlineFormInputGroup">
                  </div>

                </div>
              </div>
              <div class="input-group mb-2 ">
                <div class="input-group-prepend">
                  <div class="input-group-text bg-warning"><i class="fa fa-plane" aria-hidden="true"></i></div>
                </div>
                <input type="text" autocomplete="off" name="Flight_name" placeholder="Flight Name" class="form-control" id="inlineFormInputGroup">
              </div>
              <div class="input-group mb-2  w-50 ">
                <div class="input-group-prepend ">
                  <div class="input-group-text bg-warning  "><i class="fas fa-calendar-day" aria-hidden="true"></i></div>
                </div>
                <select class="custom-select" name="Day">
                  <option selected disabled>Choose Your Day Of Travel</option>
                  <option name="Day" value="1">Sunday</option>
                  <option name="Day" value="2">Monday</option>
                  <option name="Day" value="3">Tuesday</option>
                  <option name="Day" value="4">Wednesday</option>
                  <option name="Day" value="5">Thursday</option>
                  <option name="Day" value="6">Friday</option>
                  <option name="Day" value="7">Saturday</option>
                </select>
              </div>
              <div class="d-flex justify-content-center search">
                <button type="submit" class="btn btn-success w-50" name="Search"><i class="fa fa-search" aria-hidden="true"></i><strong>Search</strong></button>
              </div>
            </form>
          </div>
          <?php
          if (isset($_POST['Search'])) { ?>

            <?php
            $te = oci_parse($conn, "ALTER SESSION SET nls_date_format = 'HH24:MI:SS'");
            oci_execute($te);
            $dbstr = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 127.0.0.1)(PORT = 1521)))(CONNECT_DATA=(SID=orcl)))";

            $user = "test3";
            $password = "123";

            $conn = oci_connect($user, $password, $dbstr);
            $Flight_name = $_POST['Flight_name'];
            $Departure = $_POST['From'];
            $Arrival = $_POST['To'];
            if (isset($_POST['Day'])) {
              $Day_ID = $_POST['Day'];
            } else {
              $Day_ID = "";
            }
            $result = oci_parse($conn, "SELECT F.Flight_name,T.Departure,T.Travel_code,T.Arrival,C.Departure_time,C.Arrival_time,C.Time_ID,D.Day,D.Day_ID,cp.Price
            FROM flight_info F , travel_info T,time C,day_info D, cprice_info cp  WHERE F.Flight_name
            LIKE '%$Flight_name%' AND T.Departure LIKE '%$Departure%' AND D.Day_ID LIKE '%$Day_ID%' AND T.Arrival LIKE '%$Arrival%' AND
            F.Flight_ID=T.Flight_ID AND C.Travel_code=T.Travel_code AND D.Day_ID=C.Day_ID AND
            cp.Travel_code=T.Travel_code AND cp.Cno=1");
            oci_execute($result);
            $bresult = oci_parse($conn, "SELECT F.Flight_name,T.Departure,T.Travel_code,T.Arrival,C.Departure_time,C.Arrival_time,C.Time_ID,D.Day,D.Day_ID,cp.Price
                              FROM flight_info F , travel_info T,time C,day_info D, cprice_info cp  WHERE F.Flight_name
                              LIKE '%$Flight_name%' AND T.Departure LIKE '%$Departure%' AND D.Day_ID LIKE '%$Day_ID%' AND T.Arrival LIKE '%$Arrival%' AND
                              F.Flight_ID=T.Flight_ID AND C.Travel_code=T.Travel_code AND D.Day_ID=C.Day_ID AND
                              cp.Travel_code=T.Travel_code AND cp.Cno=2");
            oci_execute($bresult);
            $fresult = oci_parse($conn, "SELECT F.Flight_name,T.Departure,T.Travel_code,T.Arrival,C.Departure_time,C.Arrival_time,C.Time_ID,D.Day,D.Day_ID,cp.Price
                              FROM flight_info F , travel_info T,time C,day_info D, cprice_info cp  WHERE F.Flight_name
                              LIKE '%$Flight_name%' AND T.Departure LIKE '%$Departure%' AND D.Day_ID LIKE '%$Day_ID%' AND T.Arrival LIKE '%$Arrival%' AND
                              F.Flight_ID=T.Flight_ID AND C.Travel_code=T.Travel_code AND D.Day_ID=C.Day_ID AND
                              cp.Travel_code=T.Travel_code AND cp.Cno=3");

            oci_execute($fresult);
            $res = array();
            $count = oci_fetch_all($result, $res);
            // print_r($res['FLIGHT_NAME']);
            oci_execute($result);
            echo $count;
            if ($count == 0) { ?>
              <div class="modal fade" data-backdrop="false" keyboard="True" id="mymodal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Message</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <div class="alert alert-danger" role="alert">
                        No such Flights are available. Try changing in the input fields.
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              <script>
                $(document).ready(function() {
                  $("#mymodal").modal('show');
                });
              </script>
              <div class="alert alert-warning" role="alert">
                No such Flights are available. Try changing in the input fields.
              </div>
            <?php
            } else {
            ?>
              <div class="alert alert-warning" role="alert">
                <?php if ($count == 1) : ?> 1 Flight is available.
                <?php else : ?>
                  <?php echo $count; ?> Flights are available.
                <?php endif ?>
              </div>
              <section id="table1">
                <div class="table-responsive">
                  <div class="d-flex table-data ">
                    <table class="table table-striped table-light table-hover">
                      <thead class="thead-dark">
                        <tr>
                          <th>Flight ID</th>
                          <th>Departure</th>
                          <th>Arrival</th>
                          <th>Economy</th>
                          <th>Buisness</th>
                          <th>First class</th>
                          <th>Departure Time</th>
                          <th>Arrival Time</th>
                          <th>Day</th>
                          <th>Book</th>
                        </tr>
                      </thead>
                      <tbody id="tbody">
                        <?php
                        while ($count != 0) {
                          $row = oci_fetch_array($result);
                          $brow = oci_fetch_array($bresult);
                          $frow = oci_fetch_array($fresult);
                        ?>
                          <tr>
                            <td><?php echo $row[0]; ?></td>
                            <td><?php echo $row[1]; ?></td>
                            <td><?php echo $row[3]; ?></td>
                            <td><?php echo $row[9]; ?></td>
                            <td><?php echo $brow[9]; ?></td>
                            <td><?php echo $frow[9]; ?></td>
                            <td><?php echo $row[4]; ?></td>
                            <td><?php echo $row[5]; ?></td>
                            <td><?php echo $row[7];
                                $count--; ?></td>

                            <td> <?php if (isset($_SESSION['uname'])) : ?>
                                <a href="booking.php?Book=<?php echo $row[2]; ?>&Day=<?php echo $row[8]; ?>&Time_ID=<?php echo $row[6]; ?>" <button type="submit" class="btn btn-primary my-0 py-1 px-2" data-toggle="tooltip" data-placement="bottom" title="Book" name="button">
                                  <i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button></a>
                              <?php else :
                                    $_SESSION['mesage'] = "You must login to book tickets";
                              ?>
                                <a href="signin.php?Book=<?php echo $row[2]; ?>&Day=<?php echo $row[8]; ?>&Time_ID=<?php echo $row[6]; ?>" <button type="submit" class="btn btn-primary my-0 py-1 px-2" data-toggle="tooltip" data-placement="bottom" title="Book" name="button">
                                  <i class="fa fa-cart-arrow-down" aria-hidden="true"></i></button></a>
                              <?php endif ?>
                            </td>

                          </tr>
                      <?php
                        }
                      }
                      ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </section>
            <?php } ?>




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
              <form class="" method="post">
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