<?php
// A la création du login, le nom d'utilisateur ne doit pas exister. 
// Vérifier son absence en BDD avant l'insert
function get_ExistPseudo($ba_bec_pseudoMemb){
	global $DB;

    //connect to database
    if(!$DB){
        sql_connect();
    }

	$query = 'SELECT * FROM MEMBRE WHERE pseudoMemb = ?;';
	$ba_bec_result = $DB->prepare($query);
	$ba_bec_result->execute(array($ba_bec_pseudoMemb));
	return($ba_bec_result->rowCount());
}
?>
