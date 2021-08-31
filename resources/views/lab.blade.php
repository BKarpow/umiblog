<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Lab Test</title>
  <style>
    body{
      display: flex;
      flex-wrap: wrap;
      column-gap: .7rem;
      justify-content: center;
      box-sizing: border-box;
      padding: 0;
      margin: 0;
      background: #383838;
      color: aliceblue;
      font-family: sans-serif;
    }
    .text-box{
      width: 200px;
      height: auto;
      overflow: auto;
      padding: .7rem;
      margin: .7rem;
      border: 1px solid #fff;
      border-radius: 9px;
    }
    .avatar{
      clip-path: circle(50px);
    }
  </style>
</head>
<body>
  <div class="text-box">
    fdfnfh
    <img src="{{route('noavatar', ['name'=> 'Bogdan'])}}" class="avatar" alt="">
  </div>

  @foreach ($data as $item)
      <div class="text-box">
        {{$item}}
      </div>
      <!-- /.text-box -->
  @endforeach

  <div id="scroll" class="sroll-me"></div>
  <!-- /.sroll-me -->

  <script>

function isVisible(elem) {
  let coords = elem.getBoundingClientRect();
  let windowHeight = document.documentElement.clientHeight;
  // верхний край элемента виден?
  let topVisible = coords.top > 0 && coords.top < windowHeight;
  // нижний край элемента виден?
  let bottomVisible = coords.bottom < windowHeight && coords.bottom > 0;
  return {"top":topVisible, "bottom":bottomVisible};
}

   
    document.addEventListener('DOMContentLoaded', () => {
      const $elScroll = document.querySelector('.sroll-me');
      if ($elScroll) {
        document.addEventListener('scroll', () => {
          console.log( isVisible($elScroll) );
        });
      }
    });
  </script>
</body>
</html>