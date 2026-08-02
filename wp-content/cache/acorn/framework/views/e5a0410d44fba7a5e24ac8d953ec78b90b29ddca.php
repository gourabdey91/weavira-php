<?php $items = $section['trust_items'] ?? []; ?>

<?php if(!empty($items)): ?>
  <section class="hero-features">
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="hero-feature">
        <div class="feature-icon"><?php echo $item['icon_character']; ?></div>
        <div>
          <p class="feature-title"><?php echo $item['title']; ?></p>
          <p><?php echo $item['subtitle']; ?></p>
        </div>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </section>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/home/trust_strip.blade.php ENDPATH**/ ?>