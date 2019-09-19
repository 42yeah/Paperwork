<?php
require "vendor/autoload.php";

use App\SQLiteConnection;


if (!array_key_exists("subgroup", $_POST) || !array_key_exists("content", $_POST) || $_POST["content"] == "") {
    echo "{ \"OK\": false }";
    header("Location: /index.php?subgroup=" . $_POST["subgroup"]);
    return;
}
$conn = new SQLiteConnection();
$conn->connect();
if (array_key_exists("file", $_FILES)) {
    $file = $_FILES["file"];
    $targetFile = getcwd() . "/assets/" . $file["name"];
    if (move_uploaded_file($file["tmp_name"], $targetFile)) {
        $splitted = explode(".", $file["name"]);
        if ($splitted[count($splitted) - 1] == "php") {
            // woah!
            return;
        }
        $fileDesc = [
            "file" => true,
            "name" => $file["name"]
        ];
        $conn->addRecord($_POST["subgroup"], json_encode($fileDesc));
        echo "{ \"OK\": true }";
        header("Location: /index.php?subgroup=" . $_POST["subgroup"]);
        return;
    }
}
$conn->addRecord($_POST["subgroup"], $_POST["content"]);
echo "{ \"OK\": true }";
header("Location: /index.php?subgroup=" . $_POST["subgroup"]);