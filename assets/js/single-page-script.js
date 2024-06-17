/* navigation entre les articles */

const arrows = document.getElementsByClassName("arrow");
const preview = document.getElementById("preview-image");

preview.src = document.getElementById("next-post").dataset.image;

for (let index = 0; index < arrows.length; index++) {
    const element = arrows[index];
    
    element.addEventListener("mouseover", () => {
        preview.src = element.dataset.image;
    })
}

/* préremplir le formulaire de contact */

const btnContact = document.getElementById("btn-contact");

btnContact.addEventListener("click", () => {
    document.getElementById("form-image-ref").value = document.getElementById("image-ref").innerHTML;
    modalBackground.className = "open display";
})

modalBackground.addEventListener("click", (e) => {
    if(e.target.id == "modal-background"){
        modalBackground.className = "close display";
        setTimeout(() => {
            document.getElementById("form-image-ref").value = "";
            modalBackground.className = "close displayNone";
        }, "500");
    }
})