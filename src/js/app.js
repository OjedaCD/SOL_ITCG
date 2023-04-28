// Espera a que se cargue el DOM antes de ejecutar el código JavaScript
document.addEventListener('DOMContentLoaded', () => {
    let eye = document.getElementById('ojo');
    let input = document.getElementById('password');
  
    // Verifica si los elementos existen antes de añadir el evento
    if (eye && input) {
      eye.addEventListener('click', () => {
        if (input.type === "password") {
          input.type = "text"; // Corrige el error: se usa = en lugar de ===
          eye.style.opacity = 0.8;
        } else {
          input.type = "password"; // Corrige el error: se usa = en lugar de ===
          eye.style.opacity = 0.2;
        }
      });
    }
  });
  

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
function nuevaContraseña (formulario, user, correo){
    const resulta = Swal.fire({
        title: '¿Cambiar contraseña de ' + user + '?',
        text: "La contraseña se cambiará y enviará al correo " + correo,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: 'Si Eliminar'
    }).then((resulta) => {
        if(resulta.isConfirmed){
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

function mostrarContenido4(){
    document.getElementById('modificar').style.display ='none'; 
    document.getElementById('cancelar').style.display ='flex';    
}
function mostrarContenido5(){
    document.getElementById('cancelar').style.display ='none';    
    document.getElementById('modificar').style.display ='flex'; 
}

function mostrarContenido6(){
    document.getElementById('grafico').style.display ='none';    
    document.getElementById('porDpto1').style.display ='flex';
}
function mostrarContenido7(){
    document.getElementById('grafico').style.display ='flex';    
    document.getElementById('porDpto1').style.display ='none';
}
