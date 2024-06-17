const modalBackground = document.getElementById("modal-background");
const contactLink = document.getElementById("menu-item-26");


contactLink.addEventListener("click", () => {
    modalBackground.className = "open display";
})

modalBackground.addEventListener("click", (e) => {
    if(e.target.id == "modal-background"){
        modalBackground.className = "close display";
        setTimeout(() => {
            modalBackground.className = "close displayNone";
        }, "500");
    }
})