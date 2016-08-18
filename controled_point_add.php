<!DOCTYPE html>
<html lang="en">
<head>
  <title>STOP Zakażeniom! - Dodaj oddział</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
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

?>
<div class="container-fluid">
  <div class="row content">
    <div class="col-sm-3 sidenav">
      <h4><b>Zarządzanie</b></h4>
      <ul class="nav nav-pills nav-stacked">
        <li ><a href="index.php">Strona główna</a></li>
        <li ><a href="oddzial_add.php">Dodaj oddział</a></li>
        <li class="active"><a href="controled_point_add.php">Dodaj punkt kontrolowany</a></li>
        <li><a href="inscect_mode_menu.php">Przejdź do trybu inspekcji</a></li>
        <li><a href="pomieszczenie_add.php">Dodaj pomieszczenie w oddziale</a></li>
      </ul><br>
    <hr>
    <center>
   <b> &copy; Copyright | Created by Wiktor Jezioro
   <br><?php echo ($szpital_name); ?></center></b>
    </div>
<center><h3><b>Stop zakażeniom - dodaj punkt kontrolowany w pomieszczeniu <?php $pomieszczenie_name; ?> w oddziale <?php echo $oddzial_name; ?></b></h3></center>
<hr>
    <div class="col-sm-9">
      <h4><small><b>Dodawanie punktu, który będzie kontrolowany</b></small></h4>
      <hr>

