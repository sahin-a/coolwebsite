<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/src/utils/AlertBuilder.php");

if (!Auth::isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION["user"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../public/css/bootstrap.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../public/js/userpanel.js"></script>
    <title>User Panel</title>
</head>
<body class="bg-dark align-self-center m-2 p-2">
<div class="container">
    <div class="form-row m-1 p-1">
        <div class="form-control bg-dark">
            <div class="input-group">
                <img class="m-1 p-1"
                     src="https://resources.jetbrains.com/storage/products/phpstorm/img/meta/phpstorm_logo_300x300.png"
                     width="50" height="50">
                <form action="">
                    <input class="btn btn-info m-2 p-2" type="submit" value="Account Information"/>
                </form>
                <form action="controller/Auth/logout.php">
                    <input class="btn btn-danger m-2 p-2" type="submit" value="Logout">
                </form>
            </div>
        </div>
    </div>
    <div class="row m-1 p-1">
        <?php
        echo AlertBuilder::buildAlert(AlertType::SUCCESS, "Welcome " . $user["username"] . "!");

        if (isset($_SESSION) && isset($_SESSION["msg"])) {
            echo $_SESSION["msg"];
            unset($_SESSION["msg"]);
        }
        ?>
        <div class="container bg-secondary">
            <div class="row bg-warning">
                <form action="controller/YouTube/submitVideo.php" method="post"> <!-- submitVideo.php soon -->
                    <div class="input-group m-1 p-1">
                        <input type="text" class="form-control bg-dark text-white" name="videoUrl"
                               id="validationVideoUrl" placeholder="Video URL" required/>
                        <input type="text" class="form-control bg-dark text-white" name="message"
                               placeholder="Message"/>
                        <input type="submit" class="form-control bg-dark text-white" value="submit"/>
                    </div>
                </form>
            </div>
            <div id="videoInfoRow" class="row bg-danger">
                <form action="controller/YouTube/submitVideo.php" method="post"> <!-- submitVideo.php soon -->
                    <div class="input-group m-1 p-1">
                        <table class="table table-dark text-center">
                            <tr class="table-dark">
                                <td>
                                    <label>Submitter</label>
                                </td>
                                <td>
                                    <label>Message</label>
                                </td>
                                <td>
                                    <label>Submit Date</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label id="videoSubmitter">SUBMITTER_PLACEHOLDER</label>
                                </td>
                                <td>
                                    <label id="videoMessage">MESSAGE_PLACEHOLDER</label>
                                </td>
                                <td>
                                    <label id="videoSubmitDate">SUBMIT_DATE_PLACEHOLDER</label>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
            <div id="videoRow" class="row m-2 p-2 embed-responsive embed-responsive-16by9">
            </div>
            <div class="input-group m-1 p-1">
                <div class="input-group m-2 p-2">
                    <button onclick="previousVideo()" class="form-control btn-dark">Previous</button>
                    <button onclick="nextVideo()" class="form-control btn-dark">Next</button>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>