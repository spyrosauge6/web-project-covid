<?php include 'header.php'?>
<title>Declare Covid</title>
<link rel="stylesheet" type="text/css" href="css/Covid.css">
<body>
   <div class="wrapper fadeInDown">
   <div id="formContent">
   <div class="container">
  <h2 for="meeting-time">When you were diagnosed with covid-19:</h2>

<input type="datetime-local" id="covid_date" name="meeting-time" min="2021-01-01T00:00" max="2022-12-31T00:00">
<button id="Upload_button" onclick="Declare_Covid()">Upload</button>
<br><br><br>
<table>
  <thead>
    <th>Covid_date</th>
  </thead>
  <tbody id="rows"></tbody>
</table>
</body>
<script>

var Declare_covid = [];
//set time function taken by:https://tecadmin.net/get-current-date-time-javascript/
var current_datetime_value = new Date();
current_datetime_value.setMinutes(current_datetime_value.getMinutes() - current_datetime_value.getTimezoneOffset());
document.getElementById('covid_date').value = current_datetime_value.toISOString().slice(0,16);

//MS PER DAY
const _MS_PER_DAY = 1000 * 60 * 60 * 24;

//In this part i will add to the HTML table the covid declaration date of the user
$.ajax({
  url:"Covid_dates_backend.php",
  method:"POST",
  dataType:"json",
  success: function(response){
    rows = document.getElementById('rows');
    for(let i=0;i<response.length;i++){
      rows.innerHTML += "<tr><td>"+response[i]+"</tr></td>"
    }
  }
});


//Difference for datetime https://stackoverflow.com/a/18675981/14749665
function check_dates(user_date,user_past_date){
  var moment_user_date = moment(user_date, 'M/D/YYYY');
  var moment_user_past_date = moment(user_past_date, 'M/D/YYYY');

  console.log(moment_user_date);
  console.log(moment_user_past_date);

  var diff_days = moment_user_date.diff(moment_user_past_date, 'days');
  console.log(diff_days);
  if(Math.abs(diff_days)<14){
    return false;
  }else{
    return true;
  }
}


//function that is activated after the click of the button
function Declare_Covid(){

	//Covid date that the user chose
  let date = document.getElementById('covid_date').value;

  //Date object with the date of user input
  var user_datetime = new Date(date);

  //Date object with the current datetime
  var current_datetime = new Date();

  Swal.fire({
    titleText:'Are you sure?',
    text:`Are you sure you want to upload your Covid-Case in ${moment(date).format('MMMM Do YYYY, h:mm:ss a')}?`,
    showCancelButton: true,
    cancelButtonColor: '#d33',
    allowEnterKey:false,
    allowEscapeKey:false,
    confirmButtonText:"Yes,upload it",
  }).then((result)=>{
    if(result.isConfirmed){
      if((user_datetime > current_datetime) === true){
        Swal.fire({
          textTitle:"Covid Case",
          text:"You cannot declare your covid case for the future. Nice try!",
          allowEnterKey:false,
          allowEscapeKey:false
        }).then(function(){
          window.location.reload();
        })
      }else{
        $.ajax({
          url:"Covid_cases_backend.php",
          method:"POST",
          dataType:"json",
          success: function(response){
            console.log(response);



            for(let i=0;i<response.length;i++){
              let user_past_covid_cases = new Date(response[i].date_of_infection);
              console.log(user_datetime);
              console.log(user_past_covid_cases);
              Declare_covid.push(check_dates(user_datetime, user_past_covid_cases));

            }

            if(Declare_covid.includes(false)){
              Swal.fire({
                text:"14 days must pass to declare again your covid case"
              }).then(function(){
                window.location.reload();
              });
            }else{
              $.ajax({
                url:"Upload_positive_covid_backend.php",
                method:"POST",
                dataType:"text",
                data:{date:moment(user_datetime).format()},
                success:function(response){
                  Swal.fire({
                    text:`Your Covid case in ${moment(user_datetime).format('MMMM Do YYYY, h:mm:ss a')} has been declared!`
                  }).then(function(){
                    window.location.reload();
                  });
                }
              });
            }
            console.log(Declare_covid);
          }
        })
      }
    }else if(result.dismiss === Swal.DismissReason.cancel){
      Swal.fire({
        text:"Upload failed!"
      }).then(function(){
        window.location.reload();
      });
    }
  });

}

</script>
