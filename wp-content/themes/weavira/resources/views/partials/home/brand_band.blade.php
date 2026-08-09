@php $logo = $section['logo_override'] ?: get_field('arc_option_logo', 'option'); @endphp

@if($logo)
  <section class="wv-brand-band">
    <img src="{{ $logo }}" alt="Weavira &mdash; Wear Your Legacy" class="wv-brand-band-logo" loading="lazy">
  </section>
@endif
