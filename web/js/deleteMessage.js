
displayDeleteMessage();
function displayDeleteMessage(){

const req = new XMLHttpRequest();
req.onreadystatechange = function() {
   
   	if(req.readyState === 4) {
     		
    	let table = document.getElementById('tab');
    	table.innerHTML = req.responseText;

    }
}
req.open('GET', '../pages/displayDeleteMessage.php');
req.send();
}


var x = setInterval('displayDeleteMessage()',5000);




function deleteMessage(id){

const req = new XMLHttpRequest();
req.onreadystatechange = function() {
   
   	if(req.readyState === 4) {
     		

    	const del = document.getElementById(id);
        del.parentNode.removeChild(del);

    }
}
req.open('GET', '../pages/deleteMessage.php?id=' + id +'&action=d');
req.send();

}
