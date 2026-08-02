
<nav class="mobile-bottom-nav" aria-label="Mobile navigation">

    <a class="mobile-bottom-nav-item <?php if(is_front_page()): ?> active <?php endif; ?>" href="<?php echo e(home_url('/')); ?>">
        <span class="mobile-bottom-nav-icon">
            <i data-lucide="home" aria-hidden="true"></i>
        </span>
        <span class="mobile-bottom-nav-label">Home</span>
    </a>

    <a class="mobile-bottom-nav-item <?php if(is_page('moments')): ?> active <?php endif; ?>" href="<?php echo e(get_permalink(get_page_by_path('moments'))); ?>">
        <span class="mobile-bottom-nav-icon">
            <i data-lucide="clapperboard" aria-hidden="true"></i>
        </span>
        <span class="mobile-bottom-nav-label">Moments</span>
    </a>

    <a class="mobile-bottom-nav-item" href="#" aria-label="Search">
        <span class="mobile-bottom-nav-icon">
            <i data-lucide="search" aria-hidden="true"></i>
        </span>
        <span class="mobile-bottom-nav-label">Search</span>
    </a>

    <a class="mobile-bottom-nav-item" href="<?php echo e($wishlistUrl); ?>">
        <span class="mobile-bottom-nav-icon">
            <i data-lucide="heart" aria-hidden="true"></i>
        </span>
        <span class="mobile-bottom-nav-label">Wishlist</span>
    </a>

    <a class="mobile-bottom-nav-item" href="<?php echo e(wc_get_page_permalink('myaccount')); ?>">
        <span class="mobile-bottom-nav-icon">
            <i data-lucide="user" aria-hidden="true"></i>
        </span>
        <span class="mobile-bottom-nav-label">Account</span>
    </a>

</nav>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/mobile-bottom-nav.blade.php ENDPATH**/ ?>