<?php
    header("Content-Type:application/json");
     
    $method = $_SERVER['REQUEST_METHOD'];

    $result = array();
    if($method == 'POST'){
        if(isset($_POST['id_user'])){
            $mysqli = new mysqli("localhost","root","","toko_penjualan");
            $id_user = $_POST['id_user'];
            $data = mysqli_query($mysqli,"select * from checkout where id_user='$id_user'");
            $cek = mysqli_num_rows($data);
            $hasil = [];
            while($row = $data->fetch_assoc()) { 
                $arr = array(
                    'id_checkout' => $row['id_checkout'],
                    'id_user' => $row['id_user'],
                    'nama_barang' => $row['nama_barang'],
                    'total_barang' => (int)$row['total_barang'],
                    'gambar' => $row['gambar'],
                    'total_harga' => (int)$row['total_harga'],
                    'checked' => $row['checked'] = "0" ? true : false,
                );
                array_push($hasil,$arr);
                $result['status'] = [
                    "code" => 200,
                    "desc" => 'Data success',
                    "data" =>  $hasil
                    
                ];
            }
            
            // echo json_encode($arr);die;
        } else{
            $result['status'] = [
                "code" => 400,
                "desc" => "Paramater Invalid"
            ];
        }
    }
    echo json_encode($result);

  