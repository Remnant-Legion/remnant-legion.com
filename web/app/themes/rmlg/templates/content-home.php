<?php
$sections = [];
$args = [
    'post_type' => 'page',
    'parent' => $post->ID,
    'sort_column' => 'menu_order',
    'post_status' => 'private'
];


function packagePage(Array &$sections, $page){
    $id = $page->ID;
    array_push($sections, [
        $page,
        wp_get_attachment_url( get_post_thumbnail_id($id)),
        get_field('bottom_copy', $id)
    ]);
}

packagePage($sections, $post);

foreach(get_pages($args) as $page) {
    packagePage($sections, $page);
}
?>

<div class="container-fluid home">
    <?php foreach($sections as $section): ?>
        <?php list($page, $image, $bottom_field) = $section; ?>
        <section id="<?= $page->post_name ?>" class="<?= $page->post_name ?>" style="background-image: url('<?= $image; ?>')">
            <div class="ghost"></div>
            <div class="inner-content">
                <?php
                    var_dump($page);
                ?>
                <?= apply_filters('the_content', $page->post_content) ?>
            </div>
            
            <?php if (strlen($bottom_field)): ?> 
                <h4 class="bottom-field"><?= $bottom_field ?></h4>
            <?php endif; ?>
        </section>
    <?php endforeach; ?>
</div>

