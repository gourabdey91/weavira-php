<?php if(is_home() || is_front_page()): ?>
    <?php echo $__env->make('partials.trust-ribbon', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<footer class="site-footer">
    <!-- Follow us -->
    <?php
    $footer_left_social_media = get_field('footer_left_social_media', 'option');
    ?>
    <div class="wv-footer-follow">
        <div class="wv-footer-follow-heading">
            <span class="wv-footer-follow-line" aria-hidden="true"></span>
            <span class="wv-footer-follow-label">Follow Us</span>
            <span class="wv-footer-follow-line" aria-hidden="true"></span>
        </div>
        <div class="wv-footer-follow-list">
            <?php if($footer_left_social_media['footer_instagram_link']): ?>
            <a href="<?php echo e($footer_left_social_media['footer_instagram_link']); ?>" class="wv-footer-follow-item" aria-label="Instagram">
                <span class="wv-footer-follow-icon"><i data-lucide="instagram" aria-hidden="true"></i></span>
                <span>Instagram</span>
            </a>
            <?php endif; ?>
            <?php if($footer_left_social_media['footer_linkedin_link']): ?>
            <a href="<?php echo e($footer_left_social_media['footer_linkedin_link']); ?>" class="wv-footer-follow-item" aria-label="Pinterest">
                <span class="wv-footer-follow-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5" aria-hidden="true">
                        <path
                            d="M12 2C6.477 2 2 6.477 2 12c0 4.236 2.636 7.855 6.356 9.312-.088-.791-.167-2.005.035-2.868.181-.78 1.172-4.97 1.172-4.97s-.299-.598-.299-1.482c0-1.388.806-2.428 1.808-2.428.852 0 1.265.64 1.265 1.408 0 .858-.546 2.14-.828 3.33-.236.995.499 1.806 1.476 1.806 1.771 0 3.136-1.867 3.136-4.562 0-2.387-1.715-4.056-4.163-4.056-2.836 0-4.498 2.126-4.498 4.322 0 .856.33 1.773.741 2.274a.3.3 0 0 1 .069.286c-.076.312-.243.995-.275 1.134-.044.183-.146.222-.336.134-1.249-.581-2.03-2.407-2.03-3.874 0-3.154 2.292-6.052 6.608-6.052 3.469 0 6.165 2.473 6.165 5.776 0 3.447-2.173 6.22-5.19 6.22-1.013 0-1.967-.527-2.292-1.148l-.623 2.378c-.226.869-.835 1.958-1.244 2.621.937.29 1.931.446 2.962.446C17.523 22 22 17.523 22 12S17.523 2 12 2z" />
                    </svg></span>
                <span>Pinterest</span>
            </a>
            <?php endif; ?>
            <?php if($footer_left_social_media['footer_yt_link']): ?>
            <a href="<?php echo e($footer_left_social_media['footer_yt_link']); ?>" class="wv-footer-follow-item" aria-label="YouTube">
                <span class="wv-footer-follow-icon"><i data-lucide="youtube" aria-hidden="true"></i></span>
                <span>YouTube</span>
            </a>
            <?php endif; ?>
            <?php if($footer_left_social_media['footer_facebook_link']): ?>
            <a href="<?php echo e($footer_left_social_media['footer_facebook_link']); ?>" class="wv-footer-follow-item" aria-label="Facebook">
                <span class="wv-footer-follow-icon"><i data-lucide="facebook" aria-hidden="true"></i></span>
                <span>Facebook</span>
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Value-prop columns -->
    <div class="wv-footer-values">
        <div class="wv-footer-value-col">
            <div class="wv-footer-value-head">
                <span class="wv-footer-value-icon" aria-hidden="true"><i data-lucide="sparkles"></i></span>
                <h3>Why Weavira</h3>
            </div>
            <p class="footer-brand-desc"><?php echo get_field('footer_content_content', 'options'); ?></p>
            <?php if(get_field('about_cta_link', 'options')): ?>
            <a class="wv-card-explore" href="<?php echo e(get_field('about_cta_link', 'options')['url']); ?>"><?php echo e(get_field('about_cta_link', 'options')['title']); ?> &#8594;</a>
            <?php endif; ?>
        </div>
        <div class="wv-footer-value-col">
            <div class="wv-footer-value-head">
                <span class="wv-footer-value-icon" aria-hidden="true"><i data-lucide="feather"></i></span>
                <h3>Why Handwoven</h3>
            </div>
            <ul class="wv-footer-value-list">
                <li><i data-lucide="gem" aria-hidden="true"></i><span>Every piece is unique</span></li>
                <li><i data-lucide="users" aria-hidden="true"></i><span>Supports artisan communities</span></li>
                <li><i data-lucide="heart-handshake" aria-hidden="true"></i><span>Crafted with patience, not
                        machines</span></li>
                <li><i data-lucide="shield" aria-hidden="true"></i><span>Designed to last for generations</span></li>
            </ul>
            <a class="wv-card-explore" href="index.html#heritage">Learn More &#8594;</a>
        </div>
        <div class="wv-footer-value-col">
            <div class="wv-footer-value-head">
                <span class="wv-footer-value-icon" aria-hidden="true"><i data-lucide="message-circle"></i></span>
                <h3>Need Help?</h3>
            </div>
            <ul class="wv-footer-value-list">
                <li><i data-lucide="message-circle" aria-hidden="true"></i><span>Chat on WhatsApp</span></li>
                <li><i data-lucide="mail" aria-hidden="true"></i><span>hello@weavira.com</span></li>
                <li><i data-lucide="truck" aria-hidden="true"></i><span>Track Your Order</span></li>
                <li><i data-lucide="file-text" aria-hidden="true"></i><span>FAQs</span></li>
                <li><i data-lucide="headphones" aria-hidden="true"></i><span>+91 91234 56789</span></li>
            </ul>
            <a class="wv-card-explore" href="#">Contact Us &#8594;</a>
        </div>
    </div>
    <?php if(get_field('ffbi_featured_image', 'options')): ?>
    <img src="<?php echo get_field('ffbi_featured_image', 'options')['url']; ?>" alt="<?php echo get_field('ffbi_featured_image', 'options')['alt']; ?>" class="wv-footer-design-row" aria-hidden="true"
        loading="lazy">
    <?php endif; ?>

    <!-- Bottom bar -->
    <div class="footer-bottom">
        <p class="footer-copy">&copy; <?php echo e(date('Y')); ?> <?php echo e(get_bloginfo('name')); ?>. All Rights Reserved. <?php echo \App\Support\FooterCredit::render(); ?>

                </p>
        <div class="footer-legal">
            <a href="#">Privacy Policy</a>
            <span>|</span>
            <a href="#">Terms of Use</a>
            <span>|</span>
            <a href="#">Sitemap</a>
        </div>
    </div>



</footer>

<?php echo $__env->make('partials.mobile-bottom-nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/sections/footer.blade.php ENDPATH**/ ?>