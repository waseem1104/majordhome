<?php
session_start ();

if (!isset($_SESSION['user']) || $_SESSION['user']['statut'] != 2) {
    header('Location: ../login.php');
}

require("../functions.php");
$connect = connectDb();

if(!empty($_POST['id'])) {

    $id = $_POST['id'];
    $req = $connect->prepare("UPDATE subscription set statut =:status WHERE id =:id;");
    $req->execute([
        ':status'=>-1,
        ':id'=>$id
    ]);

}



?>