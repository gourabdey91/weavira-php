<?php $steps = $section['steps'] ?? []; ?>

<?php if(!empty($steps)): ?>
  <section class="wv-jnl-process">
    <ol class="wv-jnl-process-list">
      <?php $__currentLoopData = $steps; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $step): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li class="wv-jnl-process-step">
          <span class="wv-jnl-process-num"><?php echo $i + 1; ?></span>
          <h3><?php echo $step['step_label']; ?></h3>
          <p><?php echo $step['step_desc']; ?></p>
        </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
  </section>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/process_steps.blade.php ENDPATH**/ ?>