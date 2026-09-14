<?php $milestones = $section['milestones'] ?? []; ?>

<?php if(!empty($milestones)): ?>
  <section class="wv-jnl-timeline">
    <ol class="wv-jnl-timeline-list">
      <?php $__currentLoopData = $milestones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $milestone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="wv-jnl-timeline-item">
          <span class="wv-jnl-timeline-dot" aria-hidden="true"></span>
          <span class="wv-jnl-timeline-year"><?php echo $milestone['milestone_year']; ?></span>
          <p class="wv-jnl-timeline-desc"><?php echo $milestone['milestone_desc']; ?></p>
        </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
  </section>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/timeline.blade.php ENDPATH**/ ?>