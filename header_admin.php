<!DOCTYPE html>
<html>
<head>
  <!--momentjs for dates-->
  <script src="external_code/moment.js"></script>
  <script src="external_code/moment-with-locales.js"></script>
  
  <!--for custom alerts-->
  <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!--for jquery-->
  <script src="external_code/jquery.js"></script>

  <!--Custom css-->
  <link rel="stylesheet" href="css/style_header.css">

  <!--Chart js-->
  <script src="external_code/chart.js"></script>

  <!--link for the logos in sidebar-->
  <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
  <div class="sidebar">

     <div class="logo_content">
         <div class="logo">
           <i class='bx bxl-world'> </i>
           <div class="logo_name">Mapslia</div><!--It has to be clicked and redirect to Welcome page-->
         </div>
          <i class='bx bx-menu' id="btn" ></i>
      </div>
       <ul class="nav_list">

         <li>
           <a href="Welcome_page_admin.php">
           <i class='bx bx-home'></i>
           <span class="links_name">Home</span>
           </a>
           <span class="tooltip">Home</span>
          </li>

          <li>
            <a href="Upload_data_admin.php">
            <i class='bx bx-upload' ></i>
            <span class="links_name">Upload data</span>
            </a>
            <span class="tooltip">Upload data</span>
           </li>

          <li>
            <a href="Visualization_charts.php">
            <i class='bx bxs-data'></i>
            <span class="links_name">Visualization Data Charts</span>
            </a>
            <span class="tooltip">Visualization Data Charts</span>
           </li>

          <li>
            <a href="Visualization_tables.php">
            <i class='bx bx-table' ></i>
            <span class="links_name">Visualization Data Tables</span>
            </a>
            <span class="tooltip">Visualization Data Tables</span>
           </li>

           <li>
             <a href="Logout.php">
             <i class='bx bx-log-out' id="logout" ></i>
             </a>
           </li>

        </ul>
   </div>
</body>

<script>
 let btn = document.querySelector("#btn");
 let sidebar = document.querySelector(".sidebar");
 let links = document.querySelector(".links_name");


btn.onclick = function() {
  console.log(sidebar.classList);
  console.log(links.classList);
  sidebar.classList.toggle("active");
  links.classList.toggle("active");
  links.classList.toggle("links_name");
}
</script>
</html>
