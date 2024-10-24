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
<h1>Scraping Test</h1>
{{--<h2>{{$products[0]}}</h2>--}}

@foreach($products as $product)
{{--    @foreach($product as $nestedProduct)--}}
        <div class="shoe">
            <h2>{{$product['name']}}</h2>
            <p>{{$product['value']}}</p>
            <p>{{$product['image']}}</p>
            <img src="{{$product['image']}}" alt="{{$product['name']}}">
{{--            <h2>{{$nestedProduct}}</h2>--}}

        </div>
{{--        <p>{{$nestedProduct['price']}}</p>--}}
{{--        <p>{{$nestedProduct['description']}}</p>--}}
{{--        <img src="{{$nestedProduct['image']}}" alt="{{$nestedProduct['name']}}">--}}
{{--    @endforeach--}}


@endforeach
</body>
</html>
