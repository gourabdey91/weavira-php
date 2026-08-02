<?php $faqs = $section['faqs'] ?? []; ?>

<?php if(!empty($faqs)): ?>
  <section class="wv-jnl-faq">
    <div class="section-heading-center wv-jnl-faq-heading">
      <h2>Frequently Asked Questions</h2>
    </div>
    <?php $__currentLoopData = $faqs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $faq): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="wv-jnl-faq-item">
        <button class="wv-jnl-faq-question" type="button" aria-expanded="false">
          <span><?php echo $faq['question']; ?></span>
          <span class="wv-jnl-faq-toggle" aria-hidden="true"></span>
        </button>
        <div class="wv-jnl-faq-answer">
          <?php echo $faq['answer']; ?>

        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </section>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/faq.blade.php ENDPATH**/ ?>