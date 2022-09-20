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

function fracaso(mensaje) {
    Swal.fire({
        position: 'center',
        icon: 'error',
        title: mensaje,
        showConfirmButton: false,
        timer: 2000
      })
}