function deleteRestaurant(event) {

    let data = {table: "restaurant",
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

            let row = this.parentNode.parentNode.parentNode
            row.remove();
        }
    })
}

function editRestaurant() {
    
    let editor = document.getElementById("edit")
    editor.classList.toggle("hidden")
}


addEventListener("DOMContentLoaded", () => {
    
    let deleteButtons = document.querySelectorAll(".remove")
    deleteButtons.forEach(button => {
        
        button.addEventListener("click", deleteRestaurant)
    });

    let editButtons = document.querySelectorAll(".edit")
    editButtons.forEach(button => {
        
        button.addEventListener("click", editRestaurant)
    });

    let closeButton = document.querySelector("#close-button")
    closeButton.addEventListener("click", editRestaurant)
    
})
