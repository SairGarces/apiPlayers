<?php
include('lib/functions.php');
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


if ($_SERVER['REQUEST_METHOD'] == "GET" && $_SERVER['REQUEST_URI'] == "/read") {
  if (isset($_GET['id'])) {
    $id =  $_GET['id'];
    $json = get_single_players_info($id);

    echo json_encode($json);
  } else {
    $json = get_all_player_list();
    echo json_encode($json);
  }
}


if ($_SERVER['REQUEST_METHOD'] == "GET" && $_SERVER['REQUEST_URI'] == "/calculate") {
  $players = get_all_player_list();
  $ages = array();
  $sumAge = 0;
  foreach ($players as $player) {
    $sumAge = $sumAge + getage($player["birthdate"]);
  }
  count($players);
  echo json_encode($sumAge / count($players));
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_SERVER['REQUEST_URI'] == "/create") {
  $data = json_decode(file_get_contents('php://input'), true);

  $name = $data['name'];
  $team = $data['team'];
  $position = $data['position'];
  $birthdate = $data['birthdate'];
  $cups = $data['cups'];

  $json = add_player_info($name, $team, $position, $birthdate, $cups);
  echo json_encode($json);
}

if ($_SERVER['REQUEST_METHOD'] == "PUT" && $_SERVER['REQUEST_URI'] == "/update") {
  $data = json_decode(file_get_contents('php://input'), true);

  $id = $data['id'];
  $name = $data['name'];
  $team = $data['team'];
  $position = $data['position'];
  $birthdate = $data['birthdate'];
  $cups = $data['cups'];

  $json = update_player_info($id, $name, $team, $position, $birthdate, $cups);
  echo json_encode($json);
}

if ($_SERVER['REQUEST_METHOD'] == "DELETE" && $_SERVER['REQUEST_URI'] == "/delete") {
  $data = json_decode(file_get_contents('php://input'), true);

  $id = $data['id'];

  $json = delete_player_info($id);
  echo json_encode($json);
}
