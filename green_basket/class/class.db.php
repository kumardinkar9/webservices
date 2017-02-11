<?php

class DB {

	var $server;
	var $user;
	var $pass;
	var $db;
	var $tbl_name;
	var $field_value;
	public static $commit = "COMMIT";
	var $conn;

	function __construct($server, $user, $pass, $db) {
		$this->server = $server;
		$this->user = $user;
		$this->pass = $pass;
		$this->db = $db;
		$this->conn = mysql_connect($this->server, $this->user, $this->pass) or die("Error Connection : " . mysql_error());
		//mysql_set_charset('ISO-8859-15', $this->conn);
		mysql_set_charset('utf8', $this->conn);
		mysql_select_db($this->db) or die("Error Database : " . mysql_error());
	}

	function startTrans() {
		mysql_query("BEGIN", $this->conn);
	}

	function commit() {
		if (self::$commit == "ROLLBACK") {
			$msg = "rolled_back";
		} else {
			$msg = "success";
		}
		mysql_query(self::$commit);
		return $msg;
	}

	function setField($allfields) {
		$fields = "";

		foreach ($allfields as $field => $value) {
			if (is_int($value)) {
				$fields .= " `{$field}`={$value},";
			} else {
				$fields .= " `{$field}`='{$value}',";
			}
		}
		$fields = rtrim($fields, ",");
		$this->field_value = $fields;
	}

	function insert($tbl_name, $allfields) {
		$this->setField($allfields);
		$sql_ = "INSERT INTO {$tbl_name} SET {$this->field_value}";
		$sql_;

		$rs_ = mysql_query($sql_) or die("Error : " . mysql_error());
		if (!$rs_)
			self::$commit = "ROLLBACK";
		$af_row = mysql_affected_rows();
		return $af_row;
	}

	function last_insert_id() {
		return mysql_insert_id();
	}

	function update($tbl_name, $allfields, $clause = "1") {
		$this->setField($allfields);
		$sql_ = "UPDATE {$tbl_name} SET {$this->field_value} WHERE {$clause}";
		//echo $sql_; die;

		$rs_ = mysql_query($sql_);
		if (!$rs_)
			self::$commit = "ROLLBACK";
		$affected = mysql_affected_rows();

		return $affected;
	}

	function delete($tbl_name, $clause = "1") {
		$sql_ = "DELETE FROM `{$tbl_name}` WHERE {$clause}";
		$rs_ = mysql_query($sql_);
		if (!$rs_)
			self::$commit = "ROLLBACK";
		$affected = mysql_affected_rows($rs_);

		return $affected;
	}

	function get($tbl_name, $fields, $clause = "1") {
		$dataset = array();
		$sql_ = "SELECT {$fields} FROM {$tbl_name} WHERE {$clause}";
		//echo $sql_;
		$rs_ = mysql_query($sql_);
		$i = 0;
		while ($ds_ = mysql_fetch_object($rs_)) {
			$dataset[$i++] = $ds_;
		}

		return $dataset;
	}

	function query($sql) {
		$dataset = array();
		$rs_ = mysql_query($sql);
		if (!$rs_)
			self::$commit = "ROLLBACK";
		$i = 0;
		while ($ds_ = mysql_fetch_object($rs_)) {
			$dataset[$i++] = $ds_;
		}
		return $dataset;
	}

}

?>