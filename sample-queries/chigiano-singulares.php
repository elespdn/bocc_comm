<html>
<head>
  <title>Commedia Boccaccio</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
  
  <link href="http://cdn.datatables.net/1.10.11/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="../test.css">
		<link rel="stylesheet" href="queries.css">

	<script src="../jquery-datatables/jquery.js"></script>
	<script src="../jquery-datatables/jquery.dataTables.js"></script>
  
<!-- Per far funzionare tables, attenzione a class e id su table (id deve corrispondere alla variabile
 nello script qui sotto, la class copia semplicemente) e alla presenza di thead e tbody -->   
		
<script type="text/javascript">$(document).ready( function() {
    $('#results').dataTable(
    {"ordering":true,
    // così si possono ordinare le colonne
    "order": [],
    // initial order to apply to the table
    "paging":true,
    // con sto pezzetto paging c'è o NON c'è la possibilità di scegliere quanti record vedere in una pagina
    
    });
    });
    </script>
        
        
        


</head>
 <body>
 
 <div class="container-fluid">
 
 <div class="title">
 <div class="backhome">
	<a class="btn btn-default btn-lg" href="../index.html" role="button">
		<span class="glyphicon glyphicon-home" aria-hidden="true"></span>
		<span class="sr-only">Home:</span>
	</a>
	&emsp;<a href="../index.html">Ricerca e pagina principale</a>
 </div>
</div>

    
    
<?php 
$con = mysqli_connect("localhost", "u300618614_user", "XWAJJXej9C", "u300618614_db") or die("Failed to connect to MySql.");

// Data ricevuti dal form in variabili
$user_query=$_POST['user_query'];

// La funzione trim() permerte di sopprimere spazi prima e dopo (migliora l'interrogazione nel formulario)

// Pour que le vide dans le formulaire soit considÃ©rÃ© comme un "any" (afficher tout) et non comme un "none" il faut inclure un if qui transforme le vide "" en "%" or whatever u want

if($user_query=='')
{
$user_query = "SELECT DISTINCT cantica.cantica, canto.canto, versi.verso, la.lezione AS lezionea, lb.lezione AS lezioneb, lc.lezione AS lezionec, lp.lezione AS lezionep
FROM testimoni ta, lezioni la, testimoni tb, lezioni lb, testimoni tc, lezioni lc, testimoni tp, lezioni lp, annotazioni
INNER JOIN versi
ON annotazioni.versi_id = versi.id
INNER JOIN cantica
ON versi.cantica_id = cantica.id
INNER JOIN canto
ON versi.canto_id = canto.id
WHERE ta.id=1 AND tb.id=2 AND tc.id=3 AND tp.id=4 AND la.testimoni_id=ta.id AND lb.testimoni_id=tb.id AND lc.testimoni_id=tc.id AND lp.testimoni_id=tp.id AND annotazioni.versi_id=la.versi_id AND annotazioni.versi_id=lb.versi_id AND annotazioni.versi_id=lc.versi_id AND annotazioni.versi_id=lp.versi_id AND (annotazioni.combinazioni_id=3 OR annotazioni.combinazioni_id=4)
ORDER BY cantica.id, canto.id, versi.verso";
}

// per controllare la query      echo "$user_query";

// Envoi de la requete SQL proprement dite

$query=mysqli_query($con, "$user_query") or die ("impossible to select data"); 


// Affichage des donnÃ©es

echo "<h2>Lezioni individuali del codice Chigiano</h2>";

// la fonction mysql_num_rows() indique le nombre des rÃ©ponses Ã  une requete

$num_rows = mysqli_num_rows($query);

echo"<br/>";
echo"<h4 class='risultati'>";
echo"Risultati: ";
echo $num_rows;
echo"</h4>";


echo "<table id='results' class='hover cell-border'>";

echo "<thead><tr><th></th><th></th><th></th><th>Toledano</th><th>Riccardiano</th><th>Chigiano</th><th>Ed. Petrocchi</th></tr></thead><tbody>";

while ($row=mysqli_fetch_array($query))

{

// $sequence=$row['Sequence_id'];

	
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
echo"<td>";
echo $row['lezionea'];
echo"</td>";
echo"<td>";
echo $row['lezioneb'];
echo"</td>";
echo"<td>";
echo $row['lezionec'];
echo"</td>";
echo"<td>";
echo $row['lezionep'];
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