@extends('layouts.app')

@section('content')
    <section class="inner-page-banner-section">
        <div class="container-fluid">
            <div class="inner-page-banner">
                <div class="inner-banner-over-content d-flex flex-wrap row-gap-4 justify-content-between align-items-center">
                    <div class="col">
                        <h1 class="h2 text-white text-uppercase">
                            @include('partials.page-header')

                        </h1>

                    </div>
                    <div class="col-auto">
                        <div class="breadcrumb-menu">
                            <a href="{{ home_url() }}">Home</a>
                            <span>{{ get_the_title(get_option('page_for_posts', true)) }}</span>
                        </div>
                    </div>
                </div>
                <div class="imgbox">
                    <img src="{!! IMAGE_PATH !!}/images/contact-banner.jpg" alt="" class="object-fit">
                </div>
            </div>
        </div>
    </section>
    <section class="news-filter-section section-gap pt-0" id="news_filter_section">
        <div class="container gutter32">

            @if (!have_posts())
                <x-alert type="warning">
                    {!! __('Sorry, no results were found.', 'sage') !!}
                </x-alert>

                {{-- {!! get_search_form(false) !!} --}}
            @endif
            <div class="row row-gap2 news-box mb-4 pt-5 pb-5">
                @while (have_posts())
                    @php(the_post())
                    @include('partials.content-search')
                @endwhile
            </div>

        </div>
    </section>
@endsection
