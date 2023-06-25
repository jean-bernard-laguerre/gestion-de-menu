import { duplicate, deleteDuplicate } from "./function";

function editMenu() {

    let editor = document.getElementById("edit")

    editor.classList.toggle("hidden")
    
}

function removeMenu(event) {
    
    let data = {table: "menu",
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

            this.parentNode.parentNode.remove();
        }
    })
}

addEventListener("DOMContentLoaded", () => {

    let addButton = document.getElementById("add")
    addButton.addEventListener("click", () => {duplicate(".dish-select")})

    let removeButton = document.getElementById("remove")
    removeButton.addEventListener("click", () => {deleteDuplicate("dish-select")})

    let editAddButton = document.getElementById("edit-add")
    editAddButton.addEventListener("click", () => {duplicate(".edit-dish-select")})

    let editRemoveButton = document.getElementById("edit-remove")
    editRemoveButton.addEventListener("click", () => {deleteDuplicate("edit-dish-select")})

    let deleteButtons = document.querySelectorAll(".remove-menu")
    deleteButtons.forEach(button => {
        
        button.addEventListener("click", removeMenu)
    });

    let editButtons = document.querySelectorAll(".edit-menu")
    editButtons.forEach(button => {
        
        button.addEventListener("click", editMenu)
    });

    let closeButton = document.querySelector("#close-button")
    closeButton.addEventListener("click", editMenu)
})