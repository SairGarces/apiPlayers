<?php
include 'database.php';

function get_all_player_list() 
{
    $pdo = Database::connect();
    $sql = "SELECT * FROM player"; /**Selecciona la tabla de palyer en la base de datos */

    try {

        $query = $pdo->prepare($sql);
        $query->execute();
        $all_player_info = $query->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {

        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    Database::disconnect();
    return $all_player_info;
}

function get_single_players_info($id)
{
    $pdo = Database::connect();
    $sql = "SELECT * FROM players where id = {$id} ";

    try {

        $query = $pdo->prepare($sql);
        $query->execute();
        $players_info = $query->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {

        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    Database::disconnect();
    return $players_info;
}

function getAge($fecha_de_nacimiento) {
    $anio_actual = date("Y");
    $componentes_fecha_nacimiento = explode("-", $fecha_de_nacimiento);
    $anio_nacimiento = $componentes_fecha_nacimiento[0];
    $edad_en_anos = $anio_actual - $anio_nacimiento;
    return $edad_en_anos;
}



function update_player_info($id,$name, $team, $position, $birthdate, $cups)
{
    $pdo = Database::connect();
    $sql = "UPDATE 
    player SET name = '{$name}', 
    team = '{$team}', 
    position = '{$position}', 
    birthdate = '{$birthdate}', 
    cups = '{$cups}' where 
    id = '{$id}'";
    $status = [];

    try {

        $query = $pdo->prepare($sql);
        $result = $query->execute();
        if($result)
        {
            $status['message'] = "Data updated";
        }
        else{
            $status['message'] = "Data is not updated";
        }

    } catch (PDOException $e) {

        $status['message'] = $e->getMessage(); 
    }

    Database::disconnect();
    return $status;
}


function add_player_info($name, $team, $position, $birthdate, $cups)
{
    $pdo = Database::connect();
    $sql = "INSERT INTO player(`name`, `team`, `position`, `birthdate`, `cups`) VALUES('{$name}', '{$team}', '{$position}', '{$birthdate}', '{$cups}')";
    $status = [];

    try {

        $query = $pdo->prepare($sql);
        $result = $query->execute();
        if($result)
        {
            $status['message'] = "Data inserted";
        }
        else{
            $status['message'] = "Data is not inserted";
        }

    } catch (PDOException $e) {

        $status['message'] = $e->getMessage(); 
    }

    Database::disconnect();
    return $status;
}

function delete_player_info($id)
{
    $pdo = Database::connect();
    $sql ="DELETE FROM player where id = '{$id}'";
    $status = [];

    try {

        $query = $pdo->prepare($sql);
        $result = $query->execute();
        if($result)
        {
            $status['message'] = "Data deleted";
        }
        else{
            $status['message'] = "Data is not deleted";
        }

    } catch (PDOException $e) {

        $status['message'] = $e->getMessage(); 
    }

    Database::disconnect();
    return $status;
}