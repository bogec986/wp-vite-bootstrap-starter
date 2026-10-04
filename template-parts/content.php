<article <?php post_class('mb-5'); ?>>
    <?php if (has_post_thumbnail()) : ?>
        <a href="<?php the_permalink(); ?>" class="d-block mb-3">
            <?php the_post_thumbnail('large', ['class' => 'img-fluid rounded']); ?>
        </a>
    <?php endif; ?>

    <h2 class="h3">
        <a class="text-decoration-none" href="<?php the_permalink(); ?>">
            <?php the_title(); ?>
        </a>
    </h2>

    <div class="text-body-secondary small mb-3">
        <time datetime="<?php echo esc_attr(get_the_date(DATE_W3C)); ?>">
            <?php echo esc_html(get_the_date()); ?>
        </time>

        <?php if (has_tag()) : ?>
            <span class="ms-2">
                <?php the_tags('', ', ', ''); ?>
            </span>
        <?php endif; ?>
    </div>

    <div class="entry-summary">
        <?php the_excerpt(); ?>
    </div>
</article>
