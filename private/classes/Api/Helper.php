<?php
namespace Api;

use Database\DB;

class Helper
{
  private $storage;

  public function __construct($storage_name) {
    $this->storage = new DB($storage_name);
  }

  public function addRealEstate(array $data) {
    if (!isset($data['address']) || !is_string($data['address']))
      return false;
    if (!isset($data['price']) || !is_string($data['price']))
      return false;
    if (!isset($data['sqm']) || !is_string($data['sqm']))
      return false;

    $time = time();
    $values = [
      'address' => $data['address'],
      'price' => $data['price'],
      'sqm' => $data['sqm'],
      'created_at' => date('d.m.Y. h:i:s', $time)
    ];

    $values['id'] = $this->storage->create($values);

    $values['created_at'] = date('d.m.Y. h:i', $time);

    return $values;
  }

  public function addUser(array $data) {
    if (!isset($data['firstname']) || !is_string($data['firstname']))
      return false;
    if (!isset($data['lastname']) || !is_string($data['lastname']))
      return false;
    if (!isset($data['phone']) || !is_string($data['phone']))
      return false;
    if (!isset($data['email']) || !is_string($data['email']))
      return false;

    $time = time();
    $values = [
      'firstname' => $data['firstname'],
      'lastname' => $data['lastname'],
      'phone' => $data['phone'],
      'email' => $data['email'],
      'created_at' => date('Y-m-d h:i:s', $time)
    ];

    $id = $this->storage->create($values);

    $values['created_at'] = date('d.m.Y. h:i', $time);
    $values['id'] = $id;

    return $values;
  }

  public function updateUser(array $data) {
    if (!isset($data['id']) || !is_string($data['id']))
      return false;
    $id = (int) $data['id'];
    if ($id <= 0) {
      return false;
    }
    if (!isset($data['firstname']) || !is_string($data['firstname']))
      return false;
    if (!isset($data['lastname']) || !is_string($data['lastname']))
      return false;
    if (!isset($data['phone']) || !is_string($data['phone']))
      return false;
    if (!isset($data['email']) || !is_string($data['email']))
      return false;

    $values = [
      'firstname' => $data['firstname'],
      'lastname' => $data['lastname'],
      'phone' => $data['phone'],
      'email' => $data['email']
    ];

    $this->storage->update($id, $values);

    $values['id'] = $id;

    return $values;
  }

  public function deleteUsers(array $data) {
    if (!isset($data['id']) || !is_string($data['id']))
      return false;
    $ids = explode(',', $data['id']);

    foreach ($ids as $index => $id) {
      if (!is_string($id))
        return false;
        $ids[$index] = (int) $id;
      if ($ids[$index] <= 0) {
        return false;
      }
    }

    // TODO: fix users deletion;
    $this->storage->delete($ids);
  }

  public function getUsers() {
    $all_users = [];
    foreach ($this->storage->getAll() as $user) {
      $user['created_at'] = date('d.m.Y. H:i', strtotime($user['created_at']));
      $all_users[$user['id']] = $user;
    }
    return $all_users;
  }

  public function getUser(array $data) {
    if (!isset($data['id']) || !is_string($data['id']))
      return false;
    $id = (int) $data['id'];
    if ($id <= 0) {
      return false;
    }

    return $this->storage->get($id);
  }

  public function getStorage() {
    return $this->storage;
  }
}

// START EXPERIMENT
// $a = 5;

// 5 => true
// "fsdfasd" => true
// [2,4,3] => true

// [] => false
// "" => false
// 0 => false

// function getValue() {
//   return true;
// }

// if (getValue() === false) {
//   echo "hello world";
// }

// $str = "Hello world!";
// $word = "world";
// define('SYMBOL', '!');
// $str = "Hello" . " " . $word . SYMBOL;