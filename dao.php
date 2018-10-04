<?php

define("FOREIGN_EX_DB_TYPE_USER", 1);
define("FOREIGN_EX_DB_TYPE_ROOM", 2);
define("FOREIGN_EX_DB_TYPE_GROUP", 3);

class ForeignEXDB
{
    private $pdo;
    public $dbPath;
	function __construct($dbPath) {
        //$this->pdo = new PDO('sqlite:db.sqlite');
        $this->pdo = new PDO("sqlite:$dbPath");
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE,
                            PDO::ERRMODE_EXCEPTION);
		//$this->open('db.sqlite');
	}

    /**
     * create tables
     */
    public function createTables() {
        // type: 1 => 
        $commands = [
            'CREATE TABLE `target` (
                    `id`	INTEGER PRIMARY KEY AUTOINCREMENT UNIQUE,
                    `line_id`	TEXT UNIQUE,
                    `type`	INTEGER,
                    `created_at`	TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                    `updated_at`	TIMESTAMP
            );',
            'CREATE TRIGGER "targetUpdateAt" AFTER UPDATE ON "target" FOR EACH ROW BEGIN UPDATE target SET updated_at=CURRENT_TIMESTAMP WHERE id=OLD.id; END'];
        // execute the sql commands to create new tables
        foreach ($commands as $command) {
            $statement = $this->pdo->prepare($command);
            $statement->execute();
        }
    }

    public function isTableExisted($name) {
        $sql = "SELECT COUNT(*) FROM sqlite_master WHERE type='table' AND name = :name;";
        $statement = $this->pdo->prepare($sql);
        $statement->execute(array(
            'name' => $name,
        ));
        $row = $statement->fetch();
        return $row[0] > 0;
    }

    public function addLineID($lineID, $typeID) {
        $sql = 'INSERT INTO `target` (`line_id`, `type`) VALUES ( :line_id, :type)';
        $statement = $this->pdo->prepare($sql);
        try {
            $statement->execute(array(
                'line_id' => $lineID,
                'type' => $typeID,
            ));
        } catch (PDOException $ex) {
            return false;
        }
        return true;
    }

    public function deleteLineID($lineID) {
        $sql = 'DELETE FROM `target` WHERE `line_id` = :line_id';
        $statement = $this->pdo->prepare($sql);
        try {
            $statement->execute(array(
                'line_id' => $lineID,
            ));
        } catch (PDOException $ex) {
            return false;
        }
        $count = $statement->rowCount();
        return $count > 0;
    }

    public function getAllLineID() {
        $sql = 'SELECT `line_id` FROM `target`';
        $statement = $this->pdo->prepare($sql);
        try {
            $statement->execute();
            $result = array();
            foreach($statement->fetchAll() as $row) {
                array_push($result, $row[0]);
            }
            return $result;
        } catch (PDOException $ex) {
            return false;
        }
    }
}

?>

