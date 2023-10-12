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
                    "id" => $row["id"],
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
    $app->post('/delete', function (Request $request, Response $response, array $args) {
        $data = json_decode($request->getBody());
        $id = $data->id;


        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "api-git-lily";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $sql = "DELETE FROM users where id='" . $id . "'";
        if ($conn->query($sql) === TRUE) {
            $response = "success";
        } else {
            $response = "failed";
        }
        $conn->close();
        echo $response;
    });
    $app->post('/add', function (Request $request, Response $response, array $args) {

        $data = json_decode($request->getBody());
        $fname = $data->fname;
        $lname = $data->lname;
        $mname = $data->mname;
        $username = $data->username;
        $password = $data->password;

        $servername = "localhost";
        $uname = "root";
        $passkey = "";
        $database = "api-git-lily";

        //Database

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $uname, $passkey);

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO users (lname, fname, mname, username, password)VALUES (
            '" . $lname . "',
            '" . $fname . "',
            '" . $mname . "',
            '" . $username . "',
            '" . $password . "')";
            $conn->exec($sql);
            $response = "success";
        } catch (PDOException $e) {
            $response = "failed";
        }
        $conn = null;
        echo $response;
        // return $response;
    });
    $app->post('/update', function (Request $request, Response $response, array $args) {

        $data = json_decode($request->getBody());
        $id = $data->id;
        $fname = $data->fname;
        $lname = $data->lname;
        $mname = $data->mname;
        $username = $data->username;
        $password = $data->password;

        $servername = "localhost";
        $uname = "root";
        $passkey = "";
        $database = "api-git-lily";

        //Database

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$database", $uname, $passkey);

            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "UPDATE users set lname =  '" . $lname . "', fname =  '" . $fname . "', mname =  '" . $mname . "', username = '" . $username . "', password = '" . $password . "' where id =  '" . $id . "'";
            $conn->exec($sql);
            $response = "success";
        } catch (PDOException $e) {
            $response = "failed";
        }
        $conn = null;
        echo $response;
    });
    
    $app->post('/login', function (Request $request, Response $response, array $args) {
        $data = json_decode($request->getBody());

        $username = $data->username;
        $password = $data->password;

        $servername = "localhost";
        $uname = "root";
        $passkey = "";
        $database = "api-git-lily";

        $conn = mysqli_connect($servername, $uname, $passkey, $database);
        if ($conn->connect_error) {
            die("Database Connection Error: " . $conn->connect_error);
        }

        function validate($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);

            return $data;
        }

        $logusername = validate($username);
        $logpassword = validate($password);

        $query = "SELECT * FROM users WHERE username = '$logusername' AND password = '$logpassword'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);

            if ($row['username'] === $logusername && $row['password'] === $logpassword) {
                $response = "success";
                echo $response;
                exit();
            } else {
                $response = "failed";
                echo $response;
                exit();
            }
        }
        $conn->close();
        exit();

    });
});





/*  */


$app->run();
