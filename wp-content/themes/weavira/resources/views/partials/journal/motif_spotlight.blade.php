<section class="wv-jnl-motif">
  @if(!empty($section['motif_image']))
    <div class="wv-jnl-motif-media">
      <img src="{!! $section['motif_image'] !!}" alt="{!! $section['motif_name'] !!}" loading="lazy">
    </div>
  @endif
  <div class="wv-jnl-motif-body">
    @if(!empty($section['motif_name']))
      <h3>{!! $section['motif_name'] !!}</h3>
    @endif
    @if(!empty($section['motif_desc']))
      <p>{!! $section['motif_desc'] !!}</p>
    @endif
  </div>
</section>
