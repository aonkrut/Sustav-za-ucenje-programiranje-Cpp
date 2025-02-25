<?php

	class SQLDB {
		
		var $host = DB_HOST;
		var $username = DB_USERNAME;
		var $password = DB_PASSWORD;
		var $database = DB_DATABASE;

        //static protected $db;
		protected $db;

		function __construct() {
			$this->connect();
		}

		function getDBInstance() {
			if(!isset($this->db)) {
				$this->connect();
			}
			return $this->db;
		}

		function connect() {
			global $url;
			try {
				$db = new PDO('mysql:host='.$this->host.';dbname='.$this->database.';', $this->username, $this->password);
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				$this->db = $db;
			} catch (PDOException $e) {
				echo "Greska kod povezivanja sa bazom podataka. (".$e->getMessage().")";
				// $this->mysqlError($query, $url, $e->getMessage());
			}
		}
	
		function selectFrom($query, $datas, $forLoop = true) {
			global $url;
			$db = $this->getDBInstance();
			try {
				$stmt = $db->prepare($query);
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
				$stmt->execute($datas);

				//RESULTS
				$result['rowCount'] = $stmt->rowCount();
				if($forLoop == true) {
					$i = 0;
					while($row = $stmt->fetch()) {
						$result['data'][$i] = $row; 
						$i++;
					}
				} else {
					$result['data'] = $stmt->fetch();
				}
				//RESULTS - end
		
			} catch (PDOException $e) {
				$this->mysqlError($query, $url, $e->getMessage());
			}

			return $result;
		}

		function deleteFrom($query, $datas = array()) {
			global $url;
			$db = $this->getDBInstance();
			try {
				$stmt = $db->prepare($query);	
				$stmt->execute($datas);
			} catch (PDOException $e) {
				$this->mysqlError($query, $url, $e->getMessage());
			}
		}

		function insertInto($query, $datas = array()) {
			global $url;
			$db = $this->getDBInstance();
			try {
				$stmt = $db->prepare($query);
				$stmt->execute($datas);
                return $db->lastInsertId();
			} catch (PDOException $e) {
				$this->mysqlError($query, $url, $e->getMessage());
			}
		}

		function update($query, $datas = array()) {
			global $url;
			$db = $this->getDBInstance();
			try {
				$stmt = $db->prepare($query);
				$stmt->execute($datas);
				return $stmt->fetch(PDO::FETCH_ASSOC);
			} catch (PDOException $e) {
				$this->mysqlError($query, $url, $e->getMessage());
			}
		}

		function mysqlError($query_type, $location, $msg) {	
			$db = $this->getDBInstance();
			$stmt = $db->prepare("INSERT INTO mysql_errors (query, location, msg) VALUES (?, ?, ?)");
			$stmt->execute(array($query_type, $location, $msg));
		}

	}



?>
