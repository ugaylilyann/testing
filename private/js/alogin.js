$(document).on('submit', '#loginEndpoint', function (event) {
    event.preventDefault();
    var username = $('input[name=loginusername]').val();
    var password = $('input[name=loginpassword]').val();
    $.ajax({
        type: "POST",
        url: "public/point/login",
        data: JSON.stringify({
            username: username,
            password: password
        }),
        success: function (response) {
            if (response === "success") {
                window.location.replace("home.html");
            } else {
                $("#logFailed").show();
                setTimeout(function () {
                    location.reload();
                }, 1000);
            }
        }
    });
});