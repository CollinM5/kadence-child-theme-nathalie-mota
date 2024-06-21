const modalBackground = document.getElementById("modal-background");
const contactLinks = document.getElementsByClassName("menu-item-26");


for (let index = 0; index < contactLinks.length; index++) {
    const contactLink = contactLinks[index];

    contactLink.addEventListener("click", () => {
        modalBackground.className = "open display";
    })
}


modalBackground.addEventListener("click", (e) => {
    if(e.target.id == "modal-background"){
        modalBackground.className = "close display";
        setTimeout(() => {
            modalBackground.className = "close displayNone";
        }, "500");
    }
})


// miniature des posts

const miniatures = document.getElementsByClassName("post-photo-thumbnail");

for (let index = 0; index < miniatures.length; index++) {
    const miniature = miniatures[index];
    
    miniature.addEventListener("mouseover", mouseOverPostThumbnail)
    miniature.addEventListener("mouseout", mouseOutPostThumbnail)
}


function mouseOverPostThumbnail(e){
   
    let parent = e.target.closest('.post-photo-thumbnail');
    let hoverImageElement = parent.querySelector('.hover-image');
   
    if(hoverImageElement){
        hoverImageElement.className = "hover-image display"
    }
}

function mouseOutPostThumbnail(e){
    
    let parent = e.target.closest('.post-photo-thumbnail');
    let hoverImageElement = parent.querySelector('.hover-image');

    if(hoverImageElement){
        hoverImageElement.className = "hover-image displayNone"
    }
}