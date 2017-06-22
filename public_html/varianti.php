  <html>
<head>
  <title>Commedia Boccaccio</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  
  <link href="http://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
      <link rel="stylesheet" href="test.css">
    <link rel="stylesheet" href="queries.css">

  <script src="jquery-datatables/jquery.js"></script>
  <script src="jquery-datatables/jquery.dataTables.js"></script>
  
<!-- Per far funzionare tables, attenzione a class e id su table (id deve corrispondere alla variabile
 nello script qui sotto, la class copia semplicemente) e alla presenza di thead e tbody -->   
    
<script type="text/javascript">$(document).ready( function() {
    $('#results').dataTable(
    {"ordering":true,
    // così si possono ordinare le colonne
    "order": [],
    // initial order to apply to the table
    "paging":true,
    // con sto pezzetto paging c'è la possibilità di scegliere quanti record vedere in una pagina
    
    });
    });
    </script>
  
  <script>
$(document).ready(function(){
    $("button").click(function(){
        $(".commento").toggle();
    });
});
</script>    
  
 
        


</head>
 <body>
 <div class="container-fluid">
 
 <div class="title">
 <div class="backhome">
  <a class="btn btn-default btn-lg" href="index.html" role="button">
    <span class="glyphicon glyphicon-home" aria-hidden="true"></span>
    <span class="sr-only">Home:</span>
  </a>
  &emsp;<a href="index.html">Ricerca e pagina principale</a>
 </div>
</div>


  
    
<?php 

$change_cat=$_POST['change_cat'];
$rhyme=$_POST['rhyme'];
$tradizione=$_POST['tradizione'];
// $eco=$_POST['eco'];
// $source=$_POST['source']; per il momento lo togliamo
$from_cantica=$_POST['from_cantica'];
$from_canto=$_POST['from_canto'];
$from_verso=$_POST['from_verso'];
$to_cantica=$_POST['to_cantica'];
$to_canto=$_POST['to_canto'];
$to_verso=$_POST['to_verso'];
// $wit1 = $_POST['wit1'];
// $wit2 = $_POST['wit2'];
$witcomb=$_POST['witcomb'];


require 'connexion.php';

// $con = mysqli_connect("localhost", "u300618614_user", "XWAJJXej9C", "u300618614_db") or die("Failed to connect to MySql.");

// $where = array(); $where est un array, c'est-à-dire un tableau où on insère des données à fur et à mesure
//Données insérées dans $where :
 
 
if ($change_cat != '') {
  $query_change_cat = "AND categoriaCambiamento.id = " . $change_cat . "";
} else {
  $query_change_cat = "";
}

if ($rhyme != '') {
  $query_rhyme = "AND rima.id = " . $rhyme . "";
} else {
  $query_rhyme = "";
}


/*if ($tradizione != '') {
  $query_tradizione = "AND (la.presenteTradizione_id = " . $tradizione . " OR lb.presenteTradizione_id = " . $tradizione . " OR lc.presenteTradizione_id = " . $tradizione . ")";
} else {
  $query_tradizione = "";
}*/

if ($tradizione != '') {
  if ($tradizione > 1) {
    $query_tradizione = "AND (la.presenteTradizione_id = " . $tradizione . " OR lb.presenteTradizione_id = " . $tradizione . " OR lc.presenteTradizione_id = " . $tradizione . ")";
  } else {
    $query_tradizione = "AND la.presenteTradizione_id=1 AND lb.presenteTradizione_id=1 AND lc.presenteTradizione_id=1";
  }
  
} else {
  $query_tradizione = "";
}


/*
if ($eco != '') {
  if ($eco < 2) {
    $query_eco = "AND (la.eco_id = " . $eco . " OR lb.eco_id = " . $eco . " OR lc.eco_id = " . $eco . ")";
  } else {
    $query_eco = "AND la.eco_id=2 AND lb.eco_id=2 AND lc.eco_id=2";
  }
  
} else {
  $query_eco = "";
}
*/



/*  per il momento lo togliamo
if ($source != '') {
  $query_source = "AND (ar.Source_id != 1 OR br.Source_id != 1 OR cr.Source_id != 1)";
} else {
  $query_source = "";
}
*/


if ($from_cantica != '') {
  $query_from_cantica = "AND versi.cantica_id >= " . $from_cantica . "";
} else {
  $query_from_cantica = "";
}
if ($from_canto != '') {
  $query_from_canto = "AND versi.canto_numero >= " . $from_canto . "";
} else {
  $query_from_canto = "";
}
if ($from_verso != '') {
  $query_from_verso = "AND versi.verso >= " . $from_verso . "";
} else {
  $query_from_verso = "";
}


if ($to_cantica != '') {
  $query_to_cantica = "AND versi.cantica_id <= " . $to_cantica . "";
} else {
  $query_to_cantica = "";
} 
if ($to_canto != '') {
  $query_to_canto = "AND versi.canto_numero <= " . $to_canto . "";
} else {
  $query_to_canto = "";
}
if ($to_verso != '') {
  $query_to_verso = "AND versi.verso <= " . $to_verso . "";
} else {
  $query_to_verso = "";
}


if ($witcomb != '') {
  $query_witcomb = "AND annotazioni.combinazioni_id = " . $witcomb . "";
} else {
  $query_witcomb = "";
}