<?php
     
     if (isset($_GET['oddzial_id'])) {
		 
		$oddzial_name = get_object_data ("oddzial", "name", $_GET['oddzial_id']);
		$pomieszczenie_name = get_object_data ("pomieszczenie", "name", $_GET['pomieszczenie_id']);
		 
		      if (isset($_GET['pomieszczenie_id'])) {
		 
		 if (isset($_POST['cp_name']))
	{
	if (empty($_POST['cp_name']) != true)
		{
		if (controled_point_add($_POST['cp_name'], $_POST['cp_text'], $_GET['pomieszczenie_id']))
			{
			echo ('<div class="panel panel-default">
  <div class="panel-body" style="background: #1ED658;"><b>Punkt kontrolowany '.$_POST['cp_name'].'  został dodany pomyślnie do pomieszczenia '.$pomieszczenie_name.'  w oddziale  '.$oddzial_name.' !</b>
  <hr><center>
  
  
  <a href="controled_point_add.php?oddzial_id='.$_GET['oddzial_id'].'"><button style="width: 99%; color: black; background: yellow;" type="button" class="btn">Dodaj kolejny punkt kontrolowany w tym oddziale</button></a>
 <br>
 <br>
  <a href="controled_point_add.php?pomieszczenie_id='.$_GET['pomieszczenie_id'].'&oddzial_id='.$_GET['oddzial_id'].'"><button style="width: 99%; color: black; background: yellow;" type="button" class="btn">Dodaj kolejny punkt kontrolowany w tym pomieszczeniu</button></a>
   <br>
 <br>
  <a href="controled_point_add.php"><button style="width: 99%; color: black; background: yellow;" type="button" class="btn">Dodaj kolejny punkt kontrolowany w innym oddziale</button></a>
  
  
  
  </center>
  
  </div>
</div>
');
			}
		  else
			{
				
			 echo (' <h3><b>Krok 3 - Wprowadź nazwę punktu kontrolowanego</b> który zostanie dodany w pomieszczeniu <b>'.$pomieszczenie_name.'</b> w oddziale <b>'.$oddzial_name.'</b></h3>
      <hr>');
	echo ('
  	<form action="controled_point_add.php?pomieszczenie_id='.$_GET['pomieszczenie_id'].'&oddzial_id='.$_GET['oddzial_id'].'" method="POST">
<div class="form-group">
  <label for="usr">Nazwa punktu kontrolowanego:</label>
  <input name="cp_name" type="text" class="form-control" id="usr">
</div>

 <div class="form-group">
  <label for="comment">Opis punktu kontrolowanego (opcjonalnie):</label>
  <textarea name="cp_text" class="form-control" rows="5" id="comment"></textarea>
</div>
<button style="width: 35%;" type="submit" class="btn btn-info">Dodaj punkt kontrolowany</button>
<button style="width: 25%;" type="button" class="btn btn-danger">Anuluj</button>
</form>');
		}
		}
	  else  // jeżeli nazwa jest pusta
		{
			 echo (' <h3><b>Krok 3 - Wprowadź nazwę punktu kontrolowanego</b> który zostanie dodany w pomieszczeniu <b>'.$pomieszczenie_name.'</b> w oddziale <b>'.$oddzial_name.'</b></h3>
      <hr>');
		echo ('  
	
	<div class="panel panel-default">
  <div class="panel-body" style="background: #FF3665; color: white;"><b>Nazwa punktu kontrolowanego nie może byc pusta!</b>
  </div>
</div>
	
	  	<form action="controled_point_add.php?pomieszczenie_id='.$_GET['pomieszczenie_id'].'&oddzial_id='.$_GET['oddzial_id'].'" method="POST">
<div class="form-group">
  <label for="usr">Nazwa punktu kontrolowanego:</label>
  <input name="cp_name" type="text" class="form-control" id="usr">
</div>

 <div class="form-group">
  <label for="comment">Opis punktu kontrolowanego (opcjonalnie):</label>
  <textarea name="cp_text" class="form-control" rows="5" id="comment"></textarea>
</div>
<button style="width: 35%;" type="submit" class="btn btn-info">Dodaj punkt kontrolowany</button>
<button style="width: 25%;" type="button" class="btn btn-danger">Anuluj</button>
</form>');
		}
	}
  else  // jeżeli nie został kliknięty przycisk
	{
			 echo (' <h3><b>Krok 3 - Wprowadź nazwę punktu kontrolowanego</b> który zostanie dodany w pomieszczeniu <b>'.$pomieszczenie_name.'</b> w oddziale <b>'.$oddzial_name.'</b></h3>
      <hr>');
 echo ('
		 	  	<form action="controled_point_add.php?pomieszczenie_id='.$_GET['pomieszczenie_id'].'&oddzial_id='.$_GET['oddzial_id'].'" method="POST">
<div class="form-group">
  <label for="usr">Nazwa punktu kontrolowanego:</label>
  <input name="cp_name" type="text" class="form-control" id="usr">
</div>

 <div class="form-group">
  <label for="comment">Opis punktu kontrolowanego (opcjonalnie):</label>
  <textarea name="cp_text" class="form-control" rows="5" id="comment"></textarea>
</div>
<button style="width: 35%;" type="submit" class="btn btn-info">Dodaj punkt kontrolowany</button>
<button style="width: 25%;" type="button" class="btn btn-danger">Anuluj</button>
</form>');
	}
		 
		
	} else //  gdy nie zostało jeszcze wybrane pomieszczenie
	
	{
		/// pokazanie listy pomieszczeń
		
	  echo (' <h3><b>Krok 2 - Wybierz pomieszczenie</b></h3>
      <hr>');
     print_pomieszczenia_list($_GET['oddzial_id'] ,true, "controled_point_add.php", false, "&oddzial_id=".$_GET['oddzial_id']."");
	
	
	} 
		
		
		 
		 
	
	
	
	
	
	 } else { // gdy nie został jeszcze wybrany oddział
     
     echo (' <h3><b>Krok 1 - Wybierz oddział</b></h3>
      <hr>');
     print_oddzial_list(true, "controled_point_add.php?tmp=0", false);
     
 }
     
     ?>


    </div>
  </div>
</div>

<footer class="container-fluid">
  <p>&copy; by <b>Wiktor Jezioro</b> | 2016 | <b>This program is open source software - GNU General public license</b></p>
</footer>

</body>
</html>





<div class="panel panel-default">
  <div class="panel-body" style="background: #1ED658;"><b>Punkt kontrolowany  $control_point_name  został dodany pomyślnie do pomieszczenia  $pomieszczenie_name  w oddziale  echo $oddzial_name !</b>
  <hr><center><button style="width: 35%; background: yellow;" type="button" class="btn">Dodaj kolejny oddział</button></center>
  </div>
</div>

