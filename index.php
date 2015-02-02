<?php
include('config.php');
$sql = '
SELECT COLUMN_NAME
FROM information_schema.columns
WHERE TABLE_SCHEMA = "' . $db_name . '" 
ORDER BY COLUMN_NAME ASC
'; 
$req = $db->prepare($sql);
$req->execute();
$columns = $req->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Dataiku</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
<script src="js/jquery.js"></script>
<script src="js/spin.js"></script>
<script src="js/main.js"></script>
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
             
<body id="index" class="home">
<h1>Values details</h1>
<br />
<form class='form-inline'>
<div class='form-group'>
    <p class="form-control-static">Values : </p>
</div>
<div class='form-group'>
<select id='select' name='values' class='form-control' onchange='updatetable(this)'>
    <?php
    foreach($columns as $column) {
        $column_name = htmlspecialchars($column['COLUMN_NAME'], ENT_QUOTES);
        if ($column_name == "age")
            continue;
        echo '<option value=\'' . $column_name . '\'>' . $column_name . '</option>';
    }
    ?>
</select> 
</div>
</form>
<br>
<div id="total_values">
</div>
<br>
<table class='table table-striped table-hover'>
<thead>
<tr>
<th>Rank</th>
<th>Value</th>
<th>Count</th>
<th>Average</th>
</tr>
</thead>
<tbody id='table_values'>

</tbody>
</table>
</body>
</html>
