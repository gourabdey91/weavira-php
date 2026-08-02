<?php if(!empty($section['video_file'])): ?>
  <div class="page-shell">
    <div class="story-video-mobile-wrap">
      <section class="craft-video-section">
        <video class="craft-video" autoplay muted loop playsinline>
          <source src="<?php echo e($section['video_file']); ?>" type="video/mp4">
        </video>
        <div class="craft-video-overlay"></div>
        <?php if(!empty($section['heading'])): ?>
          <div class="craft-video-text">
            <h2><?php echo nl2br(e($section['heading'])); ?></h2>
          </div>
        <?php endif; ?>
      </section>
      <div class="story-video-spacer" aria-hidden="true"></div>
    </div>
  </div>
<?php endif; ?>
<?php /**PATH C:\Users\Admin\Local Sites\weavira\app\public\wp-content\themes\weavira\resources\views/partials/home/craft_video.blade.php ENDPATH**/ ?>