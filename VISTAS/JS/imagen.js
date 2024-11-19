document.addEventListener("DOMContentLoaded", () => {

    document.getElementById("desc").onkeyup = e =>
        revisarControl(e, 1, 10);


    document.getElementById("file").addEventListener("change", e => {
        const maxSizeInBytes = 5 * 1024 * 1024; 
        
        const fileInput = e.target;
        const errorMessage = document.getElementById('errorMessage');

      
        errorMessage.textContent = '';

        
        if (fileInput.files.length === 0) {
            errorMessage.textContent = 'Por favor, seleccione un archivo.';
            fileInput.classList.add("novalido");
        } else {
            fileInput.classList.remove("novalido");
            fileInput.classList.add("valido");
        }

        const file = fileInput.files[0];
        if (file.size > maxSizeInBytes) {
            errorMessage.textContent = 'El archivo es demasiado grande. El tamaño máximo permitido es 5 MB.';
            fileInput.classList.add("novalido");
            e.preventDefault(); 
        } else {
            fileInput.classList.remove("novalido");
            fileInput.classList.add("valido");
        }
    });
    

    document.getElementById("btnSubir").addEventListener("click", e => {
        const fileInput = document.getElementById('file');
        const descInput = document.getElementById('desc'); 
        const errorMessage = document.getElementById('errorMessage');
        const errorMessage2 = document.getElementById('errorMessage2');
        const maxSizeInBytes = 5 * 1024 * 1024; 

        
        errorMessage.textContent = '';
        errorMessage2.textContent = '';

       
        if (descInput.value.trim().length < 1 ||
        descInput.value.trim().length > 10) {
            errorMessage2.textContent = 'La descripción debe tener entre 1 y 10 caracteres.';
            descInput.classList.add("novalido");
            e.preventDefault(); 
        } else {
            descInput.classList.remove("novalido");
            descInput.classList.add("valido");
        }
        
        if (fileInput.files.length === 0) {
            errorMessage.textContent = 'Por favor, seleccione un archivo.';
            fileInput.classList.add("novalido");
            e.preventDefault(); 
           
        } else {
            fileInput.classList.remove("novalido");
            fileInput.classList.add("valido");
        }

        
        const file = fileInput.files[0];
        if (file.size > maxSizeInBytes) {
            errorMessage.textContent = 'El archivo es demasiado grande. El tamaño máximo permitido es 5 MB.';
            fileInput.classList.add("novalido");
            e.preventDefault(); 
            
        } else {
            fileInput.classList.remove("novalido");
            fileInput.classList.add("valido");
        }

        
    });

    function revisarControl(e, min, max) {
        if (e.code == 'Tab') return;
        let txt = e.target;
        txt.setCustomValidity("");
        txt.classList.remove("valido");
        txt.classList.remove("novalido");
        if (txt.value.trim().length < min ||
            txt.value.trim().length > max) {
            txt.setCustomValidity("Campo no válido");
            errorMessage2.textContent = 'La descripción debe tener entre 1 y 10 caracteres.';
            txt.classList.add("novalido");
        } else {
            txt.classList.add("valido");
            errorMessage2.textContent = '';
        }
    }
});
