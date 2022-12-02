<?php include 'header_admin.php'?>

<title>Visualization admin</title>

<div class = "container">
  <canvas id = "lineChart" width="400" height="200" aria-label="Hello ARIA World" role="img"></canvas>
</div>

<script>
  $.ajax({
    url:"Visualization_charts_backend.php",
    type:"POST",
    dataType:"json",
    success: function(data){

      console.log(data);

      //https://www.chartjs.org/docs/latest/
      //https://www.chartjs.org/samples/2.6.0/charts/bar/vertical.html

      let positive_visits = data.shift();
      let positive_users = data.shift();
      let positive_visits_between = data.length;
      console.log(positive_visits_between);

      var data = {
        labels: [""],
        datasets:[{
          label:"positive visits",
          fillColor:"red",
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor:'rgba(75, 192, 192, 0.2)',
          borderWidth: 1,
          data: [positive_visits.positive_visits]
        },{
          label:"positive users",
          fillColor:"green",
          backgroundColor: 'rgba(54, 162, 235, 0.2)',
          borderColor:'rgba(54, 162, 235, 0.2)',
          borderWidth: 1,
          data: [positive_users.positive_users]
        },{
          label:"positive ",
          fillColor:"blue",
          backgroundColor: 'rgba(255, 99, 132, 0.2)',
          borderColor:'rgba(255, 99, 132, 0.2)',
          borderWidth: 1,
          data: [positive_visits_between]
        }]
      };

        var ctx = document.getElementById("lineChart").getContext('2d');
        const myChart = new Chart(ctx,{
          type: 'bar',
          data: data,
          options: {
            scales:{
              y:{
                beginAtZero: true
              }
            },
            responsive: true,
            legend: {
              position: 'top',
            },
            title:{
              display:true,
              text: 'Chart.js Bar Chart'
            }
          }
        });
      }


  });
</script>
