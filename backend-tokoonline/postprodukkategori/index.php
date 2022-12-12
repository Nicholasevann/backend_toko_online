<?php
    header("Content-Type:application/json");
     
    $method = $_SERVER['REQUEST_METHOD'];

    $result = array();
    if($method == 'POST'){
        if(isset($_POST['id_kategori'])){
            $mysqli = new mysqli("localhost","root","","toko_penjualan");
            $id_kategori = $_POST['id_kategori'];
            $data = mysqli_query($mysqli,"select * from produk where id_kategori='$id_kategori'");
            $cek = mysqli_num_rows($data);
            $hasil = [];
            while($row = $data->fetch_assoc()) { 
                $arr = array(
                    'id_produk' => $row['id_produk'],
                    'sku' => $row['sku'],
                    'nama_produk' => $row['nama_produk'],
                    'id_kategori' => $row['id_kategori'],
                    'gambar' => $row['gambar'],
                    'harga' => $row['harga'],
                    'min_pemesanan' => $row['min_pemesanan'],
                    'berat' => $row['berat'],
                    'stok' => $row['stok'],
                    'preorder' => $row['preorder'],
                    'berbahaya' => $row['berbahaya'],
                    'status' => $row['status'],
                    'deskripsi' => $row['deskripsi'],
                    'nama_kategori' => $row['nama_kategori'],
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

  