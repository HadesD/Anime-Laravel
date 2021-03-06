@extends('layouts.app.home')
@section('content')
  <div class="ui dividing red header">
    @lang('home.search')
  </div>
  <div class="ui five special stackable link cards">
    @foreach ($results as $result)
      <a class="ui red card" href="{{ $result->getRoute() }}">
        @if (strlen($result->thumbnail) > 0)
          <div class="blurring dimmable image" href="{{ $result->getRoute() }}" style="max-height:150px;overflow:hidden;">
            <div class="ui dimmer">
              <div class="content">
                <div class="center">
                  <h4 class="ui inverted header">
                    @lang('watch.lastest'): {{ $result->name }}
                  </h4>
                  <div class="ui inverted button">
                    @lang('watch.watchnow')
                  </div>
                </div>
              </div>
            </div>
            <img class="image" src="{{ $result->thumbnail }}" />
          </div>
        @endif
        <div class="content">
          <div class="header">
            {{ $result->name }}
          </div>
        </div>
        <div class="extra content">
          <i class="lightning icon"></i>
          @lang('watch.views'): {{ $result->views }}
        </div>
      </a>
    @endforeach
  </div>
  {{ $results->links('vendor.pagination.semantic-ui') }}
@endsection
