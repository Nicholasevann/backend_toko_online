<?php
$mysqli = new mysqli("localhost","root","","toko_penjualan");

// Check connection
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$sql = "SELECT * FROM transaksi";
$result = $mysqli->query($sql);
$hasil = [];
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $arr = array(
        'id_transaksi' => $row['id_transaksi'],
        'invoice' => $row['invoice'],
        'tanggal_pembelian' => $row['tanggal_pembelian'],
        'id_produk' => $row['id_produk'],
        'qty' => $row['qty'],
        'id_user' => $row['id_user'],
        'gambar' => $row['gambar'],
        'total' => $row['total'],
        'nama_produk' => $row['nama_produk'],
    
    );

    array_push($hasil,$arr);
  }
} else {
  echo "0 results";
}
echo json_encode($hasil);
$conn->close();