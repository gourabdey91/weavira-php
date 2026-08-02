<?php
  $storyAttrs = [
    'design' => ['label' => 'DESIGN', 'value' => $attrs['design'] ?? ''],
    'weave' => ['label' => 'WEAVE', 'value' => $attrs['weave'] ?? ''],
    'cluster' => ['label' => 'CLUSTER', 'value' => $attrs['cluster'] ?? ''],
    'loom-type' => ['label' => 'LOOM TYPE', 'value' => $attrs['loom-type'] ?? ''],
  ];
  $storyAttrs = array_filter($storyAttrs, fn($row) => $row['value'] !== '');
?>

<?php if(!empty($storyAttrs)): ?>
  <section class="design-story-section">
    <div class="design-story-inner">
      <?php $__currentLoopData = $storyAttrs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="design-story-attr">
          <span class="design-story-attr-icon" aria-hidden="true">
            <?php switch($key):
              case ('design'): ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                  <rect x="3" y="3" width="8" height="8"/><rect x="13" y="3" width="8" height="8"/>
                  <rect x="13" y="13" width="8" height="8"/><rect x="3" y="13" width="8" height="8"/>
                </svg>
                <?php break; ?>
              <?php case ('weave'): ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                  <circle cx="12" cy="4" r="1.8"/><circle cx="4" cy="12" r="1.8"/><circle cx="12" cy="20" r="1.8"/>
                  <circle cx="20" cy="12" r="1.8"/><circle cx="12" cy="12" r="1.8"/>
                  <line x1="12" y1="5.8" x2="5.8" y2="12"/><line x1="5.8" y1="12" x2="12" y2="18.2"/>
                  <line x1="12" y1="18.2" x2="18.2" y2="12"/><line x1="18.2" y1="12" x2="12" y2="5.8"/>
                  <line x1="12" y1="5.8" x2="12" y2="10.2"/><line x1="5.8" y1="12" x2="10.2" y2="12"/>
                  <line x1="18.2" y1="12" x2="13.8" y2="12"/><line x1="12" y1="18.2" x2="12" y2="13.8"/>
                </svg>
                <?php break; ?>
              <?php case ('cluster'): ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                  <polygon points="12,2.5 20,7 20,17 12,21.5 4,17 4,7"/>
                  <circle cx="12" cy="12" r="2.5"/>
                  <line x1="12" y1="2.5" x2="12" y2="9.5"/><line x1="12" y1="14.5" x2="12" y2="21.5"/>
                  <line x1="20" y1="7" x2="14" y2="10.5"/><line x1="10" y1="13.5" x2="4" y2="17"/>
                  <line x1="4" y1="7" x2="10" y2="10.5"/><line x1="14" y1="13.5" x2="20" y2="17"/>
                </svg>
                <?php break; ?>
              <?php default: ?>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2" aria-hidden="true">
                  <rect x="3" y="3" width="18" height="2" rx="0.4"/>
                  <rect x="3" y="19" width="18" height="2" rx="0.4"/>
                  <line x1="7"    y1="5"  x2="7"    y2="19"/>
                  <line x1="10.5" y1="5"  x2="10.5" y2="19"/>
                  <line x1="13.5" y1="5"  x2="13.5" y2="19"/>
                  <line x1="17"   y1="5"  x2="17"   y2="19"/>
                  <path d="M3 10 Q7 8.5 10.5 10 Q13.5 11.5 17 10 Q20 8.5 21 10"/>
                  <path d="M3 14 Q7 15.5 10.5 14 Q13.5 12.5 17 14 Q20 15.5 21 14"/>
                </svg>
            <?php endswitch; ?>
          </span>
          <span class="design-story-attr-label"><?php echo e($row['label']); ?></span>
          <span class="design-story-attr-value"><?php echo e($row['value']); ?></span>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div><!-- /.design-story-inner -->
  </section>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/product/design-story-row.blade.php ENDPATH**/ ?>