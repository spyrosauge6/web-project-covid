<?php include 'header_admin.php'?>

<title>Visualization admin</title>
<link rel="stylesheet" href="css/admin_table.css">

<div class="table-wrapper">
    <table class="fl-table" id="Values_table">
        <thead class="fl-header" id = "head">
        <tr>
            <th>Type</th>
            <th>Count</th>
            <th>No. of visits by confirmed cases</th>
            <th>Positive Count</th>

        </tr>
        </thead>
        <tbody>
       <tbody class="fl-body" id = "body"></tbody>
        <tbody>
    </table>
</div>
<script>
$.ajax({
    url: "Visualization_table_backend.php",
    method: "POST",
    dataType: "json",
    success: function(data) {
        console.log(data);

        var all_stores_types = [];
        var user_all_stores_types = [];
        var positive_user_all_stores_types = [];

        var stores_types = [];
        var user_stores_types = [];
        var positive_user_stores_types = [];

        var string_types, user_string_types, positive_user_string_types;
        var tr = "";

        var table_result = [];


        for (let i = 0; i < data.length; i++) {
            if (data[i].first_select !== undefined) {
                stores_types.push(data[i].first_select.types_store);
            } else if (data[i].second_select !== undefined) {
                user_stores_types.push(data[i].second_select.types_store);
            } else if (data[i].third_select !== undefined) {
                positive_user_stores_types.push(data[i].third_select.types_store)
            }
        }

        string_types = stores_types.toString();
        user_string_types = user_stores_types.toString();
        positive_user_string_types = positive_user_stores_types.toString();


        all_stores_types = string_types.split(',');
        user_all_stores_types = user_string_types.split(',');
        positive_user_all_stores_types = positive_user_string_types.split(',');

        const result = all_stores_types.reduce((all_stores_types, e) => all_stores_types.set(e, (all_stores_types.get(e) || 0) + 1), new Map());
        const user_result = user_all_stores_types.reduce((user_all_stores_types, e) => user_all_stores_types.set(e, (user_all_stores_types.get(e) || 0) + 1), new Map());
        const positive_user_result = positive_user_all_stores_types.reduce((positive_user_all_stores_types, e) => positive_user_all_stores_types.set(e, (positive_user_all_stores_types.get(e) || 0) + 1), new Map());

        // console.log([...result.keys()]);
        // console.log([...result.entries()]);
        // console.log([...user_result.keys()]);
        // console.log([...user_result.entries()]);
        // console.log([...positive_user_result.keys()]);
        // console.log([...positive_user_result.entries()]);

        var final_result = [...result.keys()];
        var user_final_result = [...user_result.entries()];
        var positive_user_final_result = [...positive_user_result.entries()];

        final_result.sort(function(a, b) {
            return b - a
        });
        user_final_result.sort(function(a, b) {
            return b[1] - a[1]
        });
        positive_user_final_result.sort(function(a, b) {
            return b[1] - a[1]
        });

        for (let i = 0; i < final_result.length; i++) {
            table_result[i] = [final_result[i], 0, 0];
            for (let j = 0; j < user_final_result.length; j++) {
                if (final_result[i] == user_final_result[j][0]) {
                    table_result[i][1] = user_final_result[j][1];
                }
            }
        }

        for (let i = 0; i < final_result.length; i++) {
            for (let j = 0; j < positive_user_final_result.length; j++) {
                if (final_result[i] == positive_user_final_result[j][0]) {
                    table_result[i][2] = positive_user_final_result[j][1];
                }
            }
        }


        //At the first column of table result we have the unique types
        //At the second column of table result we have how many times the users have visited each of the unique types
        //At the third column of table result we have how many time the positive users have visited each of the unique types

        table_result.sort();
        console.log(table_result);

        for (let i = 0; i < table_result.length; i++) {
            rows = document.getElementById('body');

            tr += '<tr class="active-row">';
            tr += '<td>' + table_result[i][0] + '</td>' + '<td>' + table_result[i][1] + '</td>' + '<td>' + table_result[i][2] + '</td>';
            tr += '</tr>';

        }

        rows.innerHTML += tr;

        //https://stackoverflow.com/a/39993724/14749665 with DOMContentLoaded as event without if it couldnt word now it works
        if (document.readyState !== 'loading') {
            console.log('document is already ready, just execute code here');
            myInitCode();
        } else {
            document.addEventListener('DOMContentLoaded', function() {
                console.log('document was not ready, place code here');
                myInitCode();
            });
        }

        function myInitCode() {
            const html_table = $(".fl-table");
            const headers = html_table[0].querySelectorAll('th');
            const html_body = $('.fl-body');
            const rows = html_body[0].querySelectorAll('tr');


            const directions = Array.from(headers).map(function(header) {
                return '';
            });


            const transform = function(index, content) {
                const type = headers[index].getAttribute('data-type');

                switch (isNaN(content)) {
                    case false:
                        return parseInt(content);
                    case true:
                        return content;
                }
            };

            const sortColumn = function(index) {

                const direction = directions[index] || 'asc';

                const multiplier = direction === 'asc' ? 1 : -1;

                const newRows = Array.from(rows);

                newRows.sort(function(rowA, rowB) {


                    const cellA = rowA.querySelectorAll('td')[index].innerHTML;
                    const cellB = rowB.querySelectorAll('td')[index].innerHTML;


                    const a = transform(index, cellA);

                    const b = transform(index, cellB);


                    switch (true) {
                        case a > b:
                            return 1 * multiplier;
                        case a < b:
                            return -1 * multiplier;
                        case a === b:
                            return 0;
                    }

                });

                [].forEach.call(rows, function(row) {
                    html_body[0].removeChild(row);
                });

                directions[index] = direction === 'asc' ? 'desc' : 'asc';

                newRows.forEach(function(newRow) {
                    html_body[0].appendChild(newRow);
                });
            };

            [].forEach.call(headers, function(header, index) {
                header.addEventListener('click', function() {
                    sortColumn(index);
                });
            });
        }

    }
});
</script>
