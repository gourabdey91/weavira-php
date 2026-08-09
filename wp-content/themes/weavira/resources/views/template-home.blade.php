{{--
  Template Name: Home Template
--}}

@extends('layouts.app')

@section('content')
  @foreach($sections as $section)
    @includeFirst(['partials.home.' . $section['acf_fc_layout'], 'partials.home.missing'], ['section' => $section])
  @endforeach
@endsection
