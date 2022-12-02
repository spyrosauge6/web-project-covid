<?php include 'header_admin.php'?>


<div class="user_visits">
    <table class = "user_infos">

        <thead>

        <th><h1>Address Store</h1></th>
        <th><h1>Date of Upload</h1></th>
        <th><h1>Name of Store</h1></th>
        <th><h1>Estimation of User</h1></th>
        <th><h1>ID</h1></th>

        </thead>
        
        <tbody id="info1"></tbody>

    </table>
</div>

<div class="covid_cases"> 
    <table class = "user_infos" >
        <thead>
            <th><h1>Date of Infection</h1></th>
            <th><h1>Case</h1></th>
            <th><h1>ID</h1></th>
        </thead>
        <tbody id="info2"></tbody>
    </table>
</div>

<script>

var div_user_visits = document.getElementsByClassName('user_visits');
var div_covid_cases = document.getElementsByClassName('covid_cases');

function calculate_length(lgth){
        if(lgth<11){
            return lgth;
        }else{
            return 11;
        }
    }

console.log(div_user_visits);

console.log(div_covid_cases);


$.ajax({
    url: "main_page_visits_backend.php",
    method: "POST",
    dataType: "json",
    success: function(data) {
        console.log(data);
        $.ajax({
            url: "main_page_covid_backend.php",
            method: "POST",
            dataType: "json",
            success: function(response) {
                console.log(response);
                var rows = document.getElementById('info1');
                var rows_1 = document.getElementById('info2');

           

                for(let i=0;i<calculate_length(data.length);i++){

                    rows.innerHTML +="<tr><td>" + data[i].Address_store + "</td><td>" + moment(data[i].Date_of_upload).format() + "</td><td>" + data[i].Name_store + "</td><td>" + data[i].estimation_of_user + "</td><td>" + data[i].id_user + "</td></tr>"

                }

                for(let i=0;i<calculate_length(response.length);i++){

                    rows_1.innerHTML +="<tr><td>" + moment(response[i].date_of_infection).format() + "</td><td>" + response[i].id_case + "</td><td>" + response[i].id_user + "</td></tr>"
       

                }

            }
        });

    }
});


</script>
