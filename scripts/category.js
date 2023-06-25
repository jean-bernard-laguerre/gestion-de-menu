function deleteCategory(event) {

    data = {table: "category",
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

            let row = this.parentNode.parentNode.parentNode;
            row.remove();
        }
    })
}

function editCategory() {

    let editor = document.getElementById("edit")
    editor.classList.toggle("hidden")
}


addEventListener("DOMContentLoaded", () => {
    
    let deleteButtons = document.querySelectorAll(".remove")
    deleteButtons.forEach(button => {
        
        button.addEventListener("click", deleteCategory)
    });

    let editButtons = document.querySelectorAll(".edit")
    editButtons.forEach(button => {
        
        button.addEventListener("click", editCategory)
    });

    let closeButton = document.querySelector("#close-button")
    closeButton.addEventListener("click", editCategory)
    
})
