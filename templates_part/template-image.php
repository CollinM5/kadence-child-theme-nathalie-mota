
<div class="post-photo-thumbnail">
    <?php echo the_post_thumbnail( 'small' ) ?>
    <div class="hover-image displayNone">
        <div class="icon-fullscreen"><img src="<?php echo get_stylesheet_directory_uri()  ?>/assets/images/fullScreenIcon.svg"></div>
        <a href="<?php echo get_permalink( get_the_ID() ) ?>"><img class="icon-eye" src="<?php echo get_stylesheet_directory_uri()  ?>/assets/images/Icon_eye.svg"></a>
        <div class="post-photo-title-and-categorie">
            <p><?php echo get_the_title() ?></p>
            <p><?php echo get_the_terms( get_the_ID(), 'categorie' )[0]->name ?></p>
        </div>
    </div>
</div>

  