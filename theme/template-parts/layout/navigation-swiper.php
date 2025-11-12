<?php
$sibling_pages = $args['sibling_pages'] ?? false
?>


<div data-nav-slider="target" class="-ml-1.5 flex grow items-center min-w-0">
    <div data-nav-slider="container" class="flex gap-6 items-center pl-5.5 pr-4 bg-neutral-grey-1 h-full rounded-r-lg min-w-0">
        <button class="swiper-button-prev text-neutral-black">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 12L8.64645 11.6464C8.45118 11.8417 8.45118 12.1583 8.64645 12.3536L9 12ZM14.6464 18.3536C14.8417 18.5488 15.1583 18.5488 15.3536 18.3536C15.5488 18.1583 15.5488 17.8417 15.3536 17.6464L15 18L14.6464 18.3536ZM15 6L14.6464 5.64645L8.64645 11.6464L9 12L9.35355 12.3536L15.3536 6.35355L15 6ZM9 12L8.64645 12.3536L14.6464 18.3536L15 18L15.3536 17.6464L9.35355 11.6464L9 12Z" fill="currentColor" />
            </svg>
        </button>

        <div data-nav-slider="wrap" class="overflow-auto no-scrollbar flex gap-[32px] bg-amber-100">

            <?php foreach ($sibling_pages as $page) : ?>
                <a data-nav-link data-nav-slider="item" class="group shrink-0 flex items-center gap-2 text-body-s" href="<?php echo esc_url(get_page_link($page)) ?>">
                    <div class="hidden group-[.is-current]:block w-1.5 h-1.5 bg-brand-primary rounded-full"></div>
                    <span class="text-neutral-grey-3 group-[.is-current]:text-neutral-black group-hover:text-neutral-black transition-colors duration-200">
                        <?php echo esc_html($page->post_title) ?>
                    </span>
                </a>
            <?php endforeach ?>

        </div>

        <button class="swiper-button-next text-neutral-black">
            <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M15 12L15.3536 12.3536C15.5488 12.1583 15.5488 11.8417 15.3536 11.6464L15 12ZM9.35355 5.64645C9.15829 5.45118 8.84171 5.45118 8.64645 5.64645C8.45118 5.84171 8.45118 6.15829 8.64645 6.35355L9 6L9.35355 5.64645ZM9 18L9.35355 18.3536L15.3536 12.3536L15 12L14.6464 11.6464L8.64645 17.6464L9 18ZM15 12L15.3536 11.6464L9.35355 5.64645L9 6L8.64645 6.35355L14.6464 12.3536L15 12Z" fill="currentColor" />
            </svg>
        </button>
    </div>
</div>