<?php $stats = $section['stats'] ?? []; ?>

<?php if(!empty($stats)): ?>
  <section class="wv-jnl-stats">
    <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="wv-jnl-stats-item">
        <i data-lucide="<?php echo $stat['stat_icon'] ?: 'circle'; ?>" aria-hidden="true"></i>
        <strong><?php echo $stat['stat_value']; ?></strong>
        <span><?php echo $stat['stat_label']; ?></span>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </section>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/statistics_strip.blade.php ENDPATH**/ ?>