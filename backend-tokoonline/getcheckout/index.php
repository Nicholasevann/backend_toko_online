<?php
$mysqli = new mysqli("localhost","root","","toko_penjualan");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$sql = "SELECT * FROM checkout";
$result = $mysqli->query($sql);
$hasil = [];
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $arr = array(
        'id_checkout' => $row['id_checkout'],
        'nama_barang' => $row['nama_barang'],
        'total_barang' => $row['total_barang'],
        'gambar' => $row['gambar'],
        'total_harga' => $row['total_harga'],
    );

    array_push($hasil,$arr);
  }
} else {
  echo "0 results";
}
echo json_encode($hasil);
$conn->close();