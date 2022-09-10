let archivo = document.querySelector('#importA');
	archivo.addEventListener('change', () => {
	document.querySelector('#nombre').innerText =
	archivo.files[0].name;});

function mostrarContenido(){
	document.getElementById('todas').style.display ='flex';
	document.getElementById('especifica').style.display ='none';
}

function mostrarContenido2(){
	document.getElementById('especifica').style.display ='flex';
	document.getElementById('todas').style.display ='none';
}

