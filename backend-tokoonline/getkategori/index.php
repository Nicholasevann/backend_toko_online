<?php
$mysqli = new mysqli("localhost","root","","toko_penjualan");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$sql = "SELECT * FROM kategori_produk";
$result = $mysqli->query($sql);
$hasil = [];
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $arr = array(
        'id_kategori' => $row['id_kategori'],
        'nama_kategori' => $row['nama_kategori'],
        'gambar_kategori' => $row['gambar_kategori'],
        
    );

    array_push($hasil,$arr);
  }
} else {
  echo "0 results";
}
echo json_encode($hasil);
$conn->close();