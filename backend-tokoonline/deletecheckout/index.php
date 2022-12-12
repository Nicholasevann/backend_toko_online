<?php
    header("Content-Type:application/json");
     
    $method = $_SERVER['REQUEST_METHOD'];

    $result = array();
    if($method == 'POST'){
        if(isset($_POST['id_checkout'])){
            $mysqli = new mysqli("localhost","root","","toko_penjualan");
            $id_checkout = $_POST['id_checkout'];
            $data = mysqli_query($mysqli,"delete from checkout where id_checkout='$id_checkout'");
            $result['status'] = [
                "code" => 200,
                "desc" => 'Data delete success',
            ];
        } else{
            $result['status'] = [
                "code" => 400,
                "desc" => "Paramater Invalid"
            ];
        }
    }
    echo json_encode($result);

  