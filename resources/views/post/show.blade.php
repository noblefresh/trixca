@extends('layouts.app')
@section('title', 'View Post')
@section('content')
<nav class="uk-navbar-container" uk-navbar>
  <div class="uk-navbar-left">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('admin_dashboard') }}">Home</a></li>
    </ul>
  </div>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('create_post') }}">Create</a></li>
    </ul>
  </div>
</nav>
<div class="uk-section uk-section-small uk-section-muted uk-flex uk-flex-center">
  <div class="uk-card uk-card-default uk-card-body uk-padding-remove uk-width-large">
    <div class="uk-card-header uk-padding-small">
      <div class="uk-grid-small uk-flex-middle" uk-grid>
        <div class="uk-width-expand">
          <h4 class="uk-margin-remove-bottom">{{$post->title}}</h4>
          <p class="uk-text-meta uk-margin-remove-top">Written @if($post->user != null) by
            {{$post->user->last_name." ".$post->user->first_name}} @endif
            on <time
              datetime="{{$post->created_at->toDateTimeString()}}">{{$post->created_at->toDayDateTimeString()}}</time>
          </p>
        </div>
      </div>
    </div>
    @if($post->image != null)
    <div uk-height-viewport="offset-bottom: 70"
      class="uk-flex uk-flex-center uk-flex-middle uk-background-cover uk-light"
      data-src="{{URL::to("/image/post/".$post->image)}}" uk-img>
    </div>
    @endif
    <div class="uk-card-body">
      <p>{{$post->content}}</p>
    </div>
    <div class="uk-card-footer uk-flex uk-flex-between">
      <a href="{{url()->previous()}}" class="uk-button uk-button-text">Go Back</a>
      <div>
        <a href="{{route('edit_post',['id' => $post->id])}}" class="uk-button uk-button-text blue-text">Edit</a>
        <a href="{{route('delete_post',['id' => $post->id])}}" class="uk-button uk-button-text red-text">Delete Post</a>
        @if($post->image != null)
        <a href="{{route('delete_post_image',['id' => $post->id])}}" class="uk-button uk-button-text red-text">Delete Image</a>
        @endif
      </div>
    </div>
  </div>
</div>
@endsection
