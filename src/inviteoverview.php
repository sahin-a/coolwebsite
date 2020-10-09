<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../public/css/bootstrap.css">
    <title>Change Password</title>
    <?php
    require_once($_SERVER['DOCUMENT_ROOT'] . "/src/controller/Auth/Auth.php");

    if (!Auth::isLoggedIn()) {
        header("Location: index.php");
        exit;
    }
    ?>
</head>
<body class="bg-dark align-self-center m-2 p-2">
<div class="container">
    <form action="accountoverview.php">
        <div class="form-row m-1 p-1">
            <div class="form-control bg-dark">
                <input class="btn btn-warning" type="submit" value="back to account overview">
            </div>
        </div>
    </form>
    <div class="container">
        <div class="input-group m-1 p-1 border">
            <table class="table table-dark text-center">
                <tr>
                    <td>
                        <label>User ID</label>
                    </td>
                    <td>
                        <label>Owner</label>
                    </td>
                    <td>
                        <label>Creation Date</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label id="videoSubmitter">UID</label>
                    </td>
                    <td>
                        <label id="videoMessage">OWNER_USERNAME</label>
                    </td>
                    <td>
                        <label id="videoSubmitDate">CREATION_DATE</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label id="videoSubmitter">NULL</label>
                    </td>
                    <td>
                        <label id="videoMessage">SUPERUSER</label>
                    </td>
                    <td>
                        <label id="videoSubmitDate">DEINE MUTTER</label>
                    </td>
                </tr>
            </table>
        </div>
        <div class="input-group m-1 p-1 border">
            <input onclick="alert('generator clicked')" type="submit" class="input-group btn-primary m-1 p-2" value="Generate Invite">
        </div>
        <div class="row">

        </div>
    </div>
</div>
</body>
</html>