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
$oddzial_name = get_object_data ("oddzial", "name", $_GET['oddzial_id']);

?>
<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4><b>Zarządzanie</b></h4>
      <ul class="nav nav-pills nav-stacked">
        <li ><a href="index.php">Strona główna</a></li>
        <li ><a href="oddzial_add.php">Dodaj oddział</a></li>
        <li><a href="controled_point_add.php">Dodaj punkt kontrolowany</a></li>
        <li class="active"><a href="inscect_mode_menu.php">Przejdź do trybu inspekcji</a></li>
        <li><a href="pomieszczenie_add.php">Dodaj pomieszczenie w oddziale</a></li>
      </ul><br>
    <hr>
    <center>
   <b> &copy; Copyright | Created by Wiktor Jezioro
   <br><?php echo ($szpital_name);
   		$inspection_name = get_object_data ("inspection", "name", $_GET['inspection_id']);
   		$inspection_type = get_object_data ("inspection", "type", $_GET['inspection_id']);
   		$inspection_mode = get_object_data ("inspection", "mode", $_GET['inspection_id']);
   		$inspection_mode_int = get_object_data ("inspection", "mode_INT", $_GET['inspection_id']);
    ?></center></b>
    </div>
<center><h3><b>Stop zakażeniom - <?php echo $inspection_name ?> - inspekcja <?php echo $inspection_type; echo "&nbsp;"; echo $inspection_mode; ?></b></h3></center>
<hr>
    <div class="col-sm-9">
      <h4><small><b>Inspekcja w trakcie</b></small></h4>
      <h4><b> 
		  <?php
		  
		  if (isset($_GET['oddzial_id'])) {
			  
			  echo ("<a href='inspection_excuting.php?checking_inspection_id=".$_GET['checking_inspection_id']."&checking_for_inspection=".$_GET['checking_for_inspection']."&inspection_id=".$_GET['inspection_id']."'>".$oddzial_name."</a>");
		  }
		  
		 
		  
		   if (isset($_GET['pomieszczenie_id'])) {
			  
			  $pomieszczenie_name = get_object_data ("pomieszczenie", "name", $_GET['pomieszczenie_id']);
			  echo (" &gt; <a href='inspection_excuting.php?checking_inspection_id=".$_GET['checking_inspection_id']."&oddzial_id=".$_GET['oddzial_id']."&checking_for_inspection=".$_GET['checking_for_inspection']."&inspection_id=".$_GET['inspection_id']."'>".$pomieszczenie_name."</a>");
		  }
		  
		  ?>
		  </b></h4>
      <hr>

<?php 

$checking_inspection_id = $_GET['checking_inspection_id'];
if (isset($_GET['oddzial_id'])) {
		 
		$oddzial_name = get_object_data ("oddzial", "name", $_GET['oddzial_id']);
		$pomieszczenie_name = get_object_data ("pomieszczenie", "name", $_GET['pomieszczenie_id']);
		 
		      if (isset($_GET['pomieszczenie_id'])) {
		 
		 
		 ///////// CHANGE STATE REQUEST HANDLER ///////
		 if (isset($_GET['inspection_id']) &&
		     isset($_GET['control_point_id']) &&
		     isset($_GET['answer'])) {
			$timestamp = time();
			mysql_query("INSERT INTO inspections_data ( cp_id, state, vote_date, inspection_id, oddzial_id , pomieszczenie_id )
                       VALUES
                       ( '".$_GET['control_point_id']."', '".$_GET['answer']."', '".$timestamp."', '".$_GET['inspection_id']."', '".$_GET['oddzial_id']."', '".$_GET['pomieszczenie_id']."' );");
	
			 
			 
		 }
		 //////////////////////////////////////////////
		 
		 
	print_controled_points_list ($_GET['pomieszczenie_id'],  2, false, $inspection_mode_int, $_GET['inspection_id'], $checking_inspection_id);
		 
		 
		 
		 
		
	} else //  gdy nie zostało jeszcze wybrane pomieszczenie
	
	{
		/// pokazanie listy pomieszczeń
		
	  echo (' <h3><b>Krok 2 - Wybierz pomieszczenie</b></h3>
      <hr>');
     print_pomieszczenia_list($_GET['oddzial_id'] ,true, "inspection_excuting.php", false, "&inspection_id=".$_GET['inspection_id']."&checking_inspection_id=".$_GET['checking_inspection_id']."&oddzial_id=".$_GET['oddzial_id']."");
	
	
	} 
		
		
		 
		 
	
	
	
	
	
	 } else { // gdy nie został jeszcze wybrany oddział
     
     echo (' <h3><b>Krok 1 - Wybierz oddział</b></h3>
      <hr>');
     print_oddzial_list(true, "inspection_excuting.php?inspection_id=".$_GET['inspection_id']."&checking_inspection_id=".$_GET['checking_inspection_id']."", false);
     
 }

?>

	<form action="inspection_add.php" method="POST">



<button style="width: 35%;" type="submit" class="btn btn-info">Dodaj nową inspekcję</button>
<button style="width: 25%;" type="button" class="btn btn-danger">Anuluj</button> 
</form>

    </div>
  </div>
</div>

<footer class="container-fluid">
  <p>&copy; by <b>Wiktor Jezioro</b> | 2016 | <b>This program is open source software - GNU General public license</b></p>
</footer>

</body>
</html>
