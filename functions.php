<?php
/// STOP Zakazeniom version. 1.0 ALPHA
/// Copyright (C) by Wiktor Jezioro
/// Distributed in GNU General Public license
///////////////////////////////

///////////////////////////////
/// Searching for relations beetwen inspections
function get_relations_in_inspection ($actual_inspection, $prev_or_next_insp) {
    db_connect();
        $inspections      = mysql_query("SELECT * FROM inspections WHERE id='".$actual_inspection."' AND checking_for_inspection='".$prev_or_next_insp."';");
        $inspections_rows = mysql_num_rows($inspections);
    if ($inspections_rows > 0) {
		return true;
	} else {
		
		
		
	}
        
}


//////////////////////////////
/// Count control points in pomieszczenie///

function count_control_points_in_pomieszczenie ($pomieszczenie_id) {
	
	  db_connect();
        $inspections      = mysql_query("SELECT * FROM control_points WHERE pomieszczenie_id='".$pomieszczenie_id."';");
        $inspections_rows = mysql_num_rows($inspections);
    
        return $inspections_rows;  
	
}

////////////////////////////////
//// STATISTICS ///////////////

function  print_all_inspections_number() {
        db_connect();
        $inspections      = mysql_query("SELECT * FROM inspections;");
        $inspections_rows = mysql_num_rows($inspections);
    
        return $inspections_rows;  
    
}

function all_votes ($inspection_type) {
	
}

function print_statistics($parametr) {
        db_connect();
        if ($parametr == "all_good") {
			 $data      = mysql_query("SELECT * FROM inspections_data WHERE state=1;");
			 $data_rows = mysql_num_rows($data);
			 echo ($data_rows); 
		} 
		///////////////////////
		if ($parametr == "all_bad") {
			 $data      = mysql_query("SELECT * FROM inspections_data WHERE state=0;");
			 $data_rows = mysql_num_rows($data);
			 echo ($data_rows); 
		}
		///////////////////////
		if ($parametr == "all_oddzialy") {
			 $data      = mysql_query("SELECT * FROM oddzialy;");
			 $data_rows = mysql_num_rows($data);
			 echo ($data_rows); 
		}
		///////////////////////
		if ($parametr == "all_pomieszczenia") {
			 $data      = mysql_query("SELECT * FROM pomieszczenia;");
			 $data_rows = mysql_num_rows($data);
			 echo ($data_rows); 
		}
		///////////////////////
		if ($parametr == "all_cp") {
			 $data      = mysql_query("SELECT * FROM control_points;");
			 $data_rows = mysql_num_rows($data);
			 echo ($data_rows); 
		}
		///// PROCENTY //////
		///////////////////////
		if ($parametr == "all_good_percent") {
			 $data      = mysql_query("SELECT * FROM inspections_data WHERE state=1;");
			 $data_rows = mysql_num_rows($data);
			
			
			$dobre_pr = procent_proporcja ($data_rows, all_votes($inspection_type));
			return $dobre_pr;
		}
		////////////////////////
    
    
}
//////////////////////////////

function count_votes_in_oddzial ($oddzial_id, $vote_type) {
	 db_connect();
     
     $vote_type = (int)$vote_type;
     
			 $data      = mysql_query("SELECT * FROM inspections_data WHERE state='".$vote_type."' AND oddzial_id='".$oddzial_id."';");
			 $summary = mysql_num_rows($data);
	
		///////////////////////
	
	return (int)$summary;
}
//////////////////////////////

function procent_proporcja ($a, $wszystko) {
	////
	//// x = (a * 100%) / all
	////
	////
	$x = ($a * 100) / $wszystko;
	
	return $x;
	
}


///// STATISTICS END ///////////
////////////////////////////////

