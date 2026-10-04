<?php

declare(strict_types=1);

if (post_password_required()) {
    return;
}
?>

<section id="comments" class="comments-area mt-5">
    <?php if (have_comments()) : ?>
        <h2 class="comments-title h3">
            <?php
            printf(
                esc_html(_n('%s Comment', '%s Comments', get_comments_number(), 'wp-starter')),
                number_format_i18n(get_comments_number())
            );
            ?>
        </h2>

        <ol class="comment-list list-unstyled">
            <?php
            wp_list_comments([
                'style'      => 'ol',
                'short_ping' => true,
                'avatar_size' => 48,
            ]);
            ?>
        </ol>

        <?php
        the_comments_pagination([
            'prev_text' => __('Previous comments', 'wp-starter'),
            'next_text' => __('Next comments', 'wp-starter'),
        ]);
        ?>
    <?php endif; ?>

    <?php
    if (!comments_open() && get_comments_number() && post_type_supports(get_post_type(), 'comments')) :
        ?>
        <p class="no-comments"><?php esc_html_e('Comments are closed.', 'wp-starter'); ?></p>
    <?php endif; ?>

    <?php comment_form(); ?>
</section>
