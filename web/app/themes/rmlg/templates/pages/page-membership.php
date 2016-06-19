<div>

    <?= apply_filters('the_content', $page->post_content) ?>
    <?php if (strlen($bottom_field)): ?>
        <h4 class="bottom-field"><?= $bottom_field ?></h4>
    <?php endif; ?>
    
</div>
