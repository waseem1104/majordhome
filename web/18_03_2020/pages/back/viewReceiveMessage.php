<?php
require('../functions.php');

if (isset($_GET['id'])) {
	
	$connect = connectDb();


	$query = $connect->prepare('UPDATE Messagerie SET statut = 0 WHERE idMessagerie = ?');
	$query->execute([$_GET['id']]);

	$query = $connect->prepare('SELECT m.idMessagerie,m.serviceMessagerie,m.titre,m.texte,m.dateEnvoie,p.mail,p.nom FROM messagerie m INNER JOIN Personne p ON p.idPersonne = m.idSource WHERE idMessagerie = ?');
 	
 	$query->execute([$_GET['id']]);


 	$data = $query->fetch(PDO::FETCH_ASSOC);




    $date = $data['dateEnvoie'];
    $phpdate = strtotime( $date );
    $date = date( 'd/m/Y H:i', $phpdate );
    $dateExplode = explode(' ', $date);

?>
	

	<div class="p-2 viewMessage">

	<button onclick="window.location.reload()" class="btn btn-primary m-2">Retour <i class="fas fa-arrow-circle-left"></i></button>
	<button id="btnReply" onclick="displayReply();" class="btn btn-primary m-2">Répondre</button>


	<div id="reply" hidden="true">



		<p class='contains'>De :  Centre de messagerie majord'home. </p>
		<p class='contains'>À : <span id='to'><?php echo $data['mail']; ?></span> </p>

		<h5 id='titleMess' class="titleMessage"> Re : <?php echo $data['titre'];?></h5>



	    <div class="form-group">
            <textarea class="form-control" id="mess" rows="5" cols="30" required="required"></textarea>
        </div>

 
        <button onclick ='replyMessage()' class="btn btn-primary">Envoyez <i class="fas fa-paper-plane"></i></button>

        <hr>
     </div>                   

	<h5 class="titleMessage"> Objet : <?php echo $data['titre'];?></h5>

	<p class='contains'><?php echo $data['nom'] . ". < " . $data['mail'] . " >" . "<br>" . $dateExplode[0] . " " . $dateExplode[1]; ?> </p>
	
	<p class="contains" "> À : Centre de messagerie majord'home.</p>
	<hr>
	<p class="contains"> <?php echo $data['texte']; ?></p>

		
	</div>

<?php

}