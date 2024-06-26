let imagesLinks = [];

function fullscreenButtonInit(){
    let buttons = document.getElementsByClassName("icon-fullscreen");
    imagesLinks = [];

    for (let index = 0; index < buttons.length; index++) {
        const button = buttons[index];
        
        imagesLinks.push([button.dataset.imageurl, button.dataset.reference, button.dataset.categorie])

        button.addEventListener('click', () => loadImage(button.dataset.imageurl, button.dataset.reference, button.dataset.categorie))
    }

}


function loadImage(img, ref, cate){
    let dom = createLightBoxElement(img, ref, cate);

    document.getElementById("inner-wrap").append(dom);
    
    url = null
    const image = new Image()
    const container = dom.querySelector('.lightbox__container')
    const loader = document.createElement('div')
    loader.classList.add('lightbox__loader')

    const info = document.createElement('div')
    info.classList.add('lightbox_info')

    let refElement = document.createElement('p')
    refElement.innerHTML = ref

    let cateElement = document.createElement('p')
    cateElement.innerHTML = cate

    info.appendChild(refElement)
    info.appendChild(cateElement)

    container.innerHTML = ''
    container.appendChild(loader)
    image.onload = () => {
        container.removeChild(loader)
        container.appendChild(image)
        container.appendChild(info)  
        url = img
    }
    image.src = img
}

function createLightBoxElement(img){

    const dom = document.createElement('div')
    dom.classList.add('lightbox')
    dom.innerHTML = `<div class="lightbox__close__div"><img class="lightbox__close" src="http://nathalie-mota.local/wp-content/themes/kadence-child-theme-nathalie-mota/assets/images/close.svg"></div>
        <div class="lightbox_main">
            <a class="lightbox__prev"><img src="http://nathalie-mota.local/wp-content/themes/kadence-child-theme-nathalie-mota/assets/images/arrowLeft.svg"><span class="lightbox__nav__text">&nbsp; Précédent</span></a>
            <div class="lightbox__container">
            </div>
            <a class="lightbox__next"><span class="lightbox__nav__text">Suivant &nbsp;</span><img src="http://nathalie-mota.local/wp-content/themes/kadence-child-theme-nathalie-mota/assets/images/arrowRight.svg"></a>
        </div>
        <div></div>
        `
    dom.querySelector('.lightbox__close').addEventListener('click', () => close(dom));
    dom.querySelector('.lightbox__next').addEventListener('click', () => next(img, dom));
    dom.querySelector('.lightbox__prev').addEventListener('click', () => prev(img, dom));

    return dom;
}

function next (img, dom) {
    let i = imagesLinks.findIndex(image => image[0] === img)
    if (i === imagesLinks.length - 1) {
      i = -1
    }
    close (dom)
    loadImage(imagesLinks[i + 1][0], imagesLinks[i + 1][1], imagesLinks[i + 1][2])
}

function prev (img, dom) {
    let i = imagesLinks.findIndex(image => image[0] === img)
    if (i === 0) {
      i = imagesLinks.length
    }
    close (dom)
    loadImage(imagesLinks[i - 1][0], imagesLinks[i - 1][1], imagesLinks[i - 1][2])
}

function close (dom) {
    dom.remove();
}


fullscreenButtonInit();