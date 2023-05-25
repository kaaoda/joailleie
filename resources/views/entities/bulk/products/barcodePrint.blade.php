<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <style>
      body {
          margin: 0;
          box-shadow: 0;
          padding: 0;
        }
      div {
        background: white;
        display: flex;
        justify-content: space-between;
        margin: 0;
        padding: 0;
        border: 1px solid #fff;
        padding: 0;
        width: 8.2cm;
        height: 3.7cm;
        padding-left:1.2cm;
        padding-top: 0.05cm
      }
      section.face {
        margin: 0;
        padding: 0.1cm;
        height: 33.33%;
        width: 2cm;
        box-sizing: border-box;
        display: flex;
        flex-direction: row-reverse;

      }
      section.side {
        margin: 0;
        padding: 0;
        width: 2cm;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
        
      }
      img.logo {
        width: 65%;
        display: block;
        transform: rotate(90deg);
      }
      img.barcode
       {
        /* width: 100%;
        height: 40%; */
        display: block;
      }
      strong
      {
        font-size: 0.3cm;
        padding-top: 0cm;
      }
      strong.weight {
        transform: rotate(90deg);


      }
      strong.cost {
        padding-top:0cm;
        font-size: 0.25cm
        
      }

      @media print {
        body,
        page {
          margin: 0;
          box-shadow: 0;
          width: 8.2cm;
          height: 3.7cm;
        }
        strong{
            font-size: 0.3cm;
            padding-top: 0cm;
        }
      }
    </style>
  </head>
  <body>
    <div size="A4" layout="landscape">
      <section class="side">
        <section class="face"></section>
        <section class="face">
            <img class="logo" src="{{asset('assets/img/barcode/color.png')}}?e=4" />
            <strong class="weight">w:{{$products[0]['weight']}}</strong>
        </section>
        <section style="flex-direction: column;" class="face">
            <img class="barcode" src="data:image/png;base64,{{$products[0]['barcode_image']}}" alt="barcode" />
            {{-- {!!$products[0]['barcode_image']!!} --}}
            <strong class="cost">{{$products[0]['barcode']}}<br />{{$products[0]['lowest_manufacturing_value_for_sale']}} --- {{$products[0]['kerat']}}k</strong>
        </section>
      </section>
      @isset($products[1])
      <section class="side">
        <section class="face">
            <img class="logo" src="{{asset('assets/img/barcode/color.png')}}?e=4" />
            <strong class="weight">w:{{$products[1]['weight']}}</strong>
        </section>
        <section style="flex-direction: column;" class="face">
            <img class="barcode" src="data:image/png;base64,{{$products[1]['barcode_image']}}" alt="barcode" />
            {{-- {!!$products[1]['barcode_image']!!} --}}
            <strong class="cost">{{$products[1]['barcode']}}<br />{{$products[1]['lowest_manufacturing_value_for_sale']}} --- {{$products[1]['kerat']}}k</strong>
        </section>
        <section class="face"></section>
      </section>
      @else
      <section class="side">
        <section class="face">
            <img class="logo" src="{{asset('assets/img/barcode/color.png')}}?e=4" />
            <strong class="weight">w:{{$products[0]['weight']}}</strong>
        </section>
        <section style="flex-direction: column;" class="face">
            <img class="barcode" src="data:image/png;base64,{{$products[0]['barcode_image']}}" alt="barcode" />
            {{-- {!!$products[0]['barcode_image']!!} --}}
            <strong class="cost">{{$products[0]['barcode']}}<br />{{$products[0]['lowest_manufacturing_value_for_sale']}} --- {{$products[0]['kerat']}}k</strong>
        </section>
        <section class="face"></section>
      </section>
      @endisset
      </div>
      
      
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->
    <script>
    //   html2canvas(document.getElementById('page')).then(function(canvas) {
    //     document.body.appendChild(canvas);
    // });
window.addEventListener('load', function () {
  window.print();
  //window.onafterprint = function(event) { window.close() };
})

    </script>
  </body>
</html>
