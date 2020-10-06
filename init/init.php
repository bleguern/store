<?php 
// Init file //
$root = dirname(__FILE__)."/../";
include_once($root.'./config/config_specific.php');

$bdd = mysqli_connect(DATABASE_HOST, DATABASE_USERNAME, DATABASE_PASSWORD, DATABASE_NAME);

$requetes = ''; 
$sql_file = file('init.sql');

echo 'Chargement initial de la base...<BR>';

foreach($sql_file as $line) { // on le lit
	if (substr(trim($line), 0, 2) != "--"){
		$line = str_replace('#DATABASE_PREFIX#', DATABASE_PREFIX, $line);
		$requetes .= $line;
	}
}

$reqs = explode(";", $requetes);

foreach($reqs as $req){
	echo $req.'<BR>';
	if (!mysqli_query($req, $bdd) && (trim($req) != "")) {
		echo('Requête invalide : ' . mysqli_error ());
	}
}

unlink('init.sql');
unlink('init.php');
rmdir('../init/');

echo 'OK<BR><BR><a href="../index.php">Aller sur la page d\'accueil...</A>';

// End of init file //
?>