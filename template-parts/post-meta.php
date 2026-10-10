<?php
/**
 * Shared post metadata.
 */

?>
<div class="post-meta text-body-secondary small mb-3">
    <time datetime="<?php echo esc_attr(get_the_date(DATE_W3C)); ?>">
        <?php echo esc_html(get_the_date()); ?>
    </time>

    <?php
    $categories = get_the_category_list(', ');

    if ($categories) :
    ?>
        <span class="ms-2">
            <?php echo wp_kses_post($categories); ?>
        </span>
    <?php endif; ?>
</div>
