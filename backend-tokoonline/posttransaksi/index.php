<?php
    header("Content-Type:application/json");
     
    $method = $_SERVER['REQUEST_METHOD'];

    $result = array();

    if($method == 'POST'){
        if(isset($_POST['nama_barang']) AND isset($_POST['total_barang']) AND isset($_POST['gambar']) AND isset($_POST['total_harga']) AND isset($_POST['id_user'])){
            $nama_barang = $_POST['nama_barang'];
            $total_barang = $_POST['total_barang'];
            $gambar = $_POST['gambar'];
            $total_harga = $_POST['total_harga'];
            $id_user = $_POST['id_user'];
            $result['status'] = [
                "code" => 200,
                "desc" => '1 data inserted'
            ];
            $mysqli = new mysqli("localhost","root","","toko_penjualan");
            $sql = "INSERT INTO checkout (nama_barang, total_barang, gambar, total_harga, id_user) VALUES('$nama_barang', '$total_barang', '$gambar', '$total_harga', '$id_user')";
            $mysqli->query($sql);
        } else{
            $result['status'] = [
                "code" => 400,
                "desc" => "Paramater Invalid"
            ];
        }
    }

    echo json_encode($result);