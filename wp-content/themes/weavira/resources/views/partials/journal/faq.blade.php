@php $faqs = $section['faqs'] ?? []; @endphp

@if(!empty($faqs))
  <section class="wv-jnl-faq">
    <div class="section-heading-center wv-jnl-faq-heading">
      <h2>Frequently Asked Questions</h2>
    </div>
    @foreach($faqs as $faq)
      <div class="wv-jnl-faq-item">
        <button class="wv-jnl-faq-question" type="button" aria-expanded="false">
          <span>{!! $faq['question'] !!}</span>
          <span class="wv-jnl-faq-toggle" aria-hidden="true"></span>
        </button>
        <div class="wv-jnl-faq-answer">
          {!! $faq['answer'] !!}
        </div>
      </div>
    @endforeach
  </section>
@endif
