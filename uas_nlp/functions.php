<?php

include_once("connection.php");

function ifsubmit()
{
    $var = array();
    if (isset($_POST['submit'])) {
        $input = $_POST['input'];
        $filtered = strtolower($input);
        $filtered = preg_replace('[\r\n]', '', $filtered);
        $filtered = preg_replace('[\!\(\<\]\@\)\:\|\#\;\\\$\,\/\+\%\„\?\=\^\"\{\_\&\}\,\*\>\[\t\r\n(\(.*\))(\d+\/\d+\/\d+)\d+]', '', $filtered);
        $filtered = explode(".", $filtered);
        $tokens = array();
        $salah = array();
        $i = 0;
        foreach ($filtered as $sentence) {
            $sentence = trim($sentence);
            if (strlen($sentence)  < 2) {
                continue;
            }
            $inner = explode(' ', $sentence);
            $l = 0;
            foreach ($inner as $word) {
                $l++;
                if ($l == 1) continue;
                if (!dict_lookup($word)) {
                    // [0] = token awal
                    // [1] = token index-1
                    // [2] = index sentence
                    // [3] = index col in sentence
                    // [4] = token akhir
                    array_push($salah, array($word, $inner[$l - 2], $i, $l - 1, $word));
                }
            }
            array_push($tokens, $inner);
            $i++;
        }
        for ($i = 0; $i < count($salah); $i++) {
            $leven = levdist($salah[$i][0]);
            if (($i > 0) && ($salah[$i][3] == $salah[$i - 1][3] + 1)) {
                $salah[$i][4] = bigram($salah[$i - 1][4], $leven);
            } else {
                print_r($salah[$i]);
                $salah[$i][4] = bigram($salah[$i][1], $leven);
            }
        }
        // foreach ($salah as $key => $slh) {
        //     $leven = levdist($slh[0]);
        //     $salah[$key][4] = bigram($slh[1], $leven);
        // }
        $assemble = array();
        $i = 0;
        foreach ($tokens as $token) {
            $local_token = $token;
            foreach ($salah as $key => $slh) {
                if ($slh[2] == $i) {
                    $local_token[$slh[3]] = $slh[4];
                }
            }
            $inner = implode(' ', $local_token);
            array_push($assemble, $inner);
            $i++;
        }
        $output = implode('. ', $assemble);
        $var['input'] = $input;
        $var['output'] = $output;
    } else {
        $var['input'] = '';
        $var['output'] = '';
    }
    return $var;
}

function dict_lookup($word)
{
    global $conn;
    $sql = "SELECT COUNT(kata) FROM tabel_kamus WHERE kata='$word'";
    $result = $conn->query($sql);
    if ($row = $result->fetch_row()) {
        if ($row[0] > 0)
            return true;
    }
    return false;
}

function levdist($input)
{
    global $conn;
    $data = array();
    $sql = "SELECT * FROM tabel_kamus";

    if ($result = $conn->query($sql)) {
        while ($row = $result->fetch_row()) {
            array_push($data, $row[1]);
        }
        $result->free_result();
    }

    $lev = array();

    foreach ($data as $data2) {
        if (levenshtein($input, $data2) <= 2) {
            array_push($lev, $data2);
        }
    }
    return $lev;
}

function bigram($word1, $array)
{
    global $conn;
    $data = array();
    foreach ($array as $key => $word2) {
        $freq = 0;
        $sql = "SELECT freq FROM tabel_bigram WHERE word1='$word1' AND word2='$word2'";
        if ($result = $conn->query($sql)) {
            $rowcount = mysqli_num_rows($result);
            if ($rowcount == 0)
                $freq = 0;
            else {
                $row = $result->fetch_row();
                $freq = $row[0];
            }
            $result->free_result();
        }
        $sql = "SELECT SUM(freq) FROM tabel_bigram WHERE word1='$word1'";
        if ($result = $conn->query($sql)) {
            while ($row = $result->fetch_row()) {
                if ($row[0] == 0)
                    $data[$word2] = 0;
                else
                    $data[$word2] = ($freq / $row[0]);
            }
            $result->free_result();
        }
    }
    print_r($data);
    $freq_max = 0;
    $word_max = "";
    foreach ($data as $word2 => $freq) {
        if ($freq_max <= $freq) {
            $word_max = $word2;
            $freq_max = $freq;
        }
    }
    return $word_max;
}

// function _levdist($input)
// {
//     global $conn;
//     $data = array();
//     $sql = "SELECT * FROM tabel_kamus";

//     if ($result = $conn->query($sql)) {
//         while ($row = $result->fetch_row()) {
//             array_push($data, $row[1]);
//         }
//         $result->free_result();
//     }

//     $lev = array();

//     foreach ($data as $data2) {
//         if (_levenshtein($input, $data2) <= 2) {
//             array_push($lev, $data2);
//         }
//     }
//     return $lev;
// }

// function _levenshtein($s, $t)
// {
//     $d = array();
//     $s = " " . $s;
//     $t = " " . $t;
//     $m = strlen($s);
//     $n = strlen($t);


//     for ($i = 0; $i < $m; $i++) {
//         for ($l = 0; $l < $n; $l++) {
//             $d[$i][$l] = 0;
//         }
//     }

//     for ($i = 1; $i < $m; $i++) {
//         $d[$i][0] = $i;
//     }

//     for ($i = 1; $i < $n; $i++) {
//         $d[0][$i] = $i;
//     }

//     for ($i = 1; $i < $m; $i++) {
//         for ($l = 1; $l < $n; $l++) {
//             if ($s[$i] === $t[$l])
//                 $substitutionCost = 0;
//             else
//                 $substitutionCost = 1;

//             $d[$i][$l] = min(
//                 $d[$i - 1][$l] + 1,                  // Deletion
//                 $d[$i][$l - 1] + 1,                  // Insertion          
//                 $d[$i - 1][$l - 1] + $substitutionCost  // Subtitution
//             );
//         }
//     }
//     // for ($i = 0; $i < $m; $i++) {
//     //     for ($l = 0; $l < $n; $l++) {
//     //         printf("[%d]", $d[$i][$l]);
//     //     }
//     //     printf("\n");
//     // }
//     return $d[$m - 1][$n - 1];
// }
