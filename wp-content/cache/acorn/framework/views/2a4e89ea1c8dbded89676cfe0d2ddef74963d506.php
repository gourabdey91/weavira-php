<?php
  $categories = $section['moments_categories'] ?? [];

  $momentsData = [
    'categories' => array_map(function ($cat) {
      return [
        'title' => $cat['category_title'] ?? '',
        'description' => $cat['category_description'] ?? '',
        'thumbnail' => $cat['category_thumbnail'] ?? '',
        'slides' => array_map(function ($slide) {
          return [
            'file' => $slide['slide_file'] ?? '',
            'type' => $slide['slide_type'] ?? 'image',
            'alt' => $slide['slide_alt'] ?? '',
          ];
        }, $cat['category_slides'] ?? []),
      ];
    }, $categories),
  ];
?>

<?php if(!empty($categories)): ?>
  <script type="application/json" id="wv-moments-data"><?php echo wp_json_encode($momentsData); ?></script>

  <div class="page-shell">
    <section class="wv-mom-edit" aria-label="Weavira Moments">
      <div class="wv-mom-edit-inner">

        <div class="wv-mom-edit-stage">
          <span class="wv-mom-edit-label">Weavira Moments</span>
          <div class="wv-mom-edit-dots" id="wv-mom-dots" aria-hidden="true"></div>
          <button class="wv-mom-edit-pause" id="wv-mom-pause" type="button" aria-label="Pause slideshow">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" width="14" height="14"><rect x="6" y="4" width="4" height="16"/><rect x="14" y="4" width="4" height="16"/></svg>
          </button>
          <button class="wv-mom-edit-arrow wv-mom-edit-arrow--prev" id="wv-mom-prev" type="button" aria-label="Previous slide">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" width="14" height="14"><polyline points="15 18 9 12 15 6"/></svg>
          </button>
          <button class="wv-mom-edit-arrow wv-mom-edit-arrow--next" id="wv-mom-next" type="button" aria-label="Next slide">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true" width="14" height="14"><polyline points="9 18 15 12 9 6"/></svg>
          </button>
          <div class="wv-mom-edit-track" id="wv-mom-track"></div>
        </div>

        <div class="wv-mom-edit-thumbs" id="wv-mom-thumbs"></div>

      </div>
    </section>
  </div>
<?php endif; ?>
<?php /**PATH /home/u908449413/domains/weavira.com/public_html/wp-content/themes/weavira/resources/views/partials/home/weavira_moments.blade.php ENDPATH**/ ?>