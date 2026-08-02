<?php $logo = get_field('arc_option_logo', 'option'); ?>

<section class="wv-jnl-signoff">
  <div class="wv-jnl-signoff-brand">
    <div class="wv-jnl-signoff-seal">
      <?php if($logo): ?>
        <span class="wv-jnl-signoff-mark" aria-hidden="true"><img src="<?php echo e($logo); ?>" alt=""></span>
      <?php endif; ?>
      <span class="wv-jnl-signoff-word">WEAVIRA</span>
      <span class="wv-jnl-signoff-sub">Editorial</span>
    </div>
  </div>
  <div class="wv-jnl-signoff-body">
    <?php if(!empty($section['signoff_message'])): ?>
      <p class="wv-jnl-signoff-message"><?php echo e($section['signoff_message']); ?></p>
    <?php endif; ?>
    <div class="wv-jnl-signoff-share">
      <span class="wv-jnl-signoff-share-label">Share This Story</span>
      <div class="wv-jnl-signoff-share-icons">
        <a href="#" class="wv-jnl-signoff-share-icon" aria-label="Share on WhatsApp"><i data-lucide="message-circle" aria-hidden="true"></i></a>
        <a href="#" class="wv-jnl-signoff-share-icon" aria-label="Share on Facebook"><i data-lucide="facebook" aria-hidden="true"></i></a>
        <a href="#" class="wv-jnl-signoff-share-icon" aria-label="Share on X"><i data-lucide="x" aria-hidden="true"></i></a>
        <a href="#" class="wv-jnl-signoff-share-icon" aria-label="Share on Pinterest"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" aria-hidden="true"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.236 2.636 7.855 6.356 9.312-.088-.791-.167-2.005.035-2.868.181-.78 1.172-4.97 1.172-4.97s-.299-.598-.299-1.482c0-1.388.806-2.428 1.808-2.428.852 0 1.265.64 1.265 1.408 0 .858-.546 2.14-.828 3.33-.236.995.499 1.806 1.476 1.806 1.771 0 3.136-1.867 3.136-4.562 0-2.387-1.715-4.056-4.163-4.056-2.836 0-4.498 2.126-4.498 4.322 0 .856.33 1.773.741 2.274a.3.3 0 0 1 .069.286c-.076.312-.243.995-.275 1.134-.044.183-.146.222-.336.134-1.249-.581-2.03-2.407-2.03-3.874 0-3.154 2.292-6.052 6.608-6.052 3.469 0 6.165 2.473 6.165 5.776 0 3.447-2.173 6.22-5.19 6.22-1.013 0-1.967-.527-2.292-1.148l-.623 2.378c-.226.869-.835 1.958-1.244 2.621.937.29 1.931.446 2.962.446C17.523 22 22 17.523 22 12S17.523 2 12 2z"/></svg></a>
        <a href="#" class="wv-jnl-signoff-share-icon" aria-label="Share via Email"><i data-lucide="mail" aria-hidden="true"></i></a>
      </div>
    </div>
  </div>
</section>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/signoff.blade.php ENDPATH**/ ?>