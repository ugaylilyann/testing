$(document).ready(function () {

    $(document).on('submit', '#addAPI', function (event) {
        event.preventDefault();
        var fname = $('input[name=fname]').val();
        var lname = $('input[name=lname]').val();
        var mname = $('input[name=mname]').val();
        var username = $('input[name=username]').val();
        var password = $('input[name=password]').val();
        $.ajax({
            type: "POST",
            url: "public/point/add",
            data: JSON.stringify({
                fname: fname,
                mname: mname,
                lname: lname,
                username: username,
                password: password
            }),
            success: function (response) {
                if (response === "success") {
                    $("#addSuccess").show();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    $("#addFailed").show();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            }
        });
    });


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
                        $("input[name=upID]").get(0).value = json.data[0].id;
                        $("input[name=upfname]").get(0).value = json.data[0].fname;
                        $("input[name=uplname]").get(0).value = json.data[0].lname;
                        $("input[name=upmname]").get(0).value = json.data[0].mname;
                        $("input[name=upusername]").get(0).value = json.data[0].username;
                        $("input[name=uppassword]").get(0).value = json.data[0].password;

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


    $(document).on("submit", "#updateAPI", function () {

        var id = $("input[name=upID]").get(0).value;
        var fname = $("input[name=upfname]").get(0).value;
        var lname = $("input[name=uplname]").get(0).value;
        var mname = $("input[name=upmname]").get(0).value;
        var username = $("input[name=upusername]").get(0).value;
        var password = $("input[name=uppassword]").get(0).value;
        $.ajax({
            type: "POST",
            url: "public/point/update",
            data: JSON.stringify({
                id: id,
                fname: fname,
                mname: mname,
                lname: lname,
                username: username,
                password: password
            }),
            success: function (response) {
                if (response === "success") {
                    $("#upSuccess").show();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    $("#upFailed").show();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            }
        });
    });

    $("#delete").click(function () {
        var id = $("input[name=upID]").get(0).value;
        $.ajax({
            type: "POST",
            url: "public/point/delete",
            data: JSON.stringify({
                id: id
            }),
            success: function (response) {
                if (response === "success") {
                    $("#delSuccess").show();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                } else {
                    $("#delFailed").show();
                    setTimeout(function () {
                        location.reload();
                    }, 1000);
                }
            }
        });
    });

    $("#add").click(function () {
        $("#addUser").show();
    });

    //----------------Accessories
    $("#editcloseModal").click(function () {
        $("#editUser").hide();
    });
    $("#addcloseModal").click(function () {
        $("#addUser").hide();
    });
});