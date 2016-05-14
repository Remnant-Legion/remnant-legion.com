<?php
use Roots\Sage\Titles;

$feat_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-6">
            <h1><?= Titles\title(); ?></h1>
            <?php the_content(); ?>
        </div>
        <div class="col-sm-6 image-row" style="background: url('<?= $feat_image ?>') no-repeat center center">
        </div>
    </div>
</div>
