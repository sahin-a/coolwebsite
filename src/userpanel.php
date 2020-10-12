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
    <script src="../public/js/utils/requestutils.js"></script>
    <title>User Panel</title>
</head>
<body class="bg-dark align-self-center m-2 p-2">
<div class="container">
    <div class="form-row m-1 p-1">
        <div class="form-control bg-dark btn-outline-danger">
            <div class="input-group">
                <img class="m-1 p-1"
                     src="https://resources.jetbrains.com/storage/products/phpstorm/img/meta/phpstorm_logo_300x300.png"
                     width="50" height="50">
                <form action="accountoverview.php">
                    <input class="btn btn-info m-2 p-2" type="submit" value="Account"/>
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
            <div class="row">
                <form action="controller/YouTube/submitVideo.php" method="post">
                    <div class="input-group m-1 p-1">
                        <input type="text" class="form-control bg-dark text-white" name="videoUrl"
                               id="validationVideoUrl" placeholder="Video URL" required/>
                        <input type="text" class="form-control bg-dark text-white" name="message"
                               placeholder="Message"/>
                        <input type="submit" class="form-control bg-info btn-outline-info text-white" value="submit"/>
                    </div>
                </form>
            </div>
            <div id="videoInfoRow" class="row">
                <form>
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
            <div class="input-group m-1 p-1" id="videoControls">
                <div class="input-group m-2 p-2">
                    <button onclick="previousVideo()" class="form-control btn-dark btn-outline-danger">Previous</button>
                    <button onclick="nextVideo()" class="form-control btn-dark btn-outline-info">Next</button>
                </div>
            </div>
            <div class="bg-dark m-1 p-1">
                <div class="row m-2 p-2" id="comment-section">
                    <!-- reserved for media post comments -->
                </div>
                <div class="row m-2 p-2">
                        <textarea id="commentBox" class="form-control bg-dark text-white"
                                  placeholder="Enter your comment here" rows="2" wrap="hard" maxlength="255"></textarea>
                    <button onclick="submitComment()" class="btn btn-info mt-2 p-2">submit</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../public/js/userpanel.js"></script>
</body>
</html>