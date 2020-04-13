<?php

require('functions.php');
$connect = connectDb();

$idCustomer = $_POST['idCustomer'];
$idProvider = $_POST['idProvider'];
$idSouscriptionService = $_POST['idSouscriptionService'];


$req = $connect->prepare("UPDATE souscription_service set FK_idPrestataire =:FK_idPrestataire WHERE idSouscriptionService =:idSouscriptionService AND FK_idPersonne =:FK_idPersonne;");
$req->execute([':FK_idPrestataire' => $idProvider,
    ':idSouscriptionService'=> $idSouscriptionService,
    ':FK_idPersonne' => $idCustomer
]);

?>