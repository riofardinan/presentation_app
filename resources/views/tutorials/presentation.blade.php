@extends('layouts.app')

@section('title', $title)

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/github-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>

    <style>
        .ql-code-block-container {
            background-color: #0d1117 !important;
            /* color: white; */
            padding: 15px;
            border-radius: 8px;
            overflow-x: auto;
            font-family: "Fira Code", monospace;
        }

        .ql-code-block-container select {
            display: none !important;
        }

        ol li[data-list="bullet"] {
            list-style-type: disc;
        }

        .ql-align-right {
            text-align: end;
        }

        .ql-align-justify{
            text-align: justify;
        }

        .ql-align-center{
            text-align: center;
        }

        h1 {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 16px;
        }

        h2 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        img {
            display: block;
            margin: 10px auto;
            max-width: 60% !important;
            height: auto;
        }

        /* Video youtube */
        iframe {
            display: block;
            margin: 10px auto;
            width: 80% !important;
            max-width: 560px;
            aspect-ratio: 16 / 9;
            height: auto;
        }

        a {
            color: blue;
            text-decoration: underline;
            cursor: pointer;
        }

        a:visited {
            color: purple;
        }

        a:hover {
            color: red;
            text-decoration: underline;
        }

        a:active {
            color: darkred;
        }
    </style>
@endpush

@section('content')
<div class="container w-3/5 mx-auto my-5">
    <h3 class="text-5xl font-bold mb-5">{{ $tutorial->judul }}</h3>

    <div class="bg-gray-100 p-4 rounded-lg mb-5">
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

@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const currentSlug = window.location.pathname.split("/").pop();

            Echo.channel("detail-channel")
                .listen(".detail-updated", (event) => {
                    const eventSlug = event.url_presentation.split("/").pop();
                    // console.log("Perubahan terdeteksi:", eventSlug);
                    // console.log("Url saat ini:", currentSlug);

                    if (eventSlug === currentSlug) {
                        // console.log("Slug cocok, me-refresh halaman...");
                        location.reload();
                    }
                });
                
            document.querySelectorAll(".ql-code-block-container .ql-code-block").forEach((block) => {
                hljs.highlightElement(block);
            });
        });
    </script>
@endpush