const modalBackground = document.getElementById("modal-background");
const contactLink = document.getElementById("menu-item-26");


contactLink.addEventListener("click", () => {
    modalBackground.className = "open";
})

modalBackground.addEventListener("click", (e) => {
    if(e.target.id == "modal-background"){
        modalBackground.className = "close";
    }
})