<?php include 'header.php';?>

<title>Map</title>
<link rel="stylesheet" href="css/map.css">

<div id="map"></div>

<div id="near_stores">

  <h1>Store Information</h1>

<p class=".paragraph">How many people are currently in the store?</p>

<table id="Values_table">
  <thead>
    <th>Name</th>
    <th>Address</th>
    <th>Location</th>
    <th></th>
    <th></th>
  </thead>
  <tbody id="rows"></tbody>
</table>

</div>

<script type="text/javascript">
//House marker
var house_marker;
var stores_from_php;

//Initialize arrays
var JSON_array = [];

//Get the table
var table = document.getElementById('Values_table');

//Create table
var tr;
var cell = document.createElement("td");


//Date object
var date = new Date();

//Initialize map code taken from https://www.youtube.com/watch?v=nZaZ2dB6pow
var mymap = L.map('map');
const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';
const tileUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
const tiles = L.tileLayer(tileUrl, {
    attribution
});

//marker layer
var marker_layer_group = new L.layerGroup();

//cluster the marker of the stores in order not to shown
var marker_layer_cluster = L.markerClusterGroup({
    disableClusteringAtZoom: 17
});

//Initialize the search div
var searchControl = new L.control.search({
    url: 'search.php?q={s}',
    propertyName: 'store_name',
    textPlaceholder: 'Search in Leaflet Maps...',
    position: "topright",
    autoType: true,
    delayType: 600,
    moveToLocation: function(latLng, title, map) {
        mymap.setView([latLng.lat, latLng.lng], 17);
    },
    collapsed: false,
    autoCollapse: false,
    initial: false,
    marker: {
        icon: false,
        animate: false,
        circle: {
            stroke: false
        }
    }
});

//add all the necessary staff
tiles.addTo(mymap);
mymap.addLayer(marker_layer_group);
mymap.addLayer(marker_layer_cluster);
mymap.addControl(searchControl);

//Initialize my custom markers
var user_marker = L.icon({
    iconUrl: 'images/house_pin.png',
    shadowUrl: 'images/marker-shadow.png',
    iconAnchor: [10, 20],
    iconSize: [20, 20],
    popupAnchor: [0, -25],
    shadowSize: [1, 1]
});

var green_marker = L.icon({
    iconUrl: 'images/green_marker.png',
    shadowUrl: 'images/marker-shadow.png',
    iconAnchor: [10, 20],
    iconSize: [25, 20],
    popupAnchor: [0, -25],
    shadowSize: [1, 1]
});

var orange_marker = L.icon({
    iconUrl: 'images/orange_marker.png',
    shadowUrl: 'images/marker-shadow.png',
    iconAnchor: [10, 20],
    iconSize: [25, 20],
    popupAnchor: [0, -25],
    shadowSize: [1, 1]
});

var red_marker = L.icon({
    iconUrl: 'images/red_marker.png',
    shadowUrl: 'images/marker-shadow.png',
    iconAnchor: [10, 20],
    iconSize: [25, 20],
    popupAnchor: [0, -25],
    shadowSize: [1, 1]
});

var error_marker = L.icon({
    iconUrl: 'images/error_marker.png',
    shadowUrl: 'images/marker-shadow.png',
    iconAnchor: [10, 20],
    iconSize: [25, 20],
    popupAnchor: [0, -25],
    shadowSize: [1, 1]
});


//Function to help us depending on the popularity of a store to decide which marker to add to the map
function decide_icon_color(data) {

    if (Math.round(data) >= 0 && Math.round(data) <= 32) {
        return green_marker;
    } else if (Math.round(data) >= 33 && Math.round(data) <= 65) {
        return orange_marker;
    } else if (Math.round(data) >= 66) {
        return red_marker;
    } else {
        return error_marker;
    }
}

//function to calculate average for an array source:https://poopcode.com/calculate-the-average-of-an-array-of-numbers-in-javascript/
function calculate(array) {
    var arraySum = array.reduce(function(a, b) {
        return a + b;
    }, 0);
    return arraySum / array.length;
}

