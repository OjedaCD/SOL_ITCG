function ValidaNumeros() {
    if ((event.keyCode < 48) || (event.keyCode > 57)) 
     event.returnValue = false;
   }

 

var contador = false;
var punto = false;
var puntobandera = true;
var borrar = false;

//const nombre = document.getElementById("nombre");

function sololetras(e){ 
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key);
    letras = "qwertyuiopasdfghjklñzxcvbnmáéíóúQWERTYUIOPASDFGHJKLÑZXCVBNMÁÉÍÓÚ";
    especiales=['32','46','8'];
    teclado_especial = false;
    console.log("eeee");

    if (key == especiales[0]){
        teclado_especial = true;
        
    }
    if(key == especiales[1] && puntobandera == true && contador == true){
        puntobandera = false;
        return true;
    }

    if(key == especiales[1]  && contador == true){
        teclado_especial= true;
    }
    
    if(letras.indexOf(teclado) != -1 ){
        contador = true;
        return true;
    }else if(teclado_especial == true && contador == true){
        
            contador = false;
            return true;
        
    } else return false;
}


