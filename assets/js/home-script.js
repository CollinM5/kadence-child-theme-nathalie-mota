document.getElementById("hero").style.backgroundImage = "url("+document.getElementById("hero").dataset.background+")";

let post_in_page = 8;
(function ($) {
    $(document).ready(function () {

        // Charger plus de photo 
        $('.js-load-posts').submit(function (e) {

            // Empêcher l'envoi classique du formulaire
            e.preventDefault();

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = $(this).attr('action');

            // Les données de notre formulaire
            let data = {
                action: $(this).find('input[name=action]').val(), 
                nonce:  $(this).find('input[name=nonce]').val(),
                order: $(this).find('input[name=order]').val(),
                posts_per_page: $(this).find('input[name=posts_per_page]').val(),
                offset: post_in_page,
            }

            if($('select[name="categories"]').val() !== ""){
                data.categories = $('select[name="categories"]').val();
            }

            if($('select[name="formats"]').val() !== ""){
                data.formats = $('select[name="formats"]').val();
            }

            if($('select[name="order"]').val() !== ""){
                data.order = $('select[name="order"]').val();
            }

            // Pour vérifier qu'on a bien récupéré les données
            console.log("ajaxurl : " + ajaxurl);
            console.log("data : ", data);

            // Requête Ajax en JS natif via Fetch
            fetch(ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Cache-Control': 'no-cache',
                },
                body: new URLSearchParams(data),
            })
            .then(response => response.json())
            .then(body => {
                console.log("body : ", body); // Utilisation de la virgule pour afficher l'objet

                // En cas d'erreur
                if (!body.success) {
                    return;
                }

                if(body.data.content !== ''){
                    // Et en cas de réussite
                    $('#photos').append(body.data.content); // afficher le HTML

                    const miniatures = document.getElementsByClassName("post-photo-thumbnail");
                    fullscreenButtonInit();
                    
                    for (let index = 0; index < miniatures.length; index++) {
                        const miniature = miniatures[index];

                        miniature.removeEventListener("mouseover", mouseOverPostThumbnail)
                        miniature.removeEventListener("mouseout", mouseOutPostThumbnail)
                        
                        miniature.addEventListener("mouseover", mouseOverPostThumbnail)
                        miniature.addEventListener("mouseout", mouseOutPostThumbnail)
                    }

                    post_in_page += parseInt(data.posts_per_page); // Mettre à jour l'offset

                    if(!body.data.has_more){
                        document.getElementById("js-load-posts-form").className = "js-load-posts displayNone";
                    }


                }else{
                    document.getElementById("js-load-posts-form").className = "js-load-posts displayNone";
                }

            })
            .catch(error => {
                console.error('Error:', error);
            });
        });

        // ----------------------------- formulaire de tri ----------------------------- //

        // envoie le formulaire au changement de valeur d un element
        $('.sort-elements').on('change', function() {
            $('.sort-posts').submit();
        });

         // tri des photos en Ajax
         $('.sort-posts').submit(function (e) {

            // Empêcher l'envoi classique du formulaire
            e.preventDefault();

            // L'URL qui réceptionne les requêtes Ajax dans l'attribut "action" de <form>
            const ajaxurl = $(this).attr('action');

            // Les données de notre formulaire
            let data = {
                action: $(this).find('input[name=action]').val(), 
                nonce:  $(this).find('input[name=nonce]').val(),
                order: "desc",
                posts_per_page: $(this).find('input[name=posts_per_page]').val(),
            }

            if($('select[name="categories"]').val() !== ""){
                data.categories = $('select[name="categories"]').val();
            }

            if($('select[name="formats"]').val() !== ""){
                data.formats = $('select[name="formats"]').val();
            }

            if($('select[name="order"]').val() !== ""){
                data.order = $('select[name="order"]').val();
            }

            // Pour vérifier qu'on a bien récupéré les données
            console.log("ajaxurl : " + ajaxurl);
            console.log("data : ", data);

            // Requête Ajax en JS natif via Fetch
            fetch(ajaxurl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'Cache-Control': 'no-cache',
                },
                body: new URLSearchParams(data),
            })
            .then(response => response.json())
            .then(body => {
                console.log("body : ", body); // Utilisation de la virgule pour afficher l'objet

                // En cas d'erreur
                if (!body.success) {
                    return;
                }

                if(body.data !== ''){
                    // Et en cas de réussite
                    $('#photos').html(body.data.content); // afficher le HTML

                    const miniatures = document.getElementsByClassName("post-photo-thumbnail");
                    fullscreenButtonInit();

                    for (let index = 0; index < miniatures.length; index++) {
                        const miniature = miniatures[index];

                        miniature.removeEventListener("mouseover", mouseOverPostThumbnail)
                        miniature.removeEventListener("mouseout", mouseOutPostThumbnail)
                        
                        miniature.addEventListener("mouseover", mouseOverPostThumbnail)
                        miniature.addEventListener("mouseout", mouseOutPostThumbnail)
                    }

                    if(!body.data.has_more){
                        document.getElementById("js-load-posts-form").className = "js-load-posts displayNone";
                    }else{
                        document.getElementById("js-load-posts-form").className = "js-load-posts display";
                    }

                    post_in_page = 8; // Mettre à jour l'offset
                }else{
                    document.getElementById("js-load-posts-form").className = "js-load-posts displayNone";
                    $('#photos').html("Aucun résultat");
                }

            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
        
    });
})(jQuery);