//function that calculates the distance between two coordinates taken by https://stackoverflow.com/a/27943/14749665
function getDistanceFromLatLonInKm(lat_1, lon_1, lat_2, lon_2) {
    //The Radius of the earth
    var Radius = 6371;

    var dLat = deg2rad(lat_2 - lat_1); // deg2rad below
    var dLon = deg2rad(lon_2 - lon_1);

    //haversine formula and hav(θ) = sin^2(θ/2)
    var a = Math.sin(dLat / 2) * Math.sin(dLat / 2) + Math.cos(deg2rad(lat_1)) * Math.cos(deg2rad(lat_2)) * Math.sin(dLon / 2) * Math.sin(dLon / 2);

    //Math.atan2 https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Math/atan2
    //https://en.wikipedia.org/wiki/Haversine_formula
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));

    var d = Radius * c; // Distance in km

    return parseInt(d * 1000);
}

//function that calculates the arc length
function deg2rad(deg) {
    return deg * (Math.PI / 180)
}

//Maybe we need to change that because it accepts number such as 4e2
function isInt(value) {
    return !isNaN(value) && (function(x) {
        return (x | 0) === x;
    })(parseFloat(value))
}


function upload_JSON(JSON) {

    if (isInt(JSON.estimation) == true) {
        Swal.fire({
            titleText: 'Are you sure?',
            text: `You are uploading your visit to '${JSON.name}' with ${JSON.estimation} people. You won't be able to revert this`,
            showCancelButton: true,
            cancelButtonColor: '#d33',
            allowEnterKey: false,
            allowEscapeKey: false,
            confirmButtonText: "Yes,upload it",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'Estimation_backend.php',
                    method: 'POST',
                    data: {
                        json: JSON
                    },
                    success: function(answer) {
                        //https://sweetalert2.github.io/#examples
                        console.log(answer);
                        Swal.fire({
                            text: "Upload done!"
                        })
                        // .then(function(){
                        //   window.location.reload();
                        // });
                    }
                });
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                Swal.fire({
                    text: "Upload failed!"
                })
                // .then(function(){
                //   window.location.reload();
                // });
            }
        });
    } else {
        Swal.fire({
            text: "Estimation must be interger!"
        });
        // .then(function(){
        //   window.location.reload();
        // });
    }
}


//idea taken from https://stackoverflow.com/a/23591268/14749665 and https://stackoverflow.com/a/5528448/14749665
function anotherLocation(user_loc, storesJSON) {

    tr = "";
    rows.innerHTML = "";
    for (let i = 0; i < storesJSON.length; i++) {
        if (getDistanceFromLatLonInKm(user_loc.lat, user_loc.lng, storesJSON[i].loc[0], storesJSON[i].loc[1]) < 20) {
            var JSON = {};
            let rows = document.getElementById('rows');

            tr += '<tr>';
            tr += '<td class=Store_name>' + storesJSON[i].name + '</td>' + '<td class=Store_Address>' + storesJSON[i].address + '</td>' + '<td class=Store_location>' + storesJSON[i].loc.join(',') + '</td><td><input class=input_user type="number" /></td><td><button class="editbtn">Upload</button></td><td class = hide style="visibility:collapse">' + storesJSON[i].Id + '</td>';
            tr += '</tr>';

        }
    }

    rows.innerHTML += tr;

    $(".editbtn").click(function() {
        let JSON = {};
        let row = $(this).closest("tr");

        JSON.id = row.find(".hide").text();
        JSON.name = row.find(".Store_name").text();
        JSON.address = row.find(".Store_Address").text();
        JSON.loc = row.find(".Store_location").text().split(",");
        JSON.estimation = row.find(".input_user").val();


        console.log(JSON);
        upload_JSON(JSON);
    })

}

function check_popularity(user_json,json2){

  for(let i=0;i<user_json.length;i++){
    if(user_json[i].Id_store == json2){
      return user_json[i].user_estimation;
    }
  }

}


