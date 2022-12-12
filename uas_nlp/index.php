<?php

include('functions.php');

$var = ifsubmit();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>

<body>
    <form action="index.php" method="POST">
        <textarea style="overflow:auto;resize:none" class="txt" name="input" rows=12 cols=80><?php echo $var['input'] ?></textarea>
        <input name="submit" type="submit" value="KOREKSI">
        <textarea readonly style=" overflow:auto;resize:none" class="txt" name="output" rows=12 cols=80><?php echo $var['output'] ?></textarea>
    </form>
</body>

</html>