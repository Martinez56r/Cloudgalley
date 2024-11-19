const regexMail = /^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/g;

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btnMostrarOcultar").addEventListener("click", e => {
        let passwordInput = document.getElementById("txtPassword");
        passwordInput.type = passwordInput.type === "password" ? "text" : "password";
        e.target.innerText = passwordInput.type === "password" ? "Ver" : "Ocultar";
    });

    document.getElementById("txtEmail").addEventListener("input", e => {
        let emailInput = e.target;
        if (emailInput.value.trim().match(regexMail)) {
            emailInput.setCustomValidity("");
            emailInput.classList.add("valido");
            emailInput.classList.remove("novalido");
            
        } else {
            emailInput.setCustomValidity("Campo no válido");
            emailInput.classList.remove("valido");
            emailInput.classList.add("novalido");
        }
    });

    document.getElementById("verificarBtn").addEventListener("click", e => {
        let alert = e.target.parentElement.querySelector(".alert");
        if (alert) {
            alert.remove();
        }

        let form = e.target.form;
        form.classList.add("validado");

        let passwordInput = document.getElementById("txtPassword");
        let emailInput = document.getElementById("txtEmail");
        passwordInput.setCustomValidity("");
        emailInput.setCustomValidity("");

        if (passwordInput.value.trim().length < 1 || passwordInput.value.trim().length > 50) {
            passwordInput.setCustomValidity("");
        }

        if (!emailInput.value.trim().match(regexMail)) {
            emailInput.setCustomValidity("Campo no válido");
        }

        if (!form.checkValidity()) {
            e.preventDefault();
        }
        
    });
    document.getElementById("btnRegistrar").addEventListener("click", () => {
        window.location.href = "Register.php"; 
    });
});
