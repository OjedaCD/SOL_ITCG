var eye = document.getElementById('ojo');
var input = document.getElementById('password');
eye.addEventListener("click", function(){
    if (input.type === "password") {
        input.type = "text";
        eye.style.opacity = 0.8;
    } else {
        input.type = "password";
        eye.style.opacity = 0.2;
    }
})
function exito(mensaje) {
    Swal.fire({
        position: 'center',
        icon: 'success',
        title: mensaje,
        showConfirmButton: false,
        timer: 2000
      })
}
function borrarDatos (formulario){
    const result = Swal.fire({
        title: '¿Está seguro de Eliminar?',
        text: "Se Eliminarán todas las solicitudes",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: 'Si Eliminar'
    }).then((result) => {
        if(result.isConfirmed){
            const form = document.querySelector(formulario);
            console.log(form);
            form.submit();
        }});
}
function fracaso(mensaje) {
    Swal.fire({
        position: 'center',
        icon: 'error',
        title: mensaje,
        showConfirmButton: false,
        timer: 2000
      })
}

function advertencia(mensaje) {
    Swal.fire({
        position: 'center',
        icon: 'warning',
        title: mensaje,
        showConfirmButton: false,
        timer: 2000
      })
}

function mostrarContenido(){
    document.getElementById('content2').style.display ='none';
    document.getElementById('general').style.display ='none';    
	document.getElementById('content1').style.display ='flex';
}

function mostrarContenido2(){
    document.getElementById('content1').style.display ='none';
    document.getElementById('general').style.display ='none';    
	document.getElementById('content2').style.display ='flex';
}
function mostrarContenido3(){
    document.getElementById('content2').style.display ='none';
	document.getElementById('content1').style.display ='none';  
    document.getElementById('general').style.display ='flex';    
}