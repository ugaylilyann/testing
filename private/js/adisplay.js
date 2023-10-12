$(document).ready(function () {
    $.ajax({
        type: "POST",
        url: "public/point/display",
        success: function (data) {
            var json = JSON.parse(data);
            var row = "";
            var number = 1;
            for (var i = 0; i < json.data.length; i++) {
                row = row + "<tr><td>" +
                    number + "</td><td>" +
                    json.data[i].fname + " " + json.data[i].mname + " " + json.data[i].lname + " " + "</td><td>" +
                    json.data[i].username + "</td><td>" +
                    json.data[i].password + "</td></tr>";
                number++;
            }
            $("#dataBody").get(0).innerHTML = row;
        }
    });
});