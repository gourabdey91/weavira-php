<?php $images = $section['images'] ?? []; ?>

<?php if(!empty($images)): ?>
  <section class="wv-jnl-gallery">
    <ul class="wv-jnl-gallery-list">
      <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(!empty($img['image'])): ?>
          <li class="wv-jnl-gallery-item"><img src="<?php echo e($img['image']); ?>" alt="" loading="lazy"></li>
        <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </section>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/gallery.blade.php ENDPATH**/ ?>