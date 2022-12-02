<?php include 'header.php'?>

<link rel="stylesheet" href="css/table.css">

<title>Spot Covid</title>

<body>

	<h1>COMMON VISITS WITHIN 2 HOURS</h1>

	<table class = "table_stores" id = "table1">
    <thead>
      <th><h1>Name</h1></th>
      <th><h1>Address</h1></th>
      <th><h1>Date of visit</h1></th>
      <th><h1>Date of positive visit of other user</h1></th>
    </thead>
    <tbody id="rows"></tbody>
	</table>

	<h1>COMMON VISITS WITHIN 7 DAYS</h1>

	<table class = "table_stores" id = "table2">
		<thead>
			<th><h1>Name</h1></th>
			<th><h1>Address</h1></th>
			<th><h1>Date of visit</h1></th>
			<th><h1>Date of positive visit of other user</h1></th>
		</thead>
		<tbody id="rowsb"></tbody>
	</table>

</body>
<script>
  $.ajax({
    url:"user_visits_backend.php",
    method:"POST",
    dataType:"json",
    success: function(data){
			console.log("User visits");
      console.log(data);

      $.ajax({
        url:'other_users_visits_backend.php',
        method:"POST",
        dataType:"json",
        success: function(data_other_users){
					console.log("Other user visits between 2 hours. But the check is below at line 52");
          console.log(data_other_users);
          var rows = document.getElementById('rows');

          for(let i=0;i<data.length;i++){
            for(let j=0;j<data_other_users.length;j++){
              let user_visit_datetime = moment(data[i].Date_of_upload).format();
              let other_users_visit_datetime = moment(data_other_users[j].Date_of_upload).format();

              let diff = Math.abs(moment(user_visit_datetime).diff(other_users_visit_datetime));
              let duration = moment.duration(diff);
              //console.log(duration._data.hours);
              if(data[i].id_store === data_other_users[j].id_store && duration._data.hours < 4){
                rows.innerHTML += "<tr><td>"+data[i].Name_store+"</td><td>"+data[i].Address_store+"</td><td>"+data[i].Date_of_upload+"</td><td>"+data_other_users[j].Date_of_upload+"</td></tr>";
              }

            }
          }
					$.ajax({
						url:"other_users_visits_backend_b.php",
						method:"POST",
						dataType:"json",
						success: function(data_other_users_b){
							console.log("Other user visits between 7 days before day of infection and today");
							console.log(data_other_users_b);
							var rowsb = document.getElementById('rowsb');


							for(let i=0;i<data.length;i++){
								for(let j=0;j<data_other_users_b.length;j++){
									if(data[i].id_store === data_other_users_b[j].id_store){
										rowsb.innerHTML += "<tr><td>"+data[i].Name_store+"</td><td>"+data[i].Address_store+"</td><td>"+data[i].Date_of_upload+"</td><td>"+data_other_users[j].Date_of_upload+"</td></tr>"
									}
								}
							}
						}

					});
        }

      });
    }

  });
</script>
