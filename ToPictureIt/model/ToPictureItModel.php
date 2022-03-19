<?php

namespace Model;

class ToPictureItModel {

    private static $tableName = 'pictureits';
    private static $rowURL = 'pictureurl';
    private static $rowDesc = 'description';
    private static $rowTag = 'tag';
    private static $rowID = 'id';

    private $database;

    public function __construct(\Model\DAL\TPIDatabase $DB) {

        $this->database = $DB;
    }

    public function attemptToAddPicture(string $pictureUrl,
                                        string $pictureDescription,
                                        string $pictureTag) : void {
                                            
        if ($this->allowedSymbolsCheck($pictureDescription)
            && $this->allowedSymbolsCheck($pictureTag)) 
            {
                $urlSql = $this->sqlSelectPictureIt($pictureUrl);
                $row = $this->databaseQuery($urlSql)->fetch_assoc();

                if ($row[self::$rowURL] ?? null != $pictureUrl) {
                    $insertSql = $this->sqlInsertPictureIt($pictureUrl,
                                                            $pictureDescription,
                                                            $pictureTag);
                    $this->databaseQuery($insertSql);

                }
                else if ($row[self::$rowURL] == $pictureUrl) {
                    throw new URLExists();
                }
        }
        else {
            throw new InvalidToPictureItCharacters();
        }
    }

    public function getAllPictureIts() : array {
        $allToPictureIts = $this->sqlSelectAll();
        $allRows = $this->databaseQuery($allToPictureIts);
        $pictureItList = [];

        if (!empty($allRows)) {
            while ($row = $allRows->fetch_array()) {
                $pictureItList[] = $row;
            }
            return $pictureItList;
        }
    }

    public function attemptToRemovePicture(int $ID) : void {
        $sql = $this->sqlDeleteID($ID);
        $this->databaseQuery($sql);
    }

    private function databaseQuery($sqlSelection) {
        return $this->database->connect()->query($sqlSelection);
    }

    private function sqlSelectAll() : string {
        return "SELECT * FROM " . self::$tableName . "";
    }

    private function sqlDeleteID($tempID) : string {
        return "DELETE FROM " . self::$tableName . " 
        WHERE " . self::$rowID . "='$tempID'";
    }

    private function sqlSelectPictureIt($pictureUrl) : string {
        return "SELECT * FROM " . self::$tableName . " 
        WHERE " . self::$rowURL . "='$pictureUrl'";
    }

    private function sqlInsertPictureIt($pictureUrl,
                                        $pictureDescription,
                                        $pictureTag) : string {
        return "INSERT INTO " . self::$tableName . " 
        (" . self::$rowURL . ", " . self::$rowDesc . ", " . self::$rowTag . ") 
        VALUES ('$pictureUrl', '$pictureDescription', '$pictureTag')";
    }

    private function allowedSymbolsCheck(string $tagOrDescription) : int {
        return preg_match('/^[0-9 A-Z a-z ][A-Z a-z 0-9 ]/', $tagOrDescription);
    }

}