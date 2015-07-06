<?php
include 'dbc.php';
include 'PrayTime.php';
date_default_timezone_set('Asia/Kuala_Lumpur');
$today = getdate();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>SolatApi</title>

<!-- Google fonts -->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,700' rel='stylesheet' type='text/css'>

<!-- font awesome -->
<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

<!-- bootstrap -->
<link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css" />

<!-- animate.css -->
<link rel="stylesheet" href="assets/animate/animate.css" />
<link rel="stylesheet" href="assets/animate/set.css" />

<!-- gallery -->
<link rel="stylesheet" href="assets/gallery/blueimp-gallery.min.css">

<!-- favicon -->
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">


<link rel="stylesheet" href="assets/style.css">

</head>

<body>
<div class="topbar animated fadeInLeftBig"></div>

<!-- Header Starts -->
<div class="navbar-wrapper">
      <div class="container">

        <div class="navbar navbar-default navbar-fixed-top" role="navigation" id="top-nav">
          <div class="container">
            <div class="navbar-header">
              <!-- Logo Starts -->
              <h1><a class="navbar-brand" href="#home">SolatApi</a></h1>
              <!-- #Logo Ends -->


              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>

            </div>


            <!-- Nav Starts -->
            <div class="navbar-collapse  collapse">
              <ul class="nav navbar-nav navbar-right">
                 <li class="active"><a href="#works">Home</a></li>
                 <li ><a href="#about">About</a></li>
                 <li ><a href="api.php" target="_blank">Api</a></li>
              </ul>
            </div>
            <!-- #Nav Ends -->

          </div>
        </div>

      </div>
    </div>
<!-- #Header Starts -->

<!-- senarai -->
<div id="works"  class=" clearfix grid">
<?php
    
    $sql =  "SELECT * FROM `location` ORDER BY `tempat`";
    $result = mysql_query($sql)or die(mysql_error());
    $count = 1;
    while($row = mysql_fetch_array($result)){
    $url = "https://maps.googleapis.com/maps/api/geocode/json?key=[google key]&address=".urlencode($row['tempat']);
        $json = file_get_contents($url);
        $data = json_decode($json);
        $lat = $data->results[0]->geometry->location->lat;
        $lng = $data->results[0]->geometry->location->lng;
        list($method, $year, $latitude, $longitude, $timeZone) = array(5, $today['year'], $lat, $lng, 8);    
        $prayTime = new PrayTime($method);
        $date = strtotime($year.'-'.$today['mon'].'-'.$today['mday']);
        $endDate = strtotime($year.'-'.$today['mon'].'-'.($today['mday']+1));
        
        echo "<figure class=\"effect-oscar  wowload fadeInUp\">";
        echo "<img src=\"images/portfolio/".$count.".jpg\" alt=\"img01\"/>";
        echo "<figcaption>";
        echo "<h2>".$row['tempat']."</h2>";
        while ($date < $endDate)
        {
            $times = $prayTime->getPrayerTimes($date, $latitude, $longitude, $timeZone);
            $day = date('M d', $date);
            echo "<p>Fajr - ".$times[0]."<br>Sunrise - ".$times[1]."<br>Dhuhr - ".$times[2]."<br>Asr - ".$times[3]."<br>Sunset - ".$times[4]."<br>Maghrib - ".$times[5]."<br>Isha - ".$times[6]."</p>";
            $date += 24* 60* 60;  // next day
        }
        echo "</figcaption>";
        echo "</figure>";
        $count++;
     }
?>
</div>
<!-- senarai tempat -->

<!-- Footer Starts -->
<div class="footer text-center spacer">
<p class="wowload flipInX">
    <a href="https://www.facebook.com/treakyidea"><i class="fa fa-facebook fa-2x"></i></a>
    <a href="https://my.linkedin.com/pub/treaky-idea/98/b47/a96"><i class="fa fa-github fa-2x"></i></a>
    <a href="https://github.com/Treakyidea/solatapi"><i class="fa fa-linkedin fa-2x"></i></a></p>
Design By Cyrus Creative Studio. All rights reserved.
</div>
<!-- # Footer Ends -->
<a href="#works" class="gototop "><i class="fa fa-angle-up  fa-3x"></i></a>





<!-- The Bootstrap Image Gallery lightbox, should be a child element of the document body -->
<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
    <!-- The container for the modal slides -->
    <div class="slides"></div>
    <!-- Controls for the borderless lightbox -->
    <h3 class="title">Title</h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->    
</div>



<!-- jquery -->
<script src="assets/jquery.js"></script>

<!-- wow script -->
<script src="assets/wow/wow.min.js"></script>


<!-- boostrap -->
<script src="assets/bootstrap/js/bootstrap.js" type="text/javascript" ></script>

<!-- jquery mobile -->
<script src="assets/mobile/touchSwipe.min.js"></script>
<script src="assets/respond/respond.js"></script>

<!-- gallery -->
<script src="assets/gallery/jquery.blueimp-gallery.min.js"></script>

<!-- custom script -->
<script src="assets/script.js"></script>

</body>
</html>
