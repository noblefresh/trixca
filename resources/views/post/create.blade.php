@extends('layouts.app')
@section('title', 'Create Post')
@section('content')
<nav class="uk-navbar-container" uk-navbar>
  <div class="uk-navbar-left">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('user_dashboard') }}">Home</a></li>
    </ul>
  </div>
  <div class="uk-navbar-right">
    <ul class="uk-navbar-nav">
      <li><a class="uk-button uk-button-small" style="height:3.5em !important;min-height:3.5em !important;"
          href="{{ route('list_post') }}">View Posts</a></li>
    </ul>
  </div>
</nav>
<div class="uk-section uk-section-small uk-section-muted uk-flex uk-flex-center">
  <div class="uk-card uk-card-default uk-card-body uk-width-large">
    <h2 class="uk-card-title">Make Your Public Post now</h2>
    <form method="POST" enctype="multipart/form-data" action="{{route('process_new_post')}}" class="uk-form-stacked">
      @csrf
      <div class="uk-margin">
        <label for="title" class="uk-form-label">
          {{ __('Title') }}
        </label>
        <div class="uk-form-control">
          <input id="title" class="uk-input @error('title') uk-form-danger @enderror" name="title" required autofocus
            value="{{ old('title') }}">
          @error('title')
          <span class="uk-text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="uk-margin">
        <label for="content" class="uk-form-label">
          {{ __('Post Content') }}
        </label>
        <div class="uk-form-control">
          <textarea id="content" class="uk-textarea @error('content') uk-form-danger @enderror" name="content"
            required>{{ old('content') }}</textarea>
          @error('content')
          <span class="uk-text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="uk-margin">
        <label for="image" class="uk-form-label">
          {{ __('Image') }}
        </label>
        <div class="uk-form-control">
          <input name="image" placeholder="Select file" class="uk-input @error('image')  uk-form-danger @enderror"
            id="image" accept=".jpg, .png, .jpeg" type="file" />
          @error('image')
          <span class="uk-text-danger">{{ $message }}</span>
          @enderror
        </div>
      </div>
      <div class="uk-margin">
        <div class="uk-form-control">
          <button type="submit" class="uk-button uk-button-primary">
            {{ __('Create') }}
          </button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection
