import { duplicate, deleteDuplicate } from "./function";

function editDish() {

    let editor = document.getElementById("edit")
    editor.classList.toggle("hidden")
}

function removeDish(event) {

    let data = {table: "dish",
            id: this.id}

    fetch('../functions/remove.php', {
                method: 'POST',
                headers: {
                    'Content-Type':'application/json'
                },
                body: JSON.stringify(data)
    })
    .then(res => res.json())
    .then(response => {
        if (response["success"]) {
            this.parentNode.parentNode.remove()
        }
    })
}

addEventListener("DOMContentLoaded", () => {

    let addButton = document.getElementById("add")
    addButton.addEventListener("click", () => {duplicate(".ingredient-input")})

    let removeButton = document.getElementById("remove")
    removeButton.addEventListener("click", () => {deleteDuplicate("ingredient-input")})

    let editAddButton = document.getElementById("edit-add")
    editAddButton.addEventListener("click", () => {duplicate(".edit-ingredient")})

    let editRemoveButton = document.getElementById("edit-remove")
    editRemoveButton.addEventListener("click", () => {deleteDuplicate("edit-ingredient")})

    let deleteButtons = document.querySelectorAll(".remove-dish")
    deleteButtons.forEach(button => {
        
        button.addEventListener("click", removeDish)
    });

    let editButtons = document.querySelectorAll(".edit-dish")
    editButtons.forEach(button => {
        
        button.addEventListener("click", editDish)
    });

    let closeButton = document.querySelector("#close-button")
    closeButton.addEventListener("click", editDish)
})