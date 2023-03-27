<?php
header('Content-Type: application/json; charset=utf-8');

use Api\Helper;

define('PRIVATE_DIR', dirname(__DIR__) . '/private/');
include(PRIVATE_DIR . 'autoloader.php');
include(PRIVATE_DIR . 'functions.php');

if (
  isset($_GET['action']) && is_string($_GET['action'])
) {
  $output = doAction($_GET['action']);
}
else {
  $output = [
    'status' => false,
    'message' => 'No action specified'
  ];
}

echo json_encode($output, JSON_PRETTY_PRINT);

function doAction(string $action_name) {
  try {
    $helper = new Helper('users');

    $output = ['status' => true];
    
    if ($action_name == 'get-users') {
      $output['result'] = "All Users will be here";
      $output['entries'] = $helper->getUsers();
      return $output;
    }

    if ($action_name == 'get-single-user') {
      $output['result'] = "Single user";
      $output['entry'] = $helper->getUser($_GET);
      return $output;
    }

    if ($action_name == 'add-user') {
      $entry = $helper->addUser($_POST);
      $output['result'] = "User has been added";
      $output['entry'] = $entry;
      return $output;
    }

    if ($action_name == 'update-user') {
      $entry = $helper->updateUser($_POST);
      $output['result'] = "User information has been updated";
      $output['entry'] = $entry;
      return $output;
    }
    

    if ($action_name == 'delete-users') {
      $helper->deleteUsers($_POST);
      $output['result'] = "Ids deleted";
      return $output;
    }

    $message = "Action is not supported.";
  }
  catch (Exception $exception) {
    storeError($exception->getMessage());
    $message = 'Error has accured.';
  }

  return ['status' => false, 'message' => $message];
}

/*
Javascript
JSON.stringify({key: "this is message"}); => '{"key": "this is message"}';
JSON.parse('{"key": "this is message"}') => {key: "this is message"};

PHP
json_encode(["key" => "this is message"]); => '{"key": "this is message"}';
json_decode('{"key": "this is message"}', true) => ["key" => "this is message"];
*/