@extends('client.desktop.layouts.app')

@section('content')
@include('client.desktop.home.banner')

{{-- @include('client.desktop.home.categories') --}}
@include('client.desktop.home.hightlight')

@include('client.desktop.home.outstanding-pr')
@endsection
