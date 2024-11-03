<!-- resources/views/scrape.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Scraping Test</title>
    @vite(['resources/css/app.css'])
</head>
<body>
<h1 class="logo">Scraper</h1>
<nav>
    <ul>
        <li><a href={{route('html')}}>JSON</a></li>
        <li><a href={{route('json')}}>HTML</a></li>
    </ul>
</nav>
{{--<h2>{{$products[0]}}</h2>--}}
<div class="shoes">
@foreach($products as $product)
{{--    @foreach($product as $nestedProduct)--}}
        <div class="shoe">

{{--            @if($product['image'] == "")--}}
{{--                <p>Image not found</p>--}}
{{--            @else--}}
            <img src="{{$product['image']}}" alt="{{$product['name']}}">
            <h2>{{$product['name']}}</h2>
            <p>{{$product['value']}}</p>
{{--            @endif--}}
{{--            <h2>{{$nestedProduct}}</h2>--}}

        </div>

{{--        <p>{{$nestedProduct['price']}}</p>--}}
{{--        <p>{{$nestedProduct['description']}}</p>--}}
{{--        <img src="{{$nestedProduct['image']}}" alt="{{$nestedProduct['name']}}">--}}
{{--    @endforeach--}}


@endforeach
</div>
</body>
</html>
