@extends('layouts.app')

@section('content')
   
  <section class="archive-page section-gap">
    <div class="container">
        {{-- <div class="inner-banner-content">
            @include('partials.header-meta')
        </div> --}}
        <div class="row">
            <div class="col-lg-8">
                @while (have_posts())
                    @php(the_post())
                    @includeFirst(array_filter([$singlePartial ?? null, 'partials.content-single']))
                @endwhile
                     
                
            </div>
             
        </div>
      
    </div>
  </section>
 
    

  @endsection
