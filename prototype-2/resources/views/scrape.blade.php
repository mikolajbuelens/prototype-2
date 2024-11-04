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

<div class="shoes">
@foreach($products as $product)

        <div class="shoe">
            <img src="{{$product['image']}}" alt="{{$product['name']}}">
            <h2>{{$product['name']}}</h2>
            <p>{{$product['value']}}</p>

        </div>




@endforeach
</div>
</body>
</html>
