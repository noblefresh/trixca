@extends('errors::layout')

@section('title', __('Unauthorized'))
@section('code', '401')
@section('message', __('Unauthorized, Are you sure you are logged in!'))
