@extends('layouts.master')

@section('title')
    Beranda
@endsection

@section('content')
    @include('pages.home.variable')
@endsection

@section('footscript')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script>
    $(document).ready(function() {
  $('#text').summernote();
});
    </script>
@endsection

@section('modal')

@endsection