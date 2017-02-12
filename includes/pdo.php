<?php
class sql extends PDO {
	public $result;
	private $pdo;
	private $error;
	private $no_quotes;
	private $bind_count;

	/********************************************
		Construct
	********************************************/
	public function __construct($host = DB_HOST, $user = DB_USER, $pass = DB_PASS, $database = DB_DATABASE) {
		// set connection options
		$options = array(
			PDO::ATTR_PERSISTENT => true,
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		);

		// connect to PDO
		try {
			$this->pdo = new PDO("mysql:host={$host};dbname={$database}", $user, $pass, $options);
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
			$this->show_error();
		}

		$this->no_quotes = array('NULL', 'NOW()', 'UTC_TIMESTAMP()');
	}


	/********************************************
		Query
	********************************************/
	function query($query, $bind = array(), $redirect_url = '') {
		$this->query = $query;
		$this->bind = $bind;

		// run query
		try {
			$this->result = $this->pdo->prepare($query);
			$this->result->execute($bind);
		// throw error
		} catch (PDOException $e) {
			$this->error = $e->getMessage();
			$this->show_error();
		}

		// redirect if no results
		if (!empty($redirect_url)) {
			if ($this->row_count() <= 0) {
				gtfo($redirect_url);
			}
		}

		//$query_count++;
		return $this->result;
	}

	/********************************************
		Row Count
	********************************************/
	function row_count($result = false) {
		if ($result === false) {
			$result = $this->result;
		}

		return $result->rowCount();
	}

	function num_rows($result = false) {
		if ($result === false) {
			$result = $this->result;
		}

		return $result->rowCount();
	}

	/********************************************
		Fetch
	********************************************/
	function fetch($result = false) {
		if ($result === false) {
			$result = $this->result;
		}

		return $result->fetch(PDO::FETCH_ASSOC);
	}

	function fetch_all($result = false) {
		if ($result === false) {
			$result = $this->result;
		}

		return $result->fetchAll(PDO::FETCH_ASSOC);
	}

	/********************************************
		Insert
	********************************************/
	function insert($data = array(), $table) {
		if (empty($data) || !is_array($data)) {
			return false;
		}

		$table = sanitize_sql_string($table);
		$this->bind_count = 1;

		// multiple sets of values
		if (is_array($data[0])) {
			$values = '';
			$fields = '';
			$bind = array();

			foreach ($data as $insert_data) {
				$prepared_values = $this->prepare_insert_values($insert_data);
				$bind += $prepared_values['bind'];
				$values .= $prepared_values['values'] . ',';

				// check if sets match
				if ($fields != $prepared_values['fields']) {
					if ($fields != '') {
						return false;
					}

					// fields only need to be set once
					$fields = $prepared_values['fields'];
				}
			}

			$values = substr($values, 0, -1);
		// single set of values
		} else {
			$prepared_values = $this->prepare_insert_values($data);
			$fields = $prepared_values['fields'];
			$values = $prepared_values['values'];
			$bind = $prepared_values['bind'];
		}

		// insert to db
		$query = "	INSERT
					INTO `$table` $fields
					VALUES $values";

		return $this->query($query, $bind);
	}

	/********************************************
		Insert or Update
	********************************************/
	function insert_update($data = array(), $table) {
		if (empty($data) || !is_array($data)) {
			return false;
		}

		$table = sanitize_sql_string($table);
		$this->bind_count = 1;

		// multiple sets of values
		if (is_array($data[0])) {
			$values = '';
			$fields = '';
			$bind = array();

			foreach ($data as $insert_data) {
				$prepared_values = $this->prepare_insert_values($insert_data);
				$bind += $prepared_values['bind'];
				$values .= $prepared_values['values'] . ',';

				// check if sets match
				if ($fields != $prepared_values['fields']) {
					if ($fields != '') {
						return false;
					}

					// fields only need to be set once
					$fields = $prepared_values['fields'];
				}
			}

			$values = substr($values, 0, -1);

		// single set of values
		} else {
			$prepared_values = $this->prepare_insert_values($data);
			$fields = $prepared_values['fields'];
			$values = $prepared_values['values'];
			$bind = $prepared_values['bind'];
		}

		// for update
		$this->bind_count = 1;
		$upd_values = '';
		foreach ($data as $key => $upd_value) {
			$key = preg_replace('/[^a-z0-9_]*/is','', $key);

			// bind?
			if (in_array($upd_value, $this->no_quotes)) {
				$upd_values .= "`$key` = $upd_value,";
			} else {
				$upd_values .= "`$key` = :bind{$this->bind_count},";

				$bind += array(
					"bind{$this->bind_count}" => $upd_value,
				);

				$this->bind_count++;
			}
		}

		$upd_values = substr($upd_values,0, -1);

		// insert to db
		$query = "	INSERT
					INTO `$table` $fields
					VALUES $values
					ON DUPLICATE KEY UPDATE
					$upd_values";

		return $this->query($query, $bind);
	}

