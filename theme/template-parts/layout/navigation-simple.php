<?php
$sibling_pages = $args['sibling_pages'] ?? false
?>

<div class="pl-9.5 pr-8 -ml-1.5 flex gap-8 items-center bg-neutral-grey-1 h-full rounded-r-lg">
    <?php foreach ($sibling_pages as $page) : ?>
        <a data-nav-link class="group flex items-center gap-2 text-body-s" href="<?php echo esc_url(get_page_link($page)) ?>">
            <div class="hidden group-[.is-current]:block w-1.5 h-1.5 bg-brand-primary rounded-full"></div>
            <span class="text-neutral-grey-3 group-[.is-current]:text-neutral-black group-hover:text-neutral-black transition-colors duration-200">
                <?php echo esc_html($page->post_title) ?>
            </span>
        </a>
    <?php endforeach ?>
</div>