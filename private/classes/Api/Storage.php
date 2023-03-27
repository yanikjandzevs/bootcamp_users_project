<?php
namespace Api;

class Storage
{

  private $data;
  private $file_name;

  public function __construct($storage_name) {
    $this->file_name = PRIVATE_DIR . $storage_name . '.json';
    $this->data = [
      "entries" => [],
      "last_id" => 0
    ];

    if (file_exists($this->file_name)) {
      $json = file_get_contents($this->file_name);
      $data = json_decode($json, true);
      if (is_array($data)) {
        $this->data = $data;
      }
    }
  }

  public function getAll() {
    return $this->data['entries'];
  }

  public function create($arr) {
    $id = ++$this->data['last_id'];
    $arr['id'] = $id;
    $this->data['entries'][$id] = $arr;

    file_put_contents($this->file_name, json_encode($this->data, JSON_PRETTY_PRINT));

    return $id;
  }

  private function delete($ids) {
    foreach ($ids as $id) {
      if (isset($this->data['entries'][$id])) {
        unset($this->data['entries'][$id]);
      }
    }

    file_put_contents($this->file_name, json_encode($this->data, JSON_PRETTY_PRINT));
  }
}