<!DOCTYPE html>
<html>
<head>

  <!--for custom alerts-->
  <link rel="stylesheet" href="external_code/sweetalert2.min.css"/>
  <script src="external_code/sweetalert2.all.min.js"></script>

  <!--for jquery-->
  <script src="external_code/jquery.js"></script>

  <!--custom css-->
  <link rel="stylesheet" type="text/css" href="css/style_header.css">

  <!--for leaflet map-->
  <link rel="stylesheet" href="external_code/leaflet.css" />
  <script src="external_code/leaflet.js"></script>

  <!--for markerClusterGroup-->
  <link rel="stylesheet" href="external_code/Leaflet.markercluster-1.4.1/dist/markerCluster.css">
  <link rel="stylesheet" href="external_code/Leaflet.markercluster-1.4.1/dist/markerCluster.Default.css">
  <script src="external_code/Leaflet.markercluster-1.4.1/dist/leaflet.markercluster.js"></script>

  <!--for search -->
  <link rel="stylesheet" href="external_code/search/leaflet-search.css">
  <script src="external_code/search/leaflet-search.js"></script>

  <!--momentjs for dates-->
  <script src="external_code/moment.js"></script>
  <script src="external_code/moment-with-locales.js"></script>

  <!--underscore.js-->
  <script src="external_code/underscore.js"></script>

  <!--bootstrap Registration and Login-->
  <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">

  <!--Link for logos-->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>


</head>

<body>
<!--<nav role="navigation">
  <div id="menuToggle">
    <input type="checkbox"/>

    <span></span>
    <span></span>
    <span></span>

    <ul id="menu">
      <a href="Welcome_page.php"><li>Home</li></a>
      <a href="Map.php"><li>Map</li></a>
      <a href="Covid.php"><li>Covid Declaration</li></a>
      <a href="Common_visits_with_positive_covid.php"><li>Spot Covid</li></a>
      <a href="Logout.php"><li>Logout</li></a>
    </ul>

  </div>
</nav>-->
<!--Mapslia-->

<div class="sidebar">
	<div class="logo_content">
		<div class="logo">
			<i class='bx bxl-world'> </i>
			<div class="logo_name">Mapslia</div>
		</div>
		 <i class='bx bx-menu' id="btn" ></i>
	</div>
		<ul class="nav_list">
  		 <li>
  		  <a href="Welcome_page.php">
  		   <i class='bx bx-grid-alt'></i>
  		   <span class="links_name">Home</span>
  		   </a>
  		   <span class="tooltip">Home</span>
  		  </li>

  		   <li>
  		  <a href="Map.php">
  		   <i class='bx bx-map-alt'></i>
  		   <span class="links_name">Map</span>
  		   </a>
  		   <span class="tooltip">Map</span>
  		  </li>

  		 <li>
  		  <a href="Covid.php">
  		   <i class='bx bxs-virus'></i>
  		   <span class="links_name">Covid</span>
  		   </a>
  		   <span class="tooltip">Covid</span>
  		  </li>

  		 <li>
  		  <a href="Common_visits_with_positive_covid.php">
  		   <i class='bx bx-current-location'></i>
  		   <span class="links_name">Spot Covid</span>
  		   </a>
  		   <span class="tooltip">Spot Covid</span>
  		  </li>

        <li>
         <a href="Profile_Management.php">
          <i class='bx bx-user'></i>
          <span class="links_name">Profile Management</span>
          </a>
          <span class="tooltip">Profile Management</span>
         </li>

        <li>
          <a href="Logout.php">
    		  <i class='bx bx-log-out' id="logout" ></i>
          </a>
        </li>

		 </ul>
</div>

<script>
   let btn = document.querySelector("#btn");
   let sidebar = document.querySelector(".sidebar");
   let links = document.querySelector(".links_name");

  btn.onclick = function() {
    sidebar.classList.toggle("active");
    links.classList.toggle("active");
    links.classList.toggle("links_name");
  }
</script>

</body>
</html>
