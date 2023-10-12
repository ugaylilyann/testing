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
    /* $.ajax({
        type: "POST",
        url: "../public/point_1",
        data: JSON.stringify({

        }),
        success: function (response) {
            if (response === 'success') {
                alert("Action Success");
            } else {
                alert("Action Failed. PLease Try Again");
            }
            setTimeout(function () {
                location.reload();
            }, 1000);
        }
    }); */

    $("#search").click(function () {
        var username = prompt("Please enter the Username");
        if (username === "") {
            alert("No Username Please try again");
        } else if (username === null) {
            alert("Canceled Please try again");
        } else {
            $.ajax({
                type: "POST",
                url: "public/point/search",
                data: JSON.stringify({
                    username: username
                }),
                success: function (data, response) {
                    if (response === "success") {
                        $("#editUser").show();
                        var json = JSON.parse(data);
                        $("#upfname").get(0).value = json.data[0].fname;
                        $("#uplname").get(0).value = json.data[0].lname;
                        $("#upmname").get(0).value = json.data[0].mname;
                        $("#upusername").get(0).value = json.data[0].username;
                        $("#uppassword").get(0).value = json.data[0].password;

                    } else {
                        $("#editUserFail").show();
                        
                        setTimeout(function () {
                            location.reload();
                        }, 1000);
                    }

                }
            });
        }
    });

    $("#update").click(function () { 
        var fname = $("#upfname").get(0).value;
        var lname = $("#uplname").get(0).value;
        var mname = $("#upmname").get(0).value;
        var username = $("#upusername").get(0).value;
        var password = $("#uppassword").get(0).value;
        $.ajax({
            type: "POST",
            url: "point/update",
            data: JSON.stringify({
                fname: fname,
                mname: mname,
                lname: lname,
                username: username,
                password: password
            }),
            success: function (response) {
                
            }
        });
    });


    //----------------Accessories
    $("#closeModal").click(function () {
        $("#editUser").hide();
    });
});