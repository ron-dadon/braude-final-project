<?php

define("VENDOR_PATH", "../");
define("CONFIGURATION_FILE", "../Application/Configuration/configuration.json");

try
{
    require_once '../Trident/Trident.php';
}
catch (Exception $e) { ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>IACS Information System</title>
        <link rel="stylesheet" type="text/css" href="http://localhost/iacs/Public/css/bootstrap.min.css">
    </head>
    <body>
    <div class="container-fluid">
        <div class="page-header">
            <h1>IACS Information System</h1>
        </div>
        <div class="alert alert-danger">
            <h2><i class="glyphicon glyphicon-alert"></i> Oops! Something went wrong!</h2>
            <h3>The application can not start. Please contact administrator.</h3>
        </div>
    </div>
    </body>
</html>
<?php }