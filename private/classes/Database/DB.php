<?php
namespace Database;

class DB
{
  private $conn;
  private $table_name;

  public function __construct($table_name) {
    $servername = "localhost";
    $username = "20_bootcamp";
    $password = "20_bootcamp";
    $dbname = "20_bootcamp";

    $this->table_name = $table_name;

    $this->conn = new \mysqli($servername, $username, $password, $dbname);
    if ($this->conn->connect_error) {
      die("Connection failed: " . $this->conn->connect_error);
    }
  }

  public function __destruct() {
    $this->conn->close();
  }

  public function create(array $values) {
    $str_columns = "";
    $str_values = "";

    foreach ($values as $key => $value) {
      $str_columns .= $key . ',';
      $str_values .= "'" . $this->conn->real_escape_string($value) . "',";
    }
    $str_columns = substr($str_columns, 0, -1);
    $str_values = substr($str_values, 0, -1);

    $sql = "INSERT INTO " . $this->table_name . " ($str_columns)
    VALUES ($str_values)";

    if ($this->conn->query($sql) === false) {
      throw new \Exception('SQL error: ' . $this->conn->error);
    }

    return $this->conn->insert_id;
  }

  public function update(int $id, array $values) {
    $str_set = "";
    foreach ($values as $key => $value) {
      $str_set .= $key . "='" . $this->conn->real_escape_string($value) . "',";
    }
    $str_set = substr($str_set, 0, -1);

    $id = $this->conn->real_escape_string($id);
    $sql = "UPDATE " . $this->table_name . " SET $str_set WHERE id = '$id'";

    if ($this->conn->query($sql) === false) {
      throw new \Exception('SQL error: ' . $this->conn->error);
    }
  }

  public function getAll() {
    $sql = "SELECT * FROM " . $this->table_name;

    $result = $this->conn->query($sql);
    if ($result === false) {
      throw new \Exception('SQL error: ' . $this->conn->error);
    }

    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function get(int $id) {
    $id = $this->conn->real_escape_string($id);
    $sql = "SELECT * FROM " . $this->table_name. " WHERE id = '$id'";

    $result = $this->conn->query($sql);
    if ($result === false) {
      throw new \Exception('SQL error: ' . $this->conn->error);
    }

    return $result->fetch_assoc();
  }

  public function delete(array $ids) {
    if (empty($ids)) {
      return;
    }

    $str_ids = "";
    foreach ($ids as $index => $id) {
      $str_ids .= "'" .$this->conn->real_escape_string($id) . "',";
    }
    $str_ids = substr($str_ids, 0, -1);

    $sql = "DELETE FROM " . $this->table_name . " WHERE id IN (" . $str_ids . ")";

    if ($this->conn->query($sql) === false) {
      throw new \Exception('SQL error: ' . $this->conn->error);
    }
  }
}