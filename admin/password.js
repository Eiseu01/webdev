const checkbox = document.getElementById("chkShowPassword");
const passwordInput = document.getElementById("password");

function changeType() {
    if (checkbox.checked) {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}