//code taken from https://www.w3schools.com/html/html5_geolocation.asp

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(success, error);
} else {
    alert("Ok, bro!");
}

function success(position) {

    mymap.setView([position.coords.latitude, position.coords.longitude], 13);

    house_marker = L.marker([position.coords.latitude, position.coords.longitude], {
        icon: user_marker,
        draggable: true,
        autoPan: true
    });

    house_marker.bindPopup("Drag to change location or click to see details", {
        maxWidth: 500,
        minWidth: 40,
        closeButton: false,
        closeOnEscapeKey: false,
        keepInView: true
    });

    //https://gis.stackexchange.com/a/95795/199394
    house_marker.on('mouseover', function(e) {
        this.openPopup();
    });

    house_marker.on('mouseout', function(e) {
        this.closePopup();
    });
    //https://codeburst.io/all-about-this-and-new-keywords-in-javascript-38039f71780c

    marker_layer_group.addLayer(house_marker);

}

//Maybe all the data extracted from database are not nee
$.ajax({
  url: 'number_user_visits_backend.php',
  method: "POST",
  dataType: "json",
  success: function(visits){
    console.log(visits);

    //idea from https://stackoverflow.com/a/22431547/14749665
    let unique_stores = _.keys(_.countBy(visits, function(visits) { return visits.id_store; }));
    console.log(unique_stores);
    var estimation_of_user_json = [];
    for(let i=0;i<unique_stores.length;i++){
      let temp = [];
      for(let j=0;j<visits.length;j++){
        if(unique_stores[i] == visits[j].id_store){
          temp.push(parseInt(visits[j].estimation_of_user));
        }
      }
      estimation_of_user_json.push({
        'Id_store':unique_stores[i],
        'user_estimation':Math.round(calculate(temp))
      });
    }

    console.log(estimation_of_user_json);

    $.ajax({
        url: 'Map_backend.php',
        method: "POST",
        dataType: "json",
        success: function(response) {


            //https://gis.stackexchange.com/a/152449/199394

            console.log(response);
            stores_from_php = response;
            for (let i = 0; i < response.length; i++) {
                let estimate = [];

                if (date.getHours() == 22) {
                    estimate.push(parseInt(response[i].popular_times[date.getHours()]), parseInt(response[i].popular_times[date.getHours() + 1]), parseInt(response[i].popular_times[0]));
                } else if (date.getHours() == 23) {
                    estimate.push(parseInt(response[i].popular_times[date.getHours()]), parseInt(response[i].popular_times[0]), parseInt(response[i].popular_times[1]));
                } else {
                    estimate.push(parseInt(response[i].popular_times[date.getHours()]), parseInt(response[i].popular_times[date.getHours() + 1]), parseInt(response[i].popular_times[date.getHours() + 2]));
                }

                let store_markers = L.marker([response[i].loc[0], response[i].loc[1]], {
                    icon: decide_icon_color(calculate(estimate))
                });



                store_markers.bindPopup("Name: <b>" + response[i].name + "</b><br> Address: <b>" + response[i].address + "</b><br> Popularity: <b>" + Math.round(calculate(estimate))+"</b><br> Users popularity estimation: <b>" + check_popularity(estimation_of_user_json,response[i].Id)).on("popupopen", () => {
                    $(".leaflet-popup-close-button").on("click", (e) => {
                        if (store_markers._leaflet_id) {
                            mymap.removeLayer(store_markers);
                            //https://developer.mozilla.org/en-US/docs/Web/API/Event/preventDefault
                            e.preventDefault();
                        }
                    });
                });

                marker_layer_cluster.addLayer(store_markers);

            }


            console.log(house_marker);
            //Na trexei meta apo ligo 
            setTimeout(function() {anotherLocation(house_marker._latlng, stores_from_php)}, 3000);


            setTimeout(function(){
                house_marker.on('dragend', function(e) {
                anotherLocation(house_marker._latlng, stores_from_php);
            });       
            },3000);
            

        }
    });
  }
});




function error() {
    alert("Geolocation is not supported by this browser.");
}
</script>
