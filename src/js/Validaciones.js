function ValidaNumeros() {
    if ((event.keyCode < 48) || (event.keyCode > 57)) 
     event.returnValue = false;
   }


var espacios = 0;
var puntos = 0;

var nombre = document.getElementById("nombre").value;
var apellidoP = document.getElementById("apellidoP");

var tecladoAnterior ="";
function letrasEspaciosPuntos(e){ 
    
    
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key).toString();
    letras = "qwertyuiopasdfghjklñzxcvbnmáéíóúQWERTYUIOPASDFGHJKLÑZXCVBNMÁÉÍÓÚ";
    especiales=['46','8'];

    tecladoAnterior =tecladoAnterior+ " " + e.keyCode;
    if(espacios == 0){
        if(letras.indexOf(teclado) != -1 ){
            
            espacios ++;
            return true;
        }else return false;

    }else if(espacios == 1){
        
        if(letras.indexOf(teclado) != -1 ){
            return true;
        }else{ 
            var arregloTA = tecladoAnterior.split(" ");
            if(e.keyCode == 32 && arregloTA[arregloTA.length-2] == 32){
                return false;
            }
        }
    }
    
    
    // tecladoAnterior =tecladoAnterior+ " " + e.keyCode;
    // var arregloTA = tecladoAnterior.split(" ");
    // if(e.keyCode == 32 && arregloTA[arregloTA.length-2] == 32){
    //     return false;
    // }


}

function letrasYespacios(e){ 
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key).toString();
    letras = "qwertyuiopasdfghjklñzxcvbnmáéíóúQWERTYUIOPASDFGHJKLÑZXCVBNMÁÉÍÓÚ";
    especiales=['32','46','8','37','39'];
    tecladoEspecial = false;

    tecladoAnterior =tecladoAnterior+ " " + e.keyCode;
    var arregloTA = tecladoAnterior.split(" ");
     
    
    for(var i in especiales){
        if(key == especiales[i]){
            tecladoEspecial = true;
            break;
        }

    }
    
    if(apellidoP.value.length == 0){
        // console.log(apellidoP);
        espacios == 0;
        console.log(espacios);

    }
    

    if(espacios == 0){
        if(letras.indexOf(teclado) != -1 ){
            
            espacios = 1;
            return true;
        }else return false;

    }else if(espacios == 1){
                if(e.keyCode == 32 && arregloTA[arregloTA.length-2] == 32){
                    return false;
                }else
                if(letras.indexOf(teclado) != -1 || tecladoEspecial === true){
                    return true;
                }else return false;

            }           
}
espacios = 0;
function letrasYespaciosModificar(e){ 
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key).toString();
    letras = "qwertyuiopasdfghjklñzxcvbnmáéíóúQWERTYUIOPASDFGHJKLÑZXCVBNMÁÉÍÓÚ";
    especiales=['32','46','8','37','39'];
    tecladoEspecial = false;

    tecladoAnterior =tecladoAnterior+ " " + e.keyCode;
    var arregloTA = tecladoAnterior.split(" ");
   
    
    for(var i in especiales){
        if(key == especiales[i]){
            tecladoEspecial = true;
            break;
        }

    }
    
    // if(apellidoP.value.length == 0){
    //     // console.log(apellidoP);
    //     espacios == 0;
    //     console.log(espacios);

    // }
    

    if(espacios == 0){
        if(letras.indexOf(teclado) != -1 || tecladoEspecial === true  ){
            
            espacios = 1;
            return true;
        }else return false;

    }else if(espacios == 1){
                if(e.keyCode == 32 && arregloTA[arregloTA.length-2] == 32){
                    return false;
                }else
                if(letras.indexOf(teclado) != -1 || tecladoEspecial === true){
                    return true;
                }else return false;

            }   
}

function letrasNumeros(e){ 
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key).toString();
    letras = "qwertyuiopasdfghjklñzxcvbnmáéíóúQWERTYUIOPASDFGHJKLÑZXCVBNMÁÉÍÓÚ1234567890";


     if(letras.indexOf(teclado) != -1 ){
            return true;
        }else return false;

}