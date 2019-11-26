@extends('layouts.master')   {{-- layout디렉터리에 있는 master를 상속--}}

@section('content')
  <h1> 자식이야 잘 받아.</h1>
@endsection

@section('style')
  <style>
    body {background: green; color:white;}
  </style>
@stop     {{-- endsection의 역할 --}}


@section('script')      {{-- 먼저 실행되는 @section('script')--}}
@parent                 {{-- 부모설정 -- }}
  <script>
    alert('자식의 스크립트 섹션임');
  </script>
@stop

@section('foot')
  @include('subviews.footer')
@stop
