	<html>
<head>
  <title>Commedia Boccaccio</title>
  <meta charset="utf-8">
  
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.6/jqc-1.12.3/dt-1.10.12/b-1.2.1/b-colvis-1.2.1/b-print-1.2.1/r-2.1.0/datatables.min.css"/>
 
<script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.6/jqc-1.12.3/dt-1.10.12/b-1.2.1/b-colvis-1.2.1/b-print-1.2.1/r-2.1.0/datatables.min.js"></script>

<!-- inizializzare datatables -->
<script type="text/javascript">$(document).ready( function() {
    $('#results').dataTable(
    {"ordering":true,
    // così si possono ordinare le colonne
    "order": [[0, "asc"]],
    // initial order to apply to the table
    "paging":true,
    // con sto pezzetto paging c'è la possibilità di scegliere quanti record vedere in una pagina    
    });
    });
</script>
       


</head>
 <body>

 <div class="container-fluid">
 
 <div class="title">
 <div class="backhome">
	<a class="btn btn-default btn-lg" href="../index2.html" role="button">
		<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
		<span class="sr-only">Home:</span>
	</a>
	&emsp;<a href="../index2.html">Ricerca e pagina principale</a>
 </div>
</div>


  
    
<?php 

$change_cat=$_POST['change_cat'];
$rhyme=$_POST['rhyme'];
$tradizione=$_POST['tradizione'];
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


$con = mysqli_connect("localhost", "u300618614_user", "XWAJJXej9C", "u300618614_db") or die("Failed to connect to MySql.");

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


if ($tradizione != '') {
	$query_tradizione = "AND presenteTradizione.id = " . $tradizione . "";
} else {
	$query_tradizione = "";
}


/*  per il momento lo togliamo
if ($source != '') {
	$query_source = "AND (ar.Source_id != 1 OR br.Source_id != 1 OR cr.Source_id != 1)";
} else {
	$query_source = "";
}
*/


if ($from_cantica != '') {
	$query_from_cantica = "AND versi.cantica >= " . $from_cantica . "";
} else {
	$query_from_cantica = "";
}
if ($from_canto != '') {
	$query_from_canto = "AND versi.canto >= " . $from_canto . "";
} else {
	$query_from_canto = "";
}
if ($from_verso != '') {
	$query_from_verso = "AND versi.verso >= " . $from_verso . "";
} else {
	$query_from_verso = "";
}


if ($to_cantica != '') {
	$query_to_cantica = "AND versi.cantica <= " . $to_cantica . "";
} else {
	$query_to_cantica = "";
} 
if ($to_canto != '') {
	$query_to_canto = "AND versi.canto <= " . $to_canto . "";
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
$user_query = "SELECT DISTINCT cantica.cantica, canto.canto, versi.verso, la.lezione AS lezionea, lb.lezione AS lezioneb, lc.lezione AS lezionec, lp.lezione AS lezionep, categoriaCambiamento.categoria, rima.rima, presenteTradizione.presente, annotazioni.commento 
FROM testimoni ta, lezioni la, testimoni tb, lezioni lb, testimoni tc, lezioni lc, testimoni tp, lezioni lp, annotazioni
INNER JOIN versi
ON annotazioni.versi_id = versi.id
INNER JOIN cantica
ON versi.cantica_id = cantica.id
INNER JOIN canto
ON versi.canto_id = canto.id
INNER JOIN categoriaCambiamento
ON annotazioni.categoriaCambiamento_id = categoriaCambiamento.id
INNER JOIN rima
ON annotazioni.rima_id = rima.id
INNER JOIN presenteTradizione
ON annotazioni.presenteTradizione_id = presenteTradizione.id
WHERE ta.id=1 AND tb.id=2 AND tc.id=3 AND tp.id=4 AND la.testimoni_id=ta.id AND lb.testimoni_id=tb.id AND lc.testimoni_id=tc.id AND lp.testimoni_id=tp.id AND annotazioni.versi_id=la.versi_id AND annotazioni.versi_id=lb.versi_id AND annotazioni.versi_id=lc.versi_id AND annotazioni.versi_id=lp.versi_id ".$query_change_cat." ".$query_rhyme." ".$query_tradizione." ".$query_from_cantica." ".$query_from_canto." ".$query_from_verso." ".$query_to_cantica." ".$query_to_canto." ".$query_to_verso." ".$query_witcomb."";
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


echo "<table id='results' class='hover cell-border'>";

echo "<thead><tr><th></th><th></th><th></th><th>Toledano</th><th>Riccardiano</th><th>Chigiano</th><th>Tipo di variante</th><th>In rima</th><th>Presente nella tradizione</th><th>Ed. Petrocchi</th><th>Nota</th></tr></thead><tbody>";

while ($row=mysqli_fetch_array($query))

{

// $sequence=$row['Sequence_id'];

$commento = $row['commento'];
$myvar = "<button>Nota</button><div class='commento'>" . $commento . "</div>";


	
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
echo"<td><strong>";
echo $row['lezionea'];
echo"</strong></td>";
echo"<td><strong>";
echo $row['lezioneb'];
echo"</strong></td>";
echo"<td><strong>";
echo $row['lezionec'];
echo"</strong></td>";
echo"<td>";
echo $row['categoria'];
echo"</td>";
echo"<td>";
echo $row['rima'];
echo"</td>";
echo"<td>";
echo $row['presente'];
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