document
    .getElementById("toggleNewPassword")
    .addEventListener("click", function () {
        const passwordField = document.getElementById("new-password");
        const icon = this;
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    });

document
    .getElementById("toggleConfirmPassword")
    .addEventListener("click", function () {
        const passwordField = document.getElementById("confirm-password");
        const icon = this;
        if (passwordField.type === "password") {
            passwordField.type = "text";
            icon.classList.remove("fa-eye");
            icon.classList.add("fa-eye-slash");
        } else {
            passwordField.type = "password";
            icon.classList.remove("fa-eye-slash");
            icon.classList.add("fa-eye");
        }
    });
