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
        <li class="active"><a href="oddzial_add.php">Dodaj oddział</a></li>
        <li><a href="controled_point_add.php">Dodaj punkt kontrolowany</a></li>
        <li><a href="inscect_mode_menu.php">Przejdź do trybu inspekcji</a></li>
        <li><a href="pomieszczenie_add.php">Dodaj pomieszczenie w oddziale</a></li>
      </ul><br>
    <hr>
    <center>
   <b> &copy; Copyright | Created by Wiktor Jezioro
   <br><?php echo ($szpital_name); ?></center></b>
    </div>
<center><h3><b>Stop zakażeniom - dodaj oddział</b></h3></center>
<hr>
    <div class="col-sm-9">
      <h4><small><b>Dodawanie oddziału</b></small></h4>
      <hr>

<?php 

if (isset($_POST['oddzial_name']))
	{
	if (empty($_POST['oddzial_name']) != true)
		{
		if (oddzial_add($_POST['oddzial_name'], $_POST['oddzial_opis']))
			{
			echo ('<div class="panel panel-default">
  <div class="panel-body" style="background: #1ED658;"><b>Oddział został dodany pomyślnie!</b>
  <hr><center><a href="oddzial_add.php"><button style="width: 35%; color: black; background: yellow;" type="button" class="btn">Dodaj kolejny oddział</button></a></center>
  </div>
</div>');
			}
		  else
			{
			echo ('  
	<form action="oddzial_add.php" method="POST">
<div class="form-group">
  <label for="usr">Nazwa oddziału:</label>
  <input  name="oddzial_name" type="text" class="form-control" id="usr">
</div>

 <div class="form-group">
  <label for="comment">Opis oddziału (opcjonalne) :</label>
  <textarea  name="oddzial_opis" class="form-control" rows="5" id="comment"></textarea>
</div>
<button style="width: 35%;" type="submit" class="btn btn-info">Dodaj oddział</button>
<button style="width: 25%;" type="button" class="btn btn-danger">Anuluj</button> </form>');
			}
		}
	  else
		{
		echo ('  
	
	<div class="panel panel-default">
  <div class="panel-body" style="background: #FF3665; color: white;"><b>Nazwa oddziału nie może byc pusta!</b>
  </div>
</div>
	
	<form action="oddzial_add.php" method="POST">
<div class="form-group">
  <label for="usr">Nazwa oddziału:</label>
  <input name="oddzial_name" type="text" class="form-control" id="usr">
</div>

 <div class="form-group">
  <label for="comment">Opis oddziału (opcjonalne) :</label>
  <textarea name="oddzial_opis" class="form-control" rows="5" id="comment"></textarea>
</div>
<button style="width: 35%;" type="submit" class="btn btn-info">Dodaj oddział</button>
<button style="width: 25%;" type="button" class="btn btn-danger">Anuluj</button> </form>');
		}
	}
  else
	{
	echo ('  
	<form action="oddzial_add.php" method="POST">
<div class="form-group">
  <label for="usr">Nazwa oddziału:</label>
  <input  name="oddzial_name" type="text" class="form-control" id="usr">
</div>

 <div class="form-group">
  <label for="comment">Opis oddziału (opcjonalne) :</label>
  <textarea  name="oddzial_opis" class="form-control" rows="5" id="comment"></textarea>
</div>
<button style="width: 35%;" type="submit" class="btn btn-info">Dodaj oddział</button>
<button style="width: 25%;" type="button" class="btn btn-danger">Anuluj</button> </form>');
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
