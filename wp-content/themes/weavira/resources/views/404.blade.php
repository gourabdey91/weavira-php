@extends('layouts.app')

@section('content')
    @if (!have_posts())
        <section class="wild-wedding-section mb-0 pb-0">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 bg-1 bdr-30 position-relative">
                        <div class="row  justify-content-center">
                            <div class="col-lg-7">
                                <div class="p-4 p-lg-5" data-aos="fade-down">
                                    <h1 class="text-center">{!! get_field('arc_options_404_sub_page_heading', 'option') !!}</h1>
                                    @if (get_field('arc_options_404_page_heading', 'option'))
                                        <h2 class="text-center title mb-lg-5 mb-4">{!! get_field('arc_options_404_page_heading', 'option') !!}</h2>
                                    @endif
                                    {!! get_field('arc_options_404_page_heading_details', 'option') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
@endsection