	/********************************************
		Prepare Insert Values
	********************************************/
	function prepare_insert_values($data) {
		$fields = '(';
		$values = '(';

		$bind = array();

		foreach ($data as $key => $value) {
			// sanitize field
			$key = preg_replace('/[^a-z0-9_]*/is', '', $key);
			$fields .= "`$key`,";

			if ($value === '') {
				$value = 'NULL';
			}

			// values - bind or not?
			if (in_array($value, $this->no_quotes)) {
				$values .= "{$value},";
			} else {
				$values .= ":bind{$this->bind_count},";

				$bind += array(
					"bind{$this->bind_count}" => $value,
				);

				$this->bind_count++;
			}

		}

		$fields = substr($fields, 0, -1) . ')';
		$values = substr($values, 0, -1) . ')';

		return array(
			'fields' => $fields,
			'values' => $values,
			'bind' => $bind,
		);
	}

	/********************************************
		Update
	********************************************/
	function update($data = array(), $table = '', $condition = '', $bind = array()) {
		if (empty($data) || !is_array($data) || empty($condition)) {
			return false;
		}

		$table = sanitize_sql_string($table);
		$this->bind_count = 1;
		$values = '';

		// prepare values
		foreach ($data as $key => $value) {
			$key = preg_replace('/[^a-z0-9_]*/is','', $key);

			// bind?
			if (in_array($value, $this->no_quotes)) {
				$values .= "`$key` = $value,";
			} else {
				$values .= "`$key` = :bind{$this->bind_count},";

				$bind += array(
					"bind{$this->bind_count}" => $value,
				);

				$this->bind_count++;
			}
		}

		$values = substr($values,0, -1);

		// insert to db
		$query = "	UPDATE `$table`
					SET $values
					WHERE $condition";

		return $this->query($query, $bind);
	}

	/********************************************
		Delete
	********************************************/
	function delete($table = '', $condition = '', $bind = array()) {
		if (empty($table)) {
			return false;
		}

		if (empty($condition)) {
			$query = "TRUNCATE `$table`";
		} else {
			$query = "	DELETE
						FROM `$table`
						WHERE $condition";
		}

		return $this->query($query, $bind);
	}

	/********************************************
		Database Transaction
	********************************************/
	function begin() {
		return $this->pdo->beginTransaction();
	}

	function commit() {
		return $this->pdo->commit();
	}

	function rollback() {
		return $this->pdo->rollBack();
	}

	/********************************************
		Last Insert ID
	********************************************/
	function insert_id() {
		return $this->pdo->lastInsertId();
	}

	/********************************************
		Error
	********************************************/
	function show_error() {
		$backtrace = debug_backtrace();
		ss('bind data:', $this->bind);

		$output = "
			<p>
				<b>Query was:</b><br>
				<span style=\"color: #FF0000;\">{$this->query}</span>
			</p>
			<p>
				<b>Error was:</b><br>
				<span style=\"color: #FF0000;\">{$this->error}</span>
			</p>
			<p>
				<table width=\"100%\" border=\"1\">
					<tr>
						<td width=\"150\"><b>Host:</b></td>
						<td>{$_SERVER['HTTP_HOST']}</td>
					</tr>
					<tr>
						<td width=\"150\"><b>Request URI:</b></td>
						<td>{$_SERVER['REQUEST_URI']}</td>
					</tr>
					<tr>
						<td width=\"150\"><b>File:</b></td>
						<td>{$backtrace[0]['file']}</td>
					</tr>
					<tr>
						<td width=\"150\"><b>Line:</b></td>
						<td>{$backtrace[0]['line']}</td>
					</tr>
				</table>
			</p>";

		ss($output);
		exit;
	}
}
