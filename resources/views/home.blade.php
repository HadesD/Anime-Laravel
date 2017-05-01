@extends('layouts.app.home')
@push('css')
  <link rel="stylesheet" href="{{ asset('libs/OwlCarousel/owl-carousel/owl.carousel.css') }}" />
  <link rel="stylesheet" href="{{ asset('libs/OwlCarousel/owl-carousel/owl.theme.css') }}" />
  <link href="{{ asset('libs/OwlCarousel/owl-carousel/owl.transitions.css') }}" rel="stylesheet" />
  <style media="screen">
  #owl-demo .owl-item div{
    padding:5px;
    max-height: 500px;
  }
  #owl-demo .owl-item img{
    display: block;
    width: 100%;
    height: auto;
    margin-top: -35%;
    -webkit-border-radius: 3px;
    -moz-border-radius: 3px;
    border-radius: 3px;
  }
  </style>
@endpush
@section('content')
  <div id="owl-demo" class="owl-carousel owl-theme">
    @foreach ($carousel as $film)
      <div class="item">
        <a href="{{ route('watch.film', ['film_id' => $film->id, 'film_slug' => $film->slug]) }}">
          <img src="{{ $film->thumbnail }}" />
        </a>
      </div>
    @endforeach
  </div>
  <h3 class="ui dividing red header">
    Dividing Header
  </h3>
  <div class="ui four cards">
    @foreach ($newestList as $newest)
      <div class="ui red card">
        <a class="image" style="max-height: 185px;overflow: hidden;" href="{{ route('watch.episode', ['film_id' => $newest->film_id, 'episode_id' => $newest->id]) }}">
          <img src="{{ $newest->film->thumbnail }}">
        </a>
        <div class="content">
          <a class="header" href="{{ route('watch.episode', ['film_id' => $newest->film_id, 'episode_id' => $newest->id]) }}">
            {{ $newest->film->name }}
          </a>
          <div class="meta">
            <a>{{ print_r($newest) }}</a>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endsection
@push('js')
  <script type="text/javascript" src="{{ asset('libs/OwlCarousel/owl-carousel/owl.carousel.js') }}"></script>
  <script type="text/javascript">
    $(document).ready(function() {
      $("#owl-demo").owlCarousel({
        autoPlay : 3000,
        loop: true,
        stopOnHover : true,
        //navigation:true,
        paginationSpeed : 1000,
        goToFirstSpeed : 2000,
        singleItem : true,
        autoHeight : true,
        transitionStyle:"fade"
      });
    });
  </script>
@endpush