/*  Questo è il codice copiato sotto, un po' cambiato in modo che somigli a quelli sopra.
Ma in realtà sti cavoli.
Questo va messo in una variabile e poi if wit1=A,B and wit2=B,C -> witnesscombination = 4
etc
poi mettere witnesscombination nella query

if ($wit1 != '') {
  $N = count($wit1);
     for($i=0; $i < $N; $i++)
    {
      echo($wit1[$i] . " ");
    }
} else {
  $wit1 = "";
}

if ($wit2 != '') {
  $N = count($wit2);
     for($i=0; $i < $N; $i++)
    {
      echo($wit2[$i] . " ");
    }
} else {
  $wit2 = "";
}
*/

/*  Questo è il codice che ho copiato per tirare fuori i valori della checkbox
if (empty($wit1)) {
    echo("You didn't select any buildings.");
} else  {
    $N = count($wit1);
     for($i=0; $i < $N; $i++)
    {
      echo($wit1[$i] . " ");
    }
  }
 */



// Data ricevuti dal form in variabili
$user_query=$_POST['user_query'];

// La funzione trim() permerte di sopprimere spazi prima e dopo (migliora l'interrogazione nel formulario)

// Pour que le vide dans le formulaire soit considéré comme un "any" (afficher tout) et non comme un "none" il faut inclure un if qui transforme le vide "" en "%" or whatever u want

if($user_query=='')
{
$user_query = "SELECT DISTINCT cantica.cantica, canto.canto, versi.verso, la.lezione AS lezionea, la.presenteTradizione_id AS presentea, lb.lezione AS lezioneb, lb.presenteTradizione_id AS presenteb, lc.lezione AS lezionec, lc.presenteTradizione_id AS presentec, lp.lezione AS lezionep, categoriaCambiamento.categoria, rima.rima, annotazioni.commento 
FROM testimoni ta, lezioni la, testimoni tb, lezioni lb, testimoni tc, lezioni lc, testimoni tp, lezioni lp, annotazioni
INNER JOIN versi
ON annotazioni.versi_id = versi.id
INNER JOIN cantica
ON versi.cantica_id = cantica.id
INNER JOIN canto
ON versi.canto_numero = canto.numero
INNER JOIN categoriaCambiamento
ON annotazioni.categoriaCambiamento_id = categoriaCambiamento.id
INNER JOIN rima
ON annotazioni.rima_id = rima.id
WHERE ta.id=1 AND tb.id=2 AND tc.id=3 AND tp.id=4 AND la.testimoni_id=ta.id AND lb.testimoni_id=tb.id AND lc.testimoni_id=tc.id AND lp.testimoni_id=tp.id AND annotazioni.versi_id=la.versi_id AND annotazioni.versi_id=lb.versi_id AND annotazioni.versi_id=lc.versi_id AND annotazioni.versi_id=lp.versi_id
 ".$query_change_cat." ".$query_rhyme." ".$query_tradizione." ".$query_from_cantica." ".$query_from_canto." ".$query_from_verso." ".$query_to_cantica." ".$query_to_canto." ".$query_to_verso." ".$query_witcomb."
ORDER BY cantica.id, canto.id, versi.verso";
}

// per controllare la query         echo "$user_query";

// Envoi de la requete SQL proprement dite

$query=mysqli_query($con, "$user_query") or die ("impossible to select data"); 


// Affichage des donnÃ©es

// la fonction mysql_num_rows() indique le nombre des rÃ©ponses Ã  une requete

$num_rows = mysqli_num_rows($query);

echo"<br/>";
echo"<h4 class='risultati'>";
echo"Risultati: ";
echo $num_rows;
echo"</h4>";
echo"In ";
echo"<span style='background-color:LightBlue'>";
echo"azzurro";
echo"</span>";
echo" le lezioni assenti nella tradizione precedente a Boccaccio.";

/*
echo"<br/>";
echo"<u>";
echo"Sottolineate";
echo"</u>";
echo" le lezioni che riprendono o anticipano un altro verso (eco o anticipazione).";
echo"<br/><br/><br/>";
*/


echo "<table id='results' class='hover cell-border'>";

echo "<thead><tr><th></th><th></th><th></th><th>Toledano</th><th>Riccardiano</th><th>Chigiano</th><th>Tipo di variante</th><th>In rima</th><th>Ed. Petrocchi</th><th></th></tr></thead><tbody>";

while ($row=mysqli_fetch_array($query))

{

// $sequence=$row['Sequence_id'];

$commento = $row['commento'];
$myvar = "<button>Nota</button><div class='commento'>" . $commento . "</div>";


// ".($row['ecoa'] == '1' ? "<u>" : "")."
  
echo"<tr>";
echo"<td>";
echo $row['cantica'];
echo"</td>";
echo"<td>";
echo $row['canto'];
echo"</td>";
echo"<td>";
echo $row['verso'];
echo"</td>";
echo "<td ".($row['presentea'] == '2' ? "style='background-color:LightBlue'" : "")." ><strong>";
echo $row['lezionea'];
echo"</strong></td>";
echo "<td ".($row['presenteb'] == '2' ? "style='background-color:LightBlue'" : "")." ><strong>";
echo $row['lezioneb'];
echo"</strong></td>";
echo "<td ".($row['presentec'] == '2' ? "style='background-color:LightBlue'" : "")." ><strong>";
echo $row['lezionec'];
echo"</strong></td>";
echo"<td>";
echo $row['categoria'];
echo"</td>";
echo"<td>";
echo $row['rima'];
echo"</td>";
echo"<td>";
echo $row['lezionep'];
echo"</td>";
echo"<td>";
if (!empty($commento)) {
  echo $myvar;
/*
  echo $row['commento'];
  echo"</div>";
*/
} else { echo "";}

echo"</td>";
echo"</tr>";
};

echo"</tbody></table>";

echo "<br/>";

// Bonne pratique: fermer la connexion
// mysql_close($con);
?>
 

</div> 
</body>
</html>