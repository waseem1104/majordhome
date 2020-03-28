<?php
session_start();
require('functions.php');

$connect = connectDb();

$queryPrepared = $connect->prepare('SELECT m.idMessage,m.titre,m.texte,m.dateEnvoie,p.nom FROM Messagerie m INNER JOIN Personne p ON p.idPersonne = m.idDestinataire INNER JOIN Personne p1 ON p1.idPersonne = m.idSource WHERE p1.statut = 2 AND m.statutSource = 2 ORDER BY m.dateEnvoie desc;');
 $queryPrepared->execute();
 $array = $queryPrepared->fetchAll();


$queryPrepared = $connect->prepare('SELECT m.idMessage,m.titre,m.texte,m.dateEnvoie,p.nom FROM Messagerie m INNER JOIN Personne p1 ON p1.idPersonne = m.idDestinataire INNER JOIN Personne p ON p.idPersonne = m.idSource WHERE p1.statut = 2 AND m.statutSource = 2 ORDER BY m.dateEnvoie desc;');
$queryPrepared->execute();


$array = array_merge($array,$queryPrepared->fetchAll());

echo "<table class='table table-inbox table-hover'>";

  echo "<tbody>";     
  
  	foreach ($array as $value) {

    $date = $value['dateEnvoie'];
    $dateToday = date('d/m/Y');
    $phpdate = strtotime( $date );
    $date = date( 'd/m/Y H:i', $phpdate );

    $dateExplode = explode(' ', $date);



   
		echo "<tr class='unread' id='".$value['idMessage']."'>";

    echo "<td> ";
       echo "<input type='checkbox' class='check' class='mail-checkbox'>";
    echo "</td>";
      
      echo "<td>".$value['nom']."</td>";
      echo "<td><p class='view-message'>".$value['texte']."</p></td>";
      echo "<td class='text-right'>
      <i onclick='deleteMessage(".$value['idMessage'].")' class=' fas fa-trash'></i>

    
      </td>";

      if ( $dateToday === $dateExplode[0]) {
        echo "<td class='text-right'>".$dateExplode[1]."</td>";
      }else{

         echo "<td class='text-right'>".$dateExplode[0]."</td>";
      }
     
      echo "<td class='text-right'><i onclick='viewMessage(".$value['idMessage'].")' class='fas fa-envelope'></i></td>";

    echo "</tr>";
  
 


  }



 echo "</tbody>";
echo "</table>";