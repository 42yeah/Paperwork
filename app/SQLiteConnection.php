<?php
namespace App;


class SQLiteConnection {
    public function connect() {
        if ($this->pdo == null) {
            $this->pdo = new \PDO("sqlite:" . Config::PATH_TO_SQLITE_FILE);
        }
        return $this->pdo;
    }

    public function getRecords($subgroup) {
        $records = [];
        $statement = $this->pdo->query("SELECT * FROM paperworks");
        while ($row = $statement->fetch(\PDO::FETCH_ASSOC)) {
            if ($row["subgroup"] == $subgroup) {
                array_push($records, $row);
            }
        }
        return $records;
    }

    public function addRecord($subgroup, $text) {
        $sql = "INSERT INTO paperworks(subgroup, content) VALUES('" . $subgroup . "', '" . $text . "')";
        echo $sql;
        $statement = $this->pdo->prepare($sql);
        $statement->execute();
        return $this->pdo->lastInsertId();
    }

    public $records;
    private $pdo;
}
