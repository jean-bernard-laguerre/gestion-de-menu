export function duplicate(element) {
    let original = document.querySelector(element)
    let clone  = original.cloneNode(true);
    original.after(clone);
}

export function deleteDuplicate(element) {
    let container = document.getElementsByClassName(element)
    
    if (container.length > 1) {
        container[container.length - 1].remove();
    }
}