<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $tutorial->judul }}</title>
   
    @include('components.pdfcss');
</head>
<body>
    <div class="my-5">
        <h1 class="text-5xl font-bold mb-5">{{ $tutorial->judul }}</h1>
    
        <div class="bg-gray-100 p-4 rounded-lg">
            <p class="text-gray-700"><span class="font-semibold">Kode Mata Kuliah:</span> {{ $tutorial->kode_mata_kuliah }}</p>
            <p class="text-gray-700"><span class="font-semibold">Creator:</span> {{ $tutorial->creator_email }}</p>
        </div>
    
        <div id="sections-container">
            @foreach ($tutorial->details as $detail)
                <div class="section my-5 prose">
                    {!! $detail->content !!}
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
