<?php
    header("Content-Type:application/json");
     
    $method = $_SERVER['REQUEST_METHOD'];

    $result = array();
    if($method == 'POST'){
        if(isset($_POST['email']) AND isset($_POST['password'])){
            $mysqli = new mysqli("localhost","root","","toko_penjualan");
            $email = $_POST['email'];
            $password = $_POST['password'];
            $data = mysqli_query($mysqli,"select * from user where email='$email' and password='$password'");
            $cek = mysqli_num_rows($data);
            
            while($row = $data->fetch_assoc()) { 
                $result['status'] = [
                    "code" => 200,
                    "desc" => 'Login success',
                    "data" => [
                        'id_user' => $row['id_user'],
                        'nama' => $row['nama'],
                        'email' => $row['email'],
                        'password' => $row['password'],
                        'no_telp' => $row['no_telepon'],
                        'alamat' => $row['alamat'],
                    ]
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

  