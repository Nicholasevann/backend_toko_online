<?php
    header("Content-Type:application/json");
     
    $method = $_SERVER['REQUEST_METHOD'];

    $result = array();

    if($method == 'POST'){
        if(isset($_POST['nama']) AND isset($_POST['email']) AND isset($_POST['password']) AND isset($_POST['no_telepon']) AND isset($_POST['alamat'])){
            $nama = $_POST['nama'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $no_telepon = $_POST['no_telepon'];
            $alamat = $_POST['alamat'];
            $result['status'] = [
                "code" => 200,
                "desc" => '1 data inserted'
            ];
            $mysqli = new mysqli("localhost","root","","toko_penjualan");
            $sql = "INSERT INTO user (nama, email, password, no_telepon, alamat) VALUES('$nama', '$email', '$password', '$no_telepon', '$alamat')";
            $mysqli->query($sql);
        } else{
            $result['status'] = [
                "code" => 400,
                "desc" => "Paramater Invalid"
            ];
        }
    }

    echo json_encode($result);