function oddzial_add($name, $description)
{
    
    db_connect();
    $timestamp = time();
    mysql_query("INSERT INTO oddzialy ( oddzial_name, oddzial_text, create_date )
                       VALUES
                       ( '" . $name . "', '" . $description . "', '" . $timestamp . "' );");
    
    return true;
}

/////////////////////////////

function pomieszczenie_add($name, $description, $oddzial_id)
{
    
    
    db_connect();
    $timestamp = time();
    mysql_query("INSERT INTO pomieszczenia ( pomieszczenie_name, pomieszczenie_text, pomieszczenie_create_date,  oddzial_id )
                       VALUES
                       ( '" . $name . "', '" . $description . "', '" . $timestamp . "', '" . $oddzial_id . "' );");
    
    return true;
    
}

///////////////////////////////

function controled_point_add($name, $description, $pomieszczenie_id)
{
    
    db_connect();
    
    $timestamp = time();
    mysql_query("INSERT INTO control_points ( cp_name, cp_description, cp_create_date,  pomieszczenie_id )
                       VALUES
                       ( '" . $name . "', '" . $description . "', '" . $timestamp . "', '" . $pomieszczenie_id . "' );");
    
    
    return true;
    
}

////////////////////////////////////

function count_pomieszczenia_in_oddzial($oddzial_id)
{
    db_connect();
    $pomieszczenia      = mysql_query("SELECT * FROM pomieszczenia WHERE oddzial_id=" . $oddzial_id . ";");
    $pomieszczenia_rows = mysql_num_rows($pomieszczenia);
    
    return $pomieszczenia_rows;
}

///////////////////////////////////

function print_oddzial_list($why_option, $choice_referer, $delete)
{
    
    echo ('     <table  class="table table-hover table-bordered">
    <thead style="background: #A2E7FA; ">
      <tr>
        <th>Lp.</th>
        <th>Nazwa oddziału</th>
        <th>Opis oddziału</th>
        <th>Data dodania</th>
        <th>Ilość pomieszczeń</th>
        <th>Ilość punktów kontrolowanych</th>
       ');
    if ($delete == true) {
        echo (' 
        <th>Usuwanie</th>');
    }
    
    if ($why_option == true) {
        echo (' 
        <th>Wybór</th>');
    }
    
    echo (' 
      
      </tr>
    </thead>
    <tbody>');
    
    $oddzialy = mysql_query("SELECT * FROM oddzialy;");
    $i        = null;
    while ($oddzialy_row = mysql_fetch_array($oddzialy)) {
        $i++;
        echo (' <tr>');
        echo (' <td>' . $i . '</td>');
        echo (' <td>' . $oddzialy_row['oddzial_name'] . '</td>');
        echo (' <td>' . $oddzialy_row['oddzial_text'] . '</td>');
        echo (' <td>' . $oddzialy_row['create_date'] . '</td>');
        echo (' <td>' . $pomieszczenia_oddzial . '</td>');
        echo (' <td>' . $punkty_kontrolowane_oddzial . '</td>');
        
        if ($delete == true) {
            echo (' <td><a href="delete.php?type=oddzial&oddzial_id=' . $oddzialy_row['id'] . '"><button type="button" style="width: 100%;" class="btn btn-danger">Usuń</button></a></td>');
        }
        if ($why_option == true) {
            echo (' <td><a href="' . $choice_referer . '&oddzial_id=' . $oddzialy_row['id'] . '"><button type="button" style="width: 100%;" class="btn btn-warning">Wwbierz</button></a></td>');
        }
        
        echo (' </tr>');
    }
    
    echo ('    
    </tbody> </table> ');
    
}

////////////////////////////

function print_pomieszczenia_list($oddzial_id, $why_option, $choice_referer, $delete, $more_GET_values)
{
    
    
    echo ('     <table  class="table table-hover table-bordered">
    <thead style="background: #A2E7FA; ">
      <tr>
        <th>Lp.</th>
        <th>Nazwa pomieszczenia</th>
        <th>Opis pomieszczenia</th>
        <th>Oddział</th>
        <th>Ilość punktów kontrolowanych</th>
       ');
    if ($delete == true) {
        echo (' 
        <th>Usuwanie</th>');
    }
    
    if ($why_option == true) {
        echo (' 
        <th>Wybór</th>');
    }
    
    echo (' 
      
      </tr>
    </thead>
    <tbody>');
    
    $oddzialy     = mysql_query("SELECT * FROM pomieszczenia WHERE oddzial_id=" . $oddzial_id . ";");
    $oddzial_name = get_object_data("oddzial", "name", $_GET['oddzial_id']);
    $i            = null;
    while ($oddzialy_row = mysql_fetch_array($oddzialy)) {
        $i++;
        echo (' <tr>');
        echo (' <td>' . $i . '</td>');
        echo (' <td>' . $oddzialy_row['pomieszczenie_name'] . '</td>');
        echo (' <td>' . $oddzialy_row['pomieszczenie_text'] . '</td>');
        echo (' <td>' . $oddzial_name . '</td>');
        echo (' <td>' . $punkty_kontrolowane_pomieszczenie . '</td>');
        
        if ($delete == true) {
            echo (' <td><a href="delete.php?type=pomieszczenie&oddzial_id=' . $oddzialy_row['id'] . '"><button type="button" style="width: 100%;" class="btn btn-danger">Usuń</button></a></td>');
        }
        if ($why_option == true) {
            echo (' <td><a href="' . $choice_referer . '?pomieszczenie_id=' . $oddzialy_row['id'] . $more_GET_values . '"><button type="button" style="width: 100%;" class="btn btn-warning">Wwbierz</button></a></td>');
        }
        
        echo (' </tr>');
    }
    
    echo ('    
    </tbody> </table> ');
    
}

////////////////////////////

function get_object_data($object_type, $object_property, $object_id)
{
    
    db_connect();
    
    if ($object_type == "oddzial") {
        if ($object_property == "name") {
            
            $object_mysql_result = mysql_query("SELECT * FROM oddzialy WHERE id='" . $object_id . "';");
            while ($object_row = mysql_fetch_array($object_mysql_result)) {
                return $object_row['oddzial_name'];
            }
        }
        
    }
    //////////////////////
    if ($object_type == "pomieszczenie") {
        if ($object_property == "name") {
            
            $object_mysql_result = mysql_query("SELECT * FROM pomieszczenia WHERE id='" . $object_id . "';");
            while ($object_row = mysql_fetch_array($object_mysql_result)) {
                return $object_row['pomieszczenie_name'];
            }
        }
        
    }
    //////////////////////
     //////////////////////
    if ($object_type == "control_point") {
        if ($object_property == "name") {
            
            $object_mysql_result = mysql_query("SELECT * FROM control_points WHERE id='" . $object_id . "';");
            while ($object_row = mysql_fetch_array($object_mysql_result)) {
                return $object_row['cp_name'];
            }
        }
        
    }
    //////////////////////
    if ($object_type == "inspection") {
        if ($object_property == "name") {
            
            $object_mysql_result = mysql_query("SELECT * FROM inspections WHERE id='" . $object_id . "';");
            while ($object_row = mysql_fetch_array($object_mysql_result)) {
                return $object_row['inspection_name'];
            }
        }
        /////////
        if ($object_property == "type") {
            
            $object_mysql_result = mysql_query("SELECT * FROM inspections WHERE id='" . $object_id . "';");
            while ($object_row = mysql_fetch_array($object_mysql_result)) {
                if ($object_row['inspection_type'] == "1") {
                    return "podstawowa";
                }
                /////
                if ($object_row['inspection_type'] == "2") {
                    return "sprawdzająca";
                }
            }
        }
        ////////
                /////////
        if ($object_property == "type_BOOLEAN") {
            
            $object_mysql_result = mysql_query("SELECT * FROM inspections WHERE id='" . $object_id . "';");
            while ($object_row = mysql_fetch_array($object_mysql_result)) {
                if ($object_row['inspection_type'] == "1") {
                    return 1;
                }
                /////
                if ($object_row['inspection_type'] == "2") {
                    return 2;
                }
            }
        }
        ////////
         /////////
        if ($object_property == "state") {
            
            $object_mysql_result = mysql_query("SELECT * FROM inspections WHERE id='" . $object_id . "';");
            while ($object_row = mysql_fetch_array($object_mysql_result)) {
                if ($object_row['inspection_state'] == "1") {
                    return "<font color='green'>Aktywna</font>";
                }
                /////
                if ($object_row['inspection_state'] == "2") {
                    return "<font color='red'>Zakończona</font>";
                }
            }
        }
        ////////
        if ($object_property == "mode") {
            
            $object_mysql_result = mysql_query("SELECT * FROM inspections WHERE id='" . $object_id . "';");
            while ($object_row = mysql_fetch_array($object_mysql_result)) {
                if ($object_row['inspection_mode'] == "1") {
                    return "oznaczająca obiekty";
                }
                /////
                if ($object_row['inspection_mode'] == "2") {
                    return "oceniająca obiekty";
                }
            }
        }
        ////////
        if ($object_property == "mode_INT") {
            
            $object_mysql_result = mysql_query("SELECT * FROM inspections WHERE id='" . $object_id . "';");
            while ($object_row = mysql_fetch_array($object_mysql_result)) {
                if ($object_row['inspection_mode'] == "1") {
                    return 1;
                }
                /////
                if ($object_row['inspection_mode'] == "2") {
                    return 2;
                }
            }
        }
        
    }
    
}


////////////////////////////

function inspection_add($inspection_name, $inspection_description, $inspection_date, $inspection_type, $inspection_mode, $checking_for_inspection)
{
    
    /// inspection_mode - oznaczanie lub ocenianie wcześniej oznaczonych
    
    db_connect();
    $timestamp = time();
    mysql_query("INSERT INTO inspections ( inspection_name, inspection_description, inspection_date, inspection_type, inspection_mode, checking_for_inspection  )
                       VALUES
                       ( '" . $inspection_name . "', '" . $inspection_description . "', '" . $timestamp . "', '" . $inspection_type . "', '" . $inspection_mode . "', '" . $checking_for_inspection . "' );");
    
    return true;
    
}

///////////////////////////

function get_oddzial_from_pomieszczenie_id($pomieszczenie_id)
{
    db_connect();
    $pom_result = mysql_query("SELECT * FROM pomieszczenia WHERE id='" . $pomieszczenie_id . "';");
    while ($pom_row = mysql_fetch_array($pom_result)) {
           
           $r1 =  $pom_row['oddzial_id'];
           
            }
            return $r1;
}

///////////////////////////

function get_other_data_from_controlpoint_id()
{
    
    
}

/////////////////////////////

function already_voted($inspection_id, $cp_id)
{
    db_connect();
    $vote_result = mysql_query("SELECT * FROM inspections_data WHERE cp_id='" . $cp_id . "' AND inspection_id='" . $inspection_id . "';");
    if (mysql_num_rows($vote_result) == 1 || mysql_num_rows($vote_result) > 1) {
        return true;
    } else {
        return false;
    }
}

//////////////////////////////

function get_vote_state($inspection_id, $cp_id)
{
    db_connect();
    $vote_result = mysql_query("SELECT * FROM inspections_data WHERE cp_id='" . $cp_id . "' AND inspection_id='" . $inspection_id . "';");
    while ($vote_row = mysql_fetch_array($vote_result)) {
        return (int) $vote_row['state'];
    }
}

//////////////////////////////

function get_checking_from_voting_inspection ($voting_inspection) {
	
	 db_connect();
    $insp_result = mysql_query("SELECT * FROM inspections WHERE id='" . $voting_inspection . "';");
    while ($insp_row = mysql_fetch_array($insp_result)) {
        return  $insp_row['checking_for_inspection'];
    }
	
}

//////////////////////////////

function get_poprzednia_ocena_from_checking ($inspection_id, $cp_id) {
	
	 db_connect();
    $insp_result = mysql_query("SELECT * FROM inspections WHERE id='" . $inspection_id . "';");
    while ($insp_row = mysql_fetch_array($insp_result)) {
        $checking = $insp_row['checking_for_inspection'];
    }
    
     $checking_result = mysql_query("SELECT * FROM inspections_data WHERE cp_id='".$cp_id."' AND inspection_id='" . $checking . "';");
    while ($checking_row = mysql_fetch_array($checking_result)) {
        $answer = $checking_row['state'];
    }
    
    return (int)$answer;
	
}

//////////////////////////////

function print_controled_points_list($pomieszczenie_id, $table_mode, $delete_button, $inspection_mode_type, $inspection_id, $checking_inspection_id)
{
    
    $inspection_type_BOOL = get_object_data ("inspection", "type_BOOLEAN", $inspection_id);
    /// table_mode - tryb wyświetlania albo inspekcji 1 wyswietlanie 2 inspekcja
    /// oznaczanie lub ocenianie - $inspection_mode_type
    /// 1 - oznaczanie
    /// 2 - ocena
    //echo ($inspection_type_BOOL);
    echo ('     <table  class="table table-hover table-bordered">
    <thead style="background: #A2E7FA; ">
      <tr>
        <th>Lp.</th>
        <th>Nazwa punktu kontrolowanego</th>
        <th>Opis punktu kontrolowanego</th>

       ');
    
    
    if ($table_mode == 2) {
		
		
		 if ($inspection_type_BOOL == 2) {
			     echo (' 
        <th>Poprzednia ocena</th>');
        }
		 
		
		
        if ($inspection_mode_type == 1) {
            echo (' 
        <th>Oznaczanie</th>');
        }
        
        
        else {
            
            
            echo (' 
        <th style="width: 10%;">Ocena</th>');
        }
    }
    
        if ($delete == true) {
        echo (' 
        <th>Usuwanie</th>');
    }
    
    echo (' 
      
      </tr>
    </thead>
    <tbody>');
    
    $oddzialy = mysql_query("SELECT * FROM control_points WHERE pomieszczenie_id=" . $pomieszczenie_id . ";");
    $i        = null;
    while ($oddzialy_row = mysql_fetch_array($oddzialy)) {
        $checked = false;
        //echo (get_poprzednia_ocena_from_checking ($inspection_id, $oddzialy_row['id']));
        if ($table_mode == 2) // jeżli tryb wyświetlania inspekcji 
            {
            
            if (already_voted($checking_inspection_id, $oddzialy_row['id'])) {
                
                if (get_vote_state($checking_inspection_id, $oddzialy_row['id']) == 3) { /// 3 oznacza oznaczenie
                    $checked = true;
                   
                }
                
                
                
            }
            
              if ($inspection_type_BOOL == 2) {
				  if (get_poprzednia_ocena_from_checking ($inspection_id, $oddzialy_row['id']) == 0) {
					  $czy_wyswietlic = true;
					  $checked = true;
				  } else {
				      $czy_wyswietlic = false;
				      
			      }
			  } else {
                 $czy_wyswietlic = true;
			  }
            if ($checked == true AND $inspection_mode_type == 2 AND $czy_wyswietlic == true) // sprawdzamy czy oznaczono i  czy jest tryb oceniania
                {
				//	echo ("tst");
                $i++;
                echo (' <tr>');
                echo (' <td>' . $i . '</td>');
                echo (' <td>' . $oddzialy_row['cp_name'] . '</td>');
                echo (' <td>' . $oddzialy_row['cp_description'] . '</td>');
                
                
                
                if ($table_mode == 2) {
                    
                    $oddzial_id = get_oddzial_from_pomieszczenie_id($pomieszczenie_id);
                    
                    if ($inspection_mode_type == 1) {
                 
                   
                    
                        
                        if (already_voted($inspection_id, $oddzialy_row['id'])) {
                            
                            if (get_vote_state($inspection_id, $oddzialy_row['id']) == 3) { /// 3 oznacza oznaczenie
                                echo (' 
        <th><center><h4><b><font color="black">Oznaczono</font></b></h4></th></center>');
                            }
                            
                            
                            
                        } else {
                            
                            echo (' 
        <th>
        <a href="inspection_excuting.php?inspection_id=' . $inspection_id . '&inspection_mode=1&pomieszczenie_id=' . $pomieszczenie_id . '&answer=3&control_point_id=' . $oddzialy_row['id'] . '&oddzial_id=' . $oddzial_id . '">
        <button type="button" style="width: 100%; background: #C7960E; color: white;" class="btn btn-primary btn-sm">Oznacz</button></a></th>');
                        }
                        
                    }
                    
                    else {
						
						
                     ///////////jeżeli sprawdzająca poprzednią///////
                    
                     if ($inspection_type_BOOL == 2) {
			     echo (' 
                     <th><center><h4><font color="red">Źle</center></h4></font></th>');
            //echo ("dfgdg");
                      }
                    
                    ////////////////////////////////////////////////
                        
                        if (already_voted($inspection_id, $oddzialy_row['id'])) {
                            
                            if (get_vote_state($inspection_id, $oddzialy_row['id']) == 1) {
                                echo (' 
        <th><center><h4><b><font color="green">Dobrze</font></b></h4></center></th>');
                            } else {
                                echo (' 
        <th><center><h4><b><font color="red">Źle</font></b></h4></center></th>');
                            }
                            
                            
                        } else {
                            echo (' 
        <th><a href="inspection_excuting.php?checking_inspection_id=' . $checking_inspection_id . '&inspection_id=' . $inspection_id . '&inspection_mode=2&pomieszczenie_id=' . $pomieszczenie_id . '&answer=1&control_point_id=' . $oddzialy_row['id'] . '&oddzial_id=' . $oddzial_id . '"><button type="button" style="width: 100%; background: #54CF17; color: white;" class="btn btn-primary btn-sm">+</button></a>
        <br>
        <br>
        <a href="inspection_excuting.php?checking_inspection_id=' . $checking_inspection_id . '&inspection_id=' . $inspection_id . '&inspection_mode=2&pomieszczenie_id=' . $pomieszczenie_id . '&answer=0&control_point_id=' . $oddzialy_row['id'] . '&oddzial_id=' . $oddzial_id . '"><button type="button" style="width: 100%; background: #F22742; color: white;" class="btn btn-primary btn-sm">-</button></a>
        </th>');
                        }
                        
                    }
                }
                
                if ($delete == true) {
                    echo (' <td><a href="delete.php?type=oddzial&oddzial_id=' . $oddzialy_row['id'] . '"><button type="button" style="width: 100%;" class="btn btn-danger">Usuń</button></a></td>');
                }
                
                
                
                
                echo (' </tr>');
            } else {
                
                $tmp_var_1 == true;
            }
            
        } else {
            $tmp_var_1 == true;
            
        }
        
        if ($table_mode == 1 OR $inspection_mode_type == 1) // jeżli tryb oznaczania 
            {
            
            $i++;
            echo (' <tr>');
            echo (' <td>' . $i . '</td>');
            echo (' <td>' . $oddzialy_row['cp_name'] . '</td>');
            echo (' <td>' . $oddzialy_row['cp_description'] . '</td>');
            
            
            
            if ($table_mode == 2) {
                
                $oddzial_id = get_oddzial_from_pomieszczenie_id($pomieszczenie_id);
                
                if ($inspection_mode_type == 1) {
                    
                    
                    if (already_voted($inspection_id, $oddzialy_row['id'])) {
                        
                        if (get_vote_state($inspection_id, $oddzialy_row['id']) == 3) { /// 3 oznacza oznaczenie
                            echo (' 
        <th><center><h4><b><font color="black">Oznaczono</font></b></h4></th></center>');
                        }
                        
                        
                        
                    } else {
                        
                        echo (' 
        <th>
        <a href="inspection_excuting.php?inspection_id=' . $inspection_id . '&inspection_mode=1&pomieszczenie_id=' . $pomieszczenie_id . '&answer=3&control_point_id=' . $oddzialy_row['id'] . '&oddzial_id=' . $oddzial_id . '">
        <button type="button" style="width: 100%; background: #C7960E; color: white;" class="btn btn-primary btn-sm">Oznacz</button></a></th>');
                    }
                    
                }
                
                else {
                    
                    if (already_voted($inspection_id, $oddzialy_row['id'])) {
                        
                        if (get_vote_state($inspection_id, $oddzialy_row['id']) == 1) {
                            echo (' 
        <th><h3><b><font color="green">Dobrze</font></b></h3></th>');
                        } else {
                            echo (' 
        <th><h3><b><font color="red">Źle</font></b></h3></th>');
                        }
                        
                        
                    } else {
                        echo (' 
        <th><a href="inspection_excuting.php?inspection_id=' . $inspection_id . '&inspection_mode=2&pomieszczenie_id=' . $pomieszczenie_id . '&answer=1&control_point_id=' . $oddzialy_row['id'] . '&oddzial_id=' . $oddzial_id . '"><button type="button" style="width: 100%; background: #54CF17; color: white;" class="btn btn-primary btn-sm">+</button></a>
        <br>
        <br>
        <a href="inspection_excuting.php?inspection_id=' . $inspection_id . '&inspection_mode=2&pomieszczenie_id=' . $pomieszczenie_id . '&answer=0&control_point_id=' . $oddzialy_row['id'] . '&oddzial_id=' . $oddzial_id . '"><button type="button" style="width: 100%; background: #F22742; color: white;" class="btn btn-primary btn-sm">-</button></a>
        </th>');
                    }
                    
                }
            }
            
            if ($delete == true) {
                echo (' <td><a href="delete.php?type=oddzial&oddzial_id=' . $oddzialy_row['id'] . '"><button type="button" style="width: 100%;" class="btn btn-danger">Usuń</button></a></td>');
            }
            
            
            
            
            echo (' </tr>');
            
            
        }
        
    }
    echo ('    
    </tbody> </table> ');
    
    
}

//////////////////////////

function print_inspections_list () {
	
	 echo ('     <table  class="table table-hover table-bordered">
    <thead style="background: #A2E7FA; ">
      <tr>
        <th>Lp.</th>
        <th>Nazwa inspekcji</th>
        <th>Opis inspekcji</th>
        <th>Rodzaj inspekcji</th>
        <th>Tryb inspekcji</th>
        <th>Stan inspekcji</th>
        <th>Oceniająca/sprawdzająca inspekcję</th>
       ');

        echo (' 
        <th>Usuwanie</th>');
        
    
        echo (' 
        <th>Wybór</th>');
   
    
    echo (' 
      
      </tr>
    </thead>
    <tbody>');
    
    $oddzialy = mysql_query("SELECT * FROM inspections ;");
    $i        = null;
    while ($oddzialy_row = mysql_fetch_array($oddzialy)) {
        $i++;
        $inspection_type = get_object_data ("inspection", "type", $oddzialy_row['id']);
   		$inspection_mode = get_object_data ("inspection", "mode", $oddzialy_row['id']);
   		$inspection_state = get_object_data ("inspection", "state", $oddzialy_row['id']);
   		if ($oddzialy_row['checking_for_inspection'] != "") {
			$checking = $oddzialy_row['checking_for_inspection'];
		} else {
			$checking = "Nie dotyczy";
		}
        echo (' <tr>');
        echo (' <td>' . $i . '</td>');
        echo (' <td>' . $oddzialy_row['inspection_name'] . '</td>');
        echo (' <td>' . $oddzialy_row['inspection_description'] . '</td>');
        echo (' <td>' . $inspection_type . '</td>');
        echo (' <td>' . $inspection_mode . '</td>');
        echo (' <td>' . $inspection_state . '</td>');
        echo (' <td>' . $checking . '</td>');
        

            echo (' <td><a href="delete.php?type=inspection&oddzial_id=' . $oddzialy_row['id'] . '"><button type="button" style="width: 100%;" class="btn btn-danger">Usuń</button></a></td>');
      
      
            echo (' <td><a href="inspection_excuting.php?checking_inspection_id='.$oddzialy_row['checking_for_inspection'].'&inspection_id=' . $oddzialy_row['id'] . '"><button type="button" style="width: 100%;" class="btn btn-warning">Idź</button></a></td>');

        
        echo (' </tr>');
    }
    
    echo ('    
    </tbody> </table> ');
	
}

///////////////////////////

function print_combobox_inspections_list () {
	db_connect();

    
    $oddzialy = mysql_query("SELECT * FROM inspections WHERE `inspection_mode` = '1' OR `inspection_type` = '1';");
    $i        = null;
    while ($oddzialy_row = mysql_fetch_array($oddzialy)) {
        $i++;
  
      
        echo (' <option  value="'.$oddzialy_row['id'].'">' . $oddzialy_row['inspection_name'] . '</option>');
       
        

       
    }
    
    echo ('    
    </tbody> </table> ');
	
}


///////////////////////////

function  get_actual_year() {
	
	$actual_year = date ("Y");
	
	return $actual_year;
}

///////////////////////////

function print_years () {
	
	$actual_year = get_actual_year();
	$ile_lat = 5;
	$i = null;
	$year_T = $actual_year;
	while ($i != $ile_lat)
	{
		$i++;
		
     echo ("<option value='".$year_T."'>".$year_T."</option>");
     $year_T = $year_T - 1;
     }


}

///////////////////////////
?>
