<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1>여기가 새로운 뷰이여...잘봐!</h1>
    <!-- 값에 greeting가 있으면 greeting를 출력하고
                         없으면 안녕하세요를 출력  -->
    <h1> {{ $greeting ?? '안녕하세요'}}
        {{ $name }}
    </h1>
    {{-- 주석이에요~ --}}

    {{-- 대입식인데 되는 이유는 count($items)가 1이상이면 TRUE이기 때문에 작동 됨 --}}
    @if($itemCount = count($items))
      <p>{{$itemCount}} 종류의 과일을 판매중 </p>
    @else
      <p>완판!</p>
    @endif

  </body>
</html>
