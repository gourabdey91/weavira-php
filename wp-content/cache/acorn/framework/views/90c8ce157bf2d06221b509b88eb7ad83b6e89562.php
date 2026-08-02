<?php
  $points = $section['summary_points'] ?? [];
  $stats = $section['summary_stats'] ?? [];
?>

<?php if(!empty($points) || !empty($stats)): ?>
  <section class="wv-jnl-summary">
    <?php if(!empty($points)): ?>
      <div class="wv-jnl-summary-list-col">
        <span class="wv-jnl-summary-label"><?php echo $section['summary_label'] ?: 'In Short'; ?></span>
        <ul class="wv-jnl-summary-list">
          <?php $__currentLoopData = $points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo $point['point_text']; ?></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
    <?php endif; ?>
    <?php if(!empty($stats)): ?>
      <div class="wv-jnl-summary-stats">
        <span class="wv-jnl-summary-label"><?php echo $section['stats_label'] ?: 'Highlights'; ?></span>
        <div class="wv-jnl-summary-stats-grid">
          <?php $__currentLoopData = $stats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="wv-jnl-summary-stat">
              <i data-lucide="<?php echo $stat['stat_icon'] ?: 'circle'; ?>" aria-hidden="true"></i>
              <strong><?php echo $stat['stat_value']; ?></strong>
              <span><?php echo $stat['stat_label']; ?></span>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
    <?php endif; ?>
  </section>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/quick_summary.blade.php ENDPATH**/ ?>