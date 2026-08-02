<section class="wv-jnl-quote">
  <span class="wv-jnl-quote-portrait">
    <?php if(!empty($section['portrait_image'])): ?>
      <img src="<?php echo $section['portrait_image']; ?>" alt="<?php echo $section['quote_name']; ?>">
    <?php else: ?>
      <i data-lucide="user" aria-hidden="true"></i>
    <?php endif; ?>
  </span>
  <div class="wv-jnl-quote-body">
    <p class="wv-jnl-quote-text"><span class="wv-jnl-quote-mark" aria-hidden="true">&#8220;</span><?php echo $section['quote_text']; ?></p>
    <cite class="wv-jnl-quote-cite">
      <span class="wv-jnl-quote-name"><?php echo $section['quote_name']; ?></span>
      <span class="wv-jnl-quote-role"><?php echo $section['quote_role']; ?></span>
    </cite>
  </div>
</section>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/quote_portrait.blade.php ENDPATH**/ ?>