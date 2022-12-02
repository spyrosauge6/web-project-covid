<?php include 'header_admin.php'?>

<title>Administrator Page</title>
<h2>Choose File to import to database:</h2>
<input type="file" name="inputfile" id="inputfile" accept=".json">
<table>
 <tr>
  <td>
			<button class="myButton" id="delete_btn" >DELETE STORES</button>
  </td>
 </tr>
</table>
<script>
  const delete_rows = document.getElementById('delete_btn');

delete_rows.onclick = function() {
    Swal.fire({
        titleText: 'Are you sure?',
        text: "Are you sure you want to delete all stores?",
        showCancelButton: true,
        cancelButtonColor: '#d33',
        allowEnterKey: false,
        allowEscapeKey: false,
        confirmButtonText: "OK , Got it",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: "Delete_rows_backend.php",
                data: {
                    bool_value: true
                },
                success: function(data) {
                    console.log(data);
                    Swal.fire({
                        text: "Deletion of stores completed",
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        confirmButtonText: "OK,got it",
                        confirmButtonColor: "#000000" //"#4267B2"
                    }).then(function() {
                        window.location.reload();
                    });
                }
            });
        } else if (result.dismiss === Swal.DismissReason.cancel) {
            Swal.fire({
                text: "Deletion cancelled!",
                allowEscapeKey: false,
                allowEnterKey: false,
                confirmButtonText: "OK,got it",
                confirmButtonColor: "#000000" //"#4267B2"
            }).then(function() {
                window.location.reload();
            });
        }
    })

}

//I get the choose file button and the file that has to be json
const fileSelector = document.getElementById('inputfile');

fileSelector.addEventListener('change', function() {

    //Regex Expression
    const regex = /json/gm;
    console.log(this.files[0].type);
    if (regex.test(this.files[0].type) == true) {
        console.log(this.files[0]);


        //I create a FileReader object in order to get the file choosen
        var file = new FileReader();

        //Not accepting multiple files
        file.readAsText(this.files[0]);



        //When it is loaded then do stuff
        file.onload = function() {

            console.log(file);
            console.log(file.result);
            //JSON form the file data
            parsed_file = JSON.parse(file.result);

            //array that will be send to php in order to be uploaded to database
            let JSON_file_backend = [];
            console.log(parsed_file);
            for (let i = 0; i < parsed_file.length; i++) {

                JSON_parsed_file = {};

                //Day of the date of the data given
                JSON_parsed_file.days_name = [];

                //Data for the popularity of the store
                JSON_parsed_file.days_data = [];

                //Id of the store
                JSON_parsed_file.id = parsed_file[i].id;
                //Name of the store
                JSON_parsed_file.name = parsed_file[i].name;
                //Address of the store
                JSON_parsed_file.address = parsed_file[i].address;
                //Latitude of the store
                JSON_parsed_file.lat = parsed_file[i].coordinates.lat;
                //Longitude of the store
                JSON_parsed_file.lng = parsed_file[i].coordinates.lng;
                //Rating of the store
                JSON_parsed_file.rating = parsed_file[i].rating;
                //Rating_n of the store
                JSON_parsed_file.rating_n = parsed_file[i].rating_n;
                //The type of the store
                JSON_parsed_file.types = parsed_file[i].types.toString();

                for (let j = 0; j < (parsed_file[i].populartimes).length; j++) {
                    JSON_parsed_file.days_name.push(parsed_file[i].populartimes[j].name);
                    JSON_parsed_file.days_data.push(parsed_file[i].populartimes[j].data);
                }

                //I push the Json create to the array and in every loop it is initialized again
                JSON_file_backend.push(JSON_parsed_file);
            }

            $.ajax({
                type: "POST",
                url: "Upload_stores_backend.php",
                data: {
                    data: JSON.stringify(JSON_file_backend)
                },
                success: function(data) {
                    console.log(data);
                    Swal.fire({
                        text: "Insertion of stores completed",
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        confirmButtonText: "OK,got it",
                        confirmButtonColor: "#000000" //"#4267B2"
                    }).then(function() {
                        window.location.reload();
                    });

                }
            })
        }
    } else {

        Swal.fire({
            text: "You have to select json files",
            allowEscapeKey: false,
            allowEnterKey: false,
            confirmButtonText: "OK,got it",
            confirmButtonColor: "#000000" //"#4267B2"
        }).then(function() {
            window.location.reload();
        });
    }

});
</script>
