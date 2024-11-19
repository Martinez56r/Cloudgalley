var regCorreo = /^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,4}$/g;
var regTel = /^[0-9]{10}$/g;

document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("floatingName").onkeyup = e =>
        revisarControl(e, 2, 60);
    document.getElementById("floatingUsername").onkeyup = e =>
        revisarControl(e, 2, 60);
    document.getElementById("floatingEmail").onkeyup = e => {
        if (e.code == "Tab") return;
        let txt = e.target;
        if (txt.value.trim().match(regCorreo)) {
            txt.setCustomValidity("");
            txt.classList.add("valido");
            txt.classList.remove("novalido");
        } else {
            txt.setCustomValidity("Campo no válido");
            txt.classList.remove("valido");
            txt.classList.add("novalido");
        }
    }
    document.getElementById("floatingPhoneNumber").onkeyup = e => {
        let txt = e.target;
        if (txt.value.trim().match(regTel)) {
            txt.setCustomValidity("");
            txt.classList.add("valido");
            txt.classList.remove("novalido");
        } else {
            txt.setCustomValidity("Campo no válido");
            txt.classList.remove("valido");
            txt.classList.add("novalido");
        }
    }

    document.getElementById("floatingPassword").onkeyup = e => {
        revisarControl(e, 8, 20);
    }

    document.getElementById("floatingDateOfBirth").onchange = e => {
        let txt = e.target;
        if (isValidAge(txt.value)) {
            txt.setCustomValidity("");
            txt.classList.add("valido");
            txt.classList.remove("novalido");
        } else {
            txt.setCustomValidity("Debe ser mayor de 18 años");
            txt.classList.remove("valido");
            txt.classList.add("novalido");
        }
    }

    document.querySelector("form").addEventListener("submit", e => {
        e.target.classList.add("validado");
        let valid = e.target.checkValidity();
        if (!valid) {
            e.preventDefault();
        }
    });
});

document.getElementById("btnAceptar").addEventListener("click", e => {
    e.target.form.classList.add("validado");
    let txtNombre = document.getElementById("floatingName");
    let User = document.getElementById("floatingUsername");
    let txtContrasenia = document.getElementById("floatingPassword");
    let txtEmail = document.getElementById("floatingEmail");
    let txtTel = document.getElementById("floatingPhoneNumber");
    let txtFechaNacimiento = document.getElementById("floatingDateOfBirth");

    let controles = e.target.form.querySelectorAll("input, select");
    controles.forEach(control => {
        control.setCustomValidity("");
    });

    if (txtNombre.value.trim().length < 2 ||
        txtNombre.value.trim().length > 60) {
        txtNombre.setCustomValidity("El nombre es obligatorio (entre 2 y 60 caracteres)");
    }
    if (User.value.trim().length < 2 ||
        User.value.trim().length > 60) {
        User.setCustomValidity("El nombre de usuario es obligatorio (entre 2 y 60 caracteres)");
    }
    if (txtContrasenia.value.trim().length < 8 ||
        txtContrasenia.value.trim().length > 20) {
        txtContrasenia.setCustomValidity("La contraseña es obligatoria (entre 8 y 20 caracteres)");
    }
    if (txtTel.value.trim().length > 0 &&
        txtTel.value.trim().length !== 10) {
        txtTel.setCustomValidity("El teléfono debe tener 10 dígitos");
    }
    if (!isValidAge(txtFechaNacimiento.value)) {
        txtFechaNacimiento.setCustomValidity("Debe ser mayor de 18 años");
    }

    if (!e.target.form.checkValidity()) {
        e.preventDefault();
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
        txt.classList.add("novalido");
    } else {
        txt.classList.add("valido");
    }
}

function isValidAge(dateString) {
    let today = new Date();
    let birthDate = new Date(dateString);
    let age = today.getFullYear() - birthDate.getFullYear();
    let m = today.getMonth() - birthDate.getMonth();
    if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
        age--;
    }
    return age >= 18;
}
