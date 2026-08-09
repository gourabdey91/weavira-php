@if(!empty($section['video_file']))
  <div class="page-shell">
    <div class="story-video-mobile-wrap">
      <section class="craft-video-section">
        <video class="craft-video" autoplay muted loop playsinline>
          <source src="{{ $section['video_file'] }}" type="video/mp4">
        </video>
        <div class="craft-video-overlay"></div>
        @if(!empty($section['heading']))
          <div class="craft-video-text">
            <h2>{!! nl2br(e($section['heading'])) !!}</h2>
          </div>
        @endif
      </section>
      <div class="story-video-spacer" aria-hidden="true"></div>
    </div>
  </div>
@endif
