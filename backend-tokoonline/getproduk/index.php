<?php
$mysqli = new mysqli("localhost","root","","toko_penjualan");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$sql = "SELECT * FROM produk";
$result = $mysqli->query($sql);
$hasil = [];
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $arr = array(
        'id_produk' => $row['id_produk'],
        'sku' => $row['sku'],
        'nama_produk' => $row['nama_produk'],
        'id_kategori' => $row['id_kategori'],
        'gambar' => $row['gambar'],
        'harga' => $row['harga'],
        'min_pemesanan' => $row['min_pemesanan'],
        'berat' => $row['berat'],
        'preorder' => $row['preorder'],
        'berbahaya' => $row['berbahaya'],
        'stok' => $row['stok'],
        'status' => $row['status'],
        'deskripsi' => $row['deskripsi'],
        'nama_kategori' => $row['nama_kategori'],
    );

    array_push($hasil,$arr);
  }
} else {
  echo "0 results";
}
echo json_encode($hasil);
$conn->close();