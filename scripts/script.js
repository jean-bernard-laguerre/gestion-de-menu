function editUser() {

    newLogin = document.getElementById("login")
    newPassword = document.getElementById("password")

    data = {login: newLogin.value, password: newPassword.value}

    fetch('../functions/edit.php', {
                method: 'POST',
                headers: {
                    'Content-Type':'application/json'
                },
                body: JSON.stringify(data)
    });
}


addEventListener("DOMContentLoaded", () => {
    
    formButton = document.getElementById("submit")
    formButton.addEventListener("click", editUser)
})