@extends('layouts.app')

@section('title', $title)

@push('styles')
    {{-- Highlight.js (Untuk Syntax Highlighting) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/atom-one-dark.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>

    {{-- Quill CSS & JS --}}
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>

    {{-- KaTeX (Untuk Rumus Matematika) --}}
    <script src="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/katex@0.16.9/dist/katex.min.css" />
 
    <style>
        .ql-toolbar {
            position: sticky;
            top: 4rem;
            background: white;
            z-index: 10;
            border-bottom: 1px solid #ddd;
        }

        /* Styling untuk Quill */
        .ql-editor {
            font-size: 14px;
            line-height: 1.8;
        }

        /* Header Styles */
        .ql-editor h1 {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 16px;
        }

        .ql-editor h2 {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 12px;
        }

        .ql-editor img {
            display: block;
            margin: 10px auto;
            max-width: 60% !important;
            height: auto;
        }

        /* Video youtube */
        .ql-editor iframe {
            display: block;
            margin: 10px auto;
            width: 80% !important;
            max-width: 560px;
            aspect-ratio: 16 / 9;
            height: auto;
        }

        /* Dropdown program language */
        .ql-code-block-container .ql-ui {
            color: #333; 
            background-color: #fff;
            padding: 4px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
    </style>
@endpush

@section('content')
    @include('components.navbar')
    <div class="container w-3/5 mx-auto my-20">
        <h1 class="text-5xl font-bold mb-5">{{ $tutorial->judul }}</h1>

        <form action="{{ route('details.store', $tutorial->id) }}" method="POST">
            @csrf
            <div id="sections-container">
                @foreach ($details as $index => $detail)
                    <div class="section relative" id="section-{{ $index }}">
                        <div id="editor-container-{{ $index }}"
                            @if ($detail->status != 'show') style="opacity:0.4;pointer-events:none"
                        @else
                        style="opacity:1;pointer-events:auto" @endif>
                        </div>
                        <input type="hidden" name="content[]" id="input-{{ $index }}"
                            value="{{ $detail->content }}">
                        <input type="hidden" name="status[]" id="status-{{ $index }}" value="{{$detail->status}}">

                        <div class="section-controls top-0 end-0 absolute flex flex-col gap-y-2" style="transform: translateX(120%);">
                            <button class="bg-yellow-500 cursor-pointer hover:bg-yellow-600 text-white p-2 rounded"
                                onclick="toggleSection('section-{{ $index }}')">
                                @if ($detail->status == 'show')
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                    </svg>
                                @endif
                            </button>
                            <button class="bg-gray-500 cursor-pointer hover:bg-gray-600 text-white p-2 rounded"
                                onclick="moveSectionUp('section-{{ $index }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                </svg>
                            </button>
                            <button class="bg-gray-500 cursor-pointer hover:bg-gray-600 text-white p-2 rounded"
                                onclick="moveSectionDown('section-{{ $index }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>

                            <button class="bg-red-500 cursor-pointer hover:bg-red-600 text-white p-2 rounded"
                                onclick="removeSection('section-{{ $index }}')">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-5">
                <button type="button" class="bg-transparent hover:bg-sky-700 text-sky-700 font-semibold hover:text-white py-2 px-4 border border-sky-700 hover:border-transparent rounded cursor-pointer" onclick="addSection()">+ Tambah Section</button>
                <button type="submit" class="bg-sky-500 hover:bg-sky-700 text-white font-bold py-2 px-4 rounded cursor-pointer">Simpan</button>
            </div>
        </form>

    </div>
    
    <script>
        let editors = [];
        let sectionCounter = {{ count($details) > 0 ? count($details) : 1 }};

        function initEditor(index, content = '') {
            let editorContainerId = `editor-container-${index}`;
            let inputId = `input-${index}`;

            let editor = new Quill(`#${editorContainerId}`, {
                theme: 'snow',
                modules: {
                    syntax: true,
                    toolbar: [
                        ['bold', 'italic'],
                        [{
                            color: []
                        }, {
                            background: []
                        }],
                        [{
                            script: 'sub'
                        }, {
                            script: 'super'
                        }],
                        [{
                            header: 1
                        }, {
                            header: 2
                        }],
                        [{
                            list: 'ordered'
                        }, {
                            list: 'bullet'
                        }],
                        ['blockquote', 'code-block'],
                        [{
                            align: []
                        }],
                        ['link', 'image', 'video', 'formula'],
                        ['clean']
                    ]
                }
            });

            editor.root.innerHTML = content;
            editor.on('text-change', function() {
                document.getElementById(inputId).value = editor.root.innerHTML;
            });

            editors[index] = editor;
        }

        function addSection(content = '') {
            let sectionId = `section-${sectionCounter}`;
            let editorContainerId = `editor-container-${sectionCounter}`;
            let inputId = `input-${sectionCounter}`;

            let sectionDiv = document.createElement("div");
            sectionDiv.classList.add("section");
            sectionDiv.classList.add("relative");
            sectionDiv.setAttribute("id", sectionId);
            sectionDiv.innerHTML = `
                <div id="${editorContainerId}"></div>
                <input type="hidden" name="content[]" id="${inputId}">
                <input type="hidden" name="status[]" id="status-${sectionCounter}" value="show">
                <div class="section-controls top-0 end-0 absolute flex flex-col gap-y-2" style="transform: translateX(120%);">
                    <button class="bg-yellow-500 cursor-pointer hover:bg-yellow-600 text-white p-2 rounded" onclick="toggleSection('${sectionId}')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                    </button>
                    <button class="bg-gray-500 cursor-pointer hover:bg-gray-600 text-white p-2 rounded" onclick="moveSectionUp('${sectionId}')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                        </svg>

                    </button>
                    <button class="bg-gray-500 cursor-pointer hover:bg-gray-600 text-white p-2 rounded" onclick="moveSectionDown('${sectionId}')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                    <button class="bg-red-500 cursor-pointer hover:bg-red-600 text-white p-2 rounded" onclick="removeSection('${sectionId}')">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </button>
                </div>
            `;

            document.getElementById("sections-container").appendChild(sectionDiv);
            initEditor(sectionCounter);

            sectionCounter++;
        }

        function toggleSection(sectionId) {
            event.preventDefault();

            let section = document.getElementById(sectionId);

            let button = section.querySelector("button[onclick^='toggleSection']");
            let statusInput = section.querySelector(`#status-${sectionId.split('-')[1]}`);
            let editorContainer = section.querySelector(`#editor-container-${sectionId.split('-')[1]}`);
            
            let currentStatus = statusInput.value;

            if (currentStatus === "show") {
                statusInput.value = "hide";

                editorContainer.style.opacity = "0.4";
                editorContainer.style.pointerEvents = "none";

                button.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                    </svg>
                `;
            } else {
                statusInput.value = "show";

                editorContainer.style.opacity = "1";
                editorContainer.style.pointerEvents = "auto";

                button.innerHTML = `
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                `;
            }
        }

        function moveSectionUp(sectionId) {
            event.preventDefault();
            let section = document.getElementById(sectionId);
            let prevSection = section.previousElementSibling;
            if (prevSection) {
                section.parentNode.insertBefore(section, prevSection);
            }
        }

        function moveSectionDown(sectionId) {
            event.preventDefault();
            let section = document.getElementById(sectionId);
            let nextSection = section.nextElementSibling;
            if (nextSection) {
                section.parentNode.insertBefore(nextSection, section);
            }
        }

        function removeSection(sectionId) {
            event.preventDefault();
            let section = document.getElementById(sectionId);
            section.remove();
        }

        @if (count($details) > 0)
            @foreach ($details as $index => $detail)
                initEditor({{ $index }}, {!! json_encode($detail->content) !!});
            @endforeach
        @else
            addSection();
        @endif

        document.addEventListener("DOMContentLoaded", function() {
            const tooltips = {
                "bold": "Tebalkan teks (Ctrl+B)",
                "italic": "Miringkan teks (Ctrl+I)",
                "color": "Ubah warna teks",
                "background": "Ubah warna latar belakang",
                "script[sub]": "Subscript",
                "script[super]": "Superscript",
                "header[1]": "Judul 1 (H1)",
                "header[2]": "Judul 2 (H2)",
                "list[ordered]": "Daftar bernomor",
                "list[bullet]": "Daftar tanpa nomor",
                "blockquote": "Kutipan",
                "code-block": "Blok Kode",
                "align": "Atur perataan teks",
                "link": "Tambahkan tautan",
                "image": "Tambahkan gambar",
                "video": "Tambahkan video",
                "formula": "Tambahkan rumus matematika",
                "clean": "Hapus format"
            };

            document.querySelectorAll('.ql-toolbar button, .ql-toolbar span.ql-picker').forEach(button => {
                let format = button.className.match(/ql-(\w+)/);
                if (format) {
                    let key = format[1];

                    let value = button.getAttribute('value');
                    if (value) {
                        key += `[${value}]`;
                    }

                    if (tooltips[key]) {
                        button.setAttribute('title', tooltips[key]);
                    }
                }
            });

            let codeBlockButton = document.querySelector('.ql-code-block');
            if (codeBlockButton) {
                codeBlockButton.setAttribute('title', 'Blok Kode');
            }
        });
    </script>
@endsection