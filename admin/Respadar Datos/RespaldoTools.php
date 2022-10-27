<?php

class MySqlBackupLite {

  private $host;
  private $user;
  private $pass;
  private $name="";

  private $fileName = "";
  private $fileDir = "./";
  private $fileCompression = false;

  private $timeZone = '+00:00';

  private $mySqli;
  private $sqlString = "";
  private $arrayTables;

  private $tableFieldCount = 0;
  private $tableNumberOfRows = 0;
  private $queryResult;



  public function __construct(array $arrayConnConfig) {

      if (
        (!isset($arrayConnConfig['host'])) ||
        (!isset($arrayConnConfig['user'])) ||
        (!isset($arrayConnConfig['pass'])) ||
        (!isset($arrayConnConfig['name']))
      ) {
          throw new Exception('Missing connection data.');

      }
      $this->setHost($arrayConnConfig['host']);
      $this->setUser($arrayConnConfig['user']);
      $this->setPass($arrayConnConfig['pass']);
      $this->setName($arrayConnConfig['name']);

  }



  public function backUp() {
    $this->fileName = "Backup_".date('Ymd').".sql";
    $this->connectMySql();
    $this->getTables();
    $this->orderTables();
    $this->generateSqlHeader();
    $this->createTableStaments();
    $this->insertStaments();
    $this->generateSqlFooter();

  }



  private function setHost($host) {
    $this->host = $host;
  }



  private function setUser($user) {
    $this->user = $user;
  }



  private function setPass($password) {
    $this->pass = $password;
  }



  private function setName($name) {
    $this->name = $name;
  }



  public function setFileName($name) {
    $this->fileName = $name;
  }



  public function setFileDir($dir) {
    $this->fileDir = $dir;
  }



  public function setFileCompression($compression) {
    $this->fileCompression = $compression;
  }



  private function connectMySql() {

    $this->mySqli = new mysqli($this->host, $this->user, $this->pass, $this->name);
    $this->mySqli->select_db($this->name);
    $this->mySqli->query("SET NAMES 'utf8'");

  }



  private function getTables() {

    $queryTables = $this->mySqli->query('SHOW TABLES');
    while($row = $queryTables->fetch_row()) {
      $this->arrayTables[] = $row[0];
    }

  }

  private function orderTables(){
    $array = [
      $this->arrayTables[3],
      $this->arrayTables[0],
      $this->arrayTables[5],
      $this->arrayTables[4],
      $this->arrayTables[2],
      $this->arrayTables[1]
    ];
    $this->arrayTables = $array;
  }


  private function generateSqlHeader() {

    $this->sqlString  = 'SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";' . "\r\n";
    $this->sqlString .= 'SET time_zone = "' . $this->timeZone . '";' . "\r\n\r\n\r\n";
    $this->sqlString .= '/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;' . "\r\n";
    $this->sqlString .= '/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;' . "\r\n";
    $this->sqlString .= '/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;' . "\r\n";
    $this->sqlString .= '/*!40101 SET NAMES utf8 */;' . "\r\n";
    $this->sqlString .= '--' . "\r\n";
    $this->sqlString .= '-- Database: `' . $this->name . '`' . "\r\n";
    $this->sqlString .= '--' . "\r\n\r\n\r\n";

    return;

  }



  private function createTableStaments() {

    foreach($this->arrayTables as $table){
      $this->sqlCreateTableStament($table);
    }

  }



  private function sqlCreateTableStament($table) {

    $res = $this->mySqli->query('SHOW CREATE TABLE '.$table);
    $temp = $res->fetch_row();
		$this->sqlString .= "\n\n" . str_ireplace('CREATE TABLE `','CREATE TABLE IF NOT EXISTS `', $temp[1]) . ";\n\n";

  }



  private function insertStaments() {

    foreach($this->arrayTables as $table){
      $this->sqlInsertStaments($table);
    }

  }



  private function sqlInsertStaments($table) {

		$this->getTableData($table);

    if($this->tableFieldCount == 0) {
      return;
    }


    $i = 0;
		while($row = $this->queryResult->fetch_row())	{

      $this->insertResultHeader($table, $i);
      $this->insertSingleResult($row);

      $i++;
      $this->sqlString .= (($i != 0) && ($i % 100 == 0) || ($i == $this->tableNumberOfRows)) ? ";" : ",";

		}

    $this->sqlString .= "\n\n\n";

  }



  private function getTableData($table) {

  	$this->queryResult	= $this->mySqli->query('SELECT * FROM `' . $table . '`');
    $this->tableFieldCount = $this->queryResult->field_count;
    $this->tableNumberOfRows = $this->mySqli->affected_rows;

  }



  private function insertResultHeader($table, $currentRowNumber) {

  	if ($currentRowNumber % 100 == 0 || $currentRowNumber == 0 )	{
      $this->sqlString .= "\nINSERT INTO " . $table . " VALUES";
    }

  }



  private function insertSingleResult($row) {

    $this->sqlString .= "\n(";

    for($i = 0; $i < $this->tableFieldCount; $i++){

      $row[$i] = str_replace("\n","\\n", addslashes($row[$i]));

      $this->sqlString .= (isset($row[$i])) ? '"'.$row[$i].'"' : '""';
      if($i < ($this->tableFieldCount-1)){
        $this->sqlString.= ',';
      }

    }

    $this->sqlString .=")";

  }



  private function generateSqlFooter() {

    $this->sqlString .=  "\r\n\r\n";
    $this->sqlString .=  '/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;';
    $this->sqlString .=  "\r\n";
    $this->sqlString .=  '/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;';
    $this->sqlString .=  "\r\n";
    $this->sqlString .=  '/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;';

  }



  public function downloadFile() {

      ob_get_clean();
      header('Content-Type: application/octet-stream');
      header("Content-Transfer-Encoding: Binary");
      header('Content-Length: '. (function_exists('mb_strlen') ? mb_strlen($this->sqlString, '8bit'): strlen($this->sqlString)) );
      header("Content-disposition: attachment; filename=\"".$this->fileName."\"");
    	echo $this->sqlString; exit;

  }


}

?>