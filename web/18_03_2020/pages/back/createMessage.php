<?php
session_start();
require('../functions.php');
$connect = connectDb();

if(count($_POST) == 3
    && !empty($_POST['to'])
    && !empty($_POST['title'])
    && !empty($_POST['message'])
   
){



	$to = trim($_POST['to']);
	$title = trim($_POST['title']);
	$message = trim($_POST['message']);


	$errors = [];



	if( !filter_var($to, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "L'email que vous avez indiqué n'est pas valide.";
    }else {

            $connect = connectDb();

            $req = $connect->prepare("SELECT mail,idPersonne FROM Personne WHERE mail = :mail");
            $req->execute([":mail" => $to]);

            $data = $req->fetchAll(PDO::FETCH_ASSOC);
           
            if (empty($data)) {
                
                $errors['email']= "L'email n'existe pas ";

            }else{

                $req = $connect->prepare("SELECT mail,idPersonne FROM Personne WHERE mail = :mail and statut = 2");
                $req->execute([":mail" => $to]);

                $array = $req->fetchAll(PDO::FETCH_ASSOC);
           
                    if (!empty($array)) {
                
                            $errors['email']= "L'email n'est pas associé à un compte client !";
                    }


            }
    }


    if (strlen($title) > 80) {
    	
    	$errors['title'] = " Titre trop long";
    }




    if (empty($errors)) {


    	$queryPrepared = $connect->prepare("INSERT INTO messagerie(statut,titre,texte,idSource,idDestinataire,statutSource,statutDestinataire) VALUES(1,:titre,:texte,:idSource,:idDestinataire,0,0)");



        $queryPrepared->execute([

            ":titre"=>$title, 
            ":texte"=>$message, 
            ":idSource"=>$_SESSION['id'], 
            ":idDestinataire"=>$data[0]['idPersonne']

        ]);

         $sendSuccess[] = "Message envoyé !";
         $_SESSION["sendSuccess"] = $sendSuccess;

        header("Location: messagesBack.php");

    	
    }else{


    	 $_SESSION["errorsMessage"] = $errors;
  		 header("Location: messagesBack.php");



    }



}