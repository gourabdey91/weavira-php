<?php
  $refs = array_values(array_filter(wp_list_pluck($section['references'] ?? [], 'reference_text')));
  $columns = !empty($refs) ? array_chunk($refs, (int) ceil(count($refs) / 3)) : [];
?>

<?php if(!empty($refs)): ?>
  <section class="wv-jnl-references">
    <h3>References</h3>
    <div class="wv-jnl-references-grid">
      <?php $__currentLoopData = $columns; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $column): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <ul>
          <?php $__currentLoopData = $column; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ref): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo $ref; ?></li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </section>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/journal/references.blade.php ENDPATH**/ ?>