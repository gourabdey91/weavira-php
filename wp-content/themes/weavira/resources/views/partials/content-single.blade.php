@php
  $thumbnailId = get_post_thumbnail_id();
  $imageCaption = $thumbnailId ? wp_get_attachment_caption($thumbnailId) : '';
@endphp

<article @php(post_class('h-entry'))>

  @if (has_post_thumbnail())
    <figure class="single-featured-image">
      {!! get_the_post_thumbnail(get_the_ID(), 'full', [
        'class' => 'single-featured-image-img',
        'alt' => esc_attr(get_the_title()),
        'loading' => 'eager',
      ]) !!}

      <figcaption class="single-featured-image-caption">
        {!! $imageCaption  !!}
      </figcaption>
    </figure>
  @endif

  <div class="e-content">
    @php(the_content())
  </div>

</article>
