<?php
$input2 = 'biayaa';
$data = array();
$mysqli = new mysqli("localhost","root","","nlp");

function generateUBT($input)
	{
		$arr_input = explode(' ', $input);

		// bigram
		$x = 0;
		$bigram = '';
		foreach ($arr_input as $item) {
			if ($x < 1) {
				$bigram .= $item.' ';
				$x++;
			} else {
				$bigram .= $item.', ';
				$x = 0;
			}
		}
		$bigram = substr($bigram, 0, -1);



		$result .= 'Bigram : '. $bigram . '<br>';

		return $result;
	}

	echo generateUBT('Jakarta adalah ibukota negara Republik Indonesia Serikat');
  
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}

$sql = "SELECT * FROM tabel_kamus";

if ($result = $mysqli -> query($sql)) {
    while ($row = $result -> fetch_row()) {
    array_push($data,$row[1]);
    }
    $result -> free_result();
  }
  
  $mysqli -> close();
// array of words to check against
$words  = array('apple','pineapple','banana','orange',
                'radish','carrot','pea','bean','potato','bisa','basi');
$lev = array();

foreach ($data as $data2) {
    if(levenshtein($input2, $data2)<=2){
    array_push($lev,$data2);
    }
}
print_r($lev);
echo '<br>';
foreach ($lev as $lev2) {
    echo $lev2 , '<br>';
}
?>