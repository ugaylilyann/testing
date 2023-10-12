<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../src/vendor/autoload.php';
$app = new \Slim\App;


$app->group('/point', function () use ($app) {
    $app->post('/display', function (Request $request, Response $response, array $args) {

        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "api-git-lily";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM users";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                array_push($data, array(
                    "fname" => $row["fname"],
                    "mname" => $row["mname"],
                    "lname" => $row["lname"],
                    "username" => $row["username"],
                    "password" => $row["password"]
                ));
            }
            $data_body = array("status" => "success", "data" => $data);
            $response->getBody()->write(json_encode($data_body));
        } else {
            $response->getBody()->write(array("status" => "success", "data" => null));
        }
        $conn->close();
        return $response;
    });

    $app->post('/search', function (Request $request, Response $response, array $args) {
        $data = json_decode($request->getBody());
        $uname = $data->username;


        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "api-git-lily";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "SELECT * FROM users where username='" . $uname . "'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                array_push($data, array(
                    "fname" => $row["fname"],
                    "mname" => $row["mname"],
                    "lname" => $row["lname"],
                    "username" => $row["username"],
                    "password" => $row["password"]
                ));
            }
            $data_body = array("status" => "success", "data" => $data);
            $response->getBody()->write(json_encode($data_body));
        } else {
            $response = 'failed';
        }
        $conn->close();
        return $response;
    });
    $app->post('/update', function (Request $request, Response $response, array $args) {

    return $response;
});
});





/* $app->post('point_1', function (Request $request, Response $response, array $args) {

    return $response;
}); */


$app->run();
