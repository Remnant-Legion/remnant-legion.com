<?php
$sections = [];
$args = [
    'post_type' => 'page',
    'parent' => $post->ID,
    'sort_column' => 'menu_order',
    'post_status' => 'private'
];

function packagePage(Array &$sections, $page){
    array_push($sections, [
        $page,
        wp_get_attachment_url( get_post_thumbnail_id($page->ID))
    ]);
}

packagePage($sections, $post);

foreach(get_pages($args) as $page) {
    packagePage($sections, $page);
}

?>
<div class="container-fluid home">
    <?php foreach($sections as $section): ?>
        <?php list($page, $image) = $section; ?>
        <section id="<?= $page->post_name ?>" class="<?= $page->post_name ?>" style="background-image: url('<?= $image; ?>')">
            <div class="ghost"></div>
            <?= $page->post_content ?>
        </section>
    <?php endforeach; ?>
</div>

