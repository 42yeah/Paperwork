<!DOCTYPE html>
<?php 
require "vendor/autoload.php";

use App\SQLiteConnection;


if (!array_key_exists("subgroup", $_GET)) {
    header("Location: /home.php");
}
$subgroup = $_GET["subgroup"];
$conn = new SQLiteConnection();
$conn->connect();
$records = $conn->getRecords($subgroup);
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Paperwork</title>
    <link rel="stylesheet" href="/css/styles.css">
    <link rel="stylesheet" href="/css/all.min.css">
    <script src="/js/scripts.js"></script>
</head>
<body>
    <div class="section">
        <div class="jumbotron">
            <div>&nbsp;</div>
            <div class="bio">
                <input placeholder="Paperwork..." id="paperwork">
                <div class="button">
                    <a class="button-inner" href="javascript:upload()">
                        <i class="fas fa-file"></i> Upload
                    </a>
                </div>
                <div class="button">
                    <a class="button-inner" href="javascript:submit()">
                        <i class="fas fa-check"></i> Submit
                    </a>
                </div>
            </div>
        </div>
        <div class="jumbotron">
            <div class="tiny-list">
                <?php
                    foreach ($records as $item) {
                        if (json_decode($item["content"], true) != null) {
                            $decoded = json_decode($item["content"], true);
                            $isFile = $decoded["file"];
                            if ($isFile) {
                                echo "<a class=\"button-horizontal\" href=\"/assets/" . $decoded["name"] . "\"><i class=\"fas fa-file\"></i> " . $decoded["name"] . "</a>";
                                continue;
                            }
                        }
                        echo "<div class=\"card-horizontal\">" . $item["content"] . "</div>";
                    }
                    if (count($records) == 0) {
                        echo "<div class=\"card-horizontal\">This subgroup is currently empty. Let's add something to it!</div>";
                    }
                ?>
            </div>
            
        </div>
    </div>

    <form class="invisible" id="file-form" action="/upload.php" enctype="multipart/form-data" method="POST">
        <input type="file" id="file-input" onchange="submitWithFile()" name="file">
        <input type="text" id="file-content" name="content">
        <input type="text" id="file-subgroup" name="subgroup">
    </form>
</body>
</html>
