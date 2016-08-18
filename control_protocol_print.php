<!DOCTYPE html>
<html lang="en">
<head>
  <title>STOP Zakażeniom! - Dodaj oddział</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <link rel="stylesheet" href="_bootstrap-datetimepicker.scss">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="bootstrap-datetimepicker.js"></script>
  <style>
    /* Set height of the grid so .sidenav can be 100% (adjust if needed) */
    .row.content {height: 1500px}
    
    /* Set gray background color and 100% height */
    .sidenav {
      background-color: #f1f1f1;
      height: 100%;
    }
    
    /* Set black background color, white text and some padding */
    footer {
      background-color: #555;
      color: white;
      padding: 15px;
    }
    
    /* On small screens, set height to 'auto' for sidenav and grid */
    @media screen and (max-width: 767px) {
      .sidenav {
        height: auto;
        padding: 15px;
      }
      .row.content {height: auto;} 
    }
  </style>
</head>
<body>
<?php

include 'config.php';
include 'functions.php';
db_connect();
$inspection_name = get_object_data ("inspection", "name", $_GET['inspection_id']);
$oddzial_name = get_object_data ("oddzial", "name", $_GET['oddzial_id']);
?>
   <hr style="background: black; border: 1px solid black;" color="black">
      <h4><center><b>Protokół kontroli <u><?php echo ($inspection_name); ?></u> na oddziale <u><?php echo ($oddzial_name); ?></u> w dniu<b> 29 Kwietnia 2016</b></center>   </h4>
      <hr style="background: black; border: 1px solid black;" color="black" size="1">

<?php 

?>
<center>
 <table class="table table-bordered" style="border: 1px solid black; width: 94%; text-align: center;">
    <thead style="border: 1px solid black;">
      <tr style="border: 1px solid black;">
        <th style="border: 1px solid black; text-align: center;">Pomieszczenie</th>
        <th style="border: 1px solid black; text-align: center;">Punkt kontrolowany</th>
        <th style="border: 1px solid black; text-align: center;">Ocena</th>

      </tr>
    </thead>
    <tbody style="border: 1px solid black;">
   
   <?php
   
    $inspections = mysql_query("SELECT * FROM inspections WHERE id='".$_GET['inspection_id']."';");
    $i        = null;
    while ($inspections_row = mysql_fetch_array($inspections)) {
        
        $pomieszczenia = mysql_query("SELECT * FROM inspections_data WHERE oddzial_id='".$_GET['oddzial_id']."' AND inspection_id='".$_GET['inspection_id']."';");
        
    while ($pomieszczenia_row = mysql_fetch_array($pomieszczenia)) {
	  $i++;
	    $b = $pomieszczenia_row['pomieszczenie_id'];
		$cp_number = count_control_points_in_pomieszczenie ($pomieszczenia_row['pomieszczenie_id']);
		$cp_name = get_object_data ("control_point", "name", $pomieszczenia_row['cp_id']);
		$pomieszczenie_name = get_object_data ("pomieszczenie", "name", $pomieszczenia_row['pomieszczenie_id']);
		echo ('<tr style="border: 1px solid black;">');
		//echo ($i."");
		if ($b != $b_prev ) {
        echo ('<td style="border: 1px solid black;" rowspan="'.$cp_number.'">'.$pomieszczenie_name.'</td>');
    }
    //	$b = true;
      echo ('  <td style="border: 1px solid black;">'.$cp_name.'</td>
     
        <td style="border: 1px solid black;">1</td>
      </tr>');
        	$b_prev = $pomieszczenia_row['pomieszczenie_id'];
	
	}
       
       
    }
    
   
   ?>
      
      
     
    </tbody>
  </table>
        <hr style="background: black; border: 1px solid black;" color="black" size="1">

</center>



</body>
</html>




