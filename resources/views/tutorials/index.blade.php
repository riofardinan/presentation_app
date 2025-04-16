@extends('layouts.app')

@section('title', $title)

@push('styles')
    <style>
        [x-cloak] { display: none !important; }
    </style>
@endpush

@push('scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
@endpush

@section('content')
    @include('components.navbar')
    <div class="p-10 pb-0">
        <div class="flex my-15">
            {{-- List Tutorial --}}
            <div class="w-3/4 overflow-none pr-10">
                <h2 class="text-xl font-bold mb-4">Daftar Tutorial</h2>
                <div class="space-y-6">
                    @if($tutorials->isEmpty())
                    <div class="text-center py-10">
                        <h2 class="text-gray-700 text-xl font-semibold">Belum ada tutorial yang tersedia.</h2>
                        <p class="text-gray-500">Silakan tambahkan tutorial baru atau kembali nanti.</p>
                    </div>
                    @else
                        @foreach($tutorials as $tutorial)
                            <div class="bg-white p-6 shadow-lg rounded-2xl border border-gray-200 hover:shadow-xl transition-all">
                                <div class="flex justify-between items-center">
                                    <div>
                                        {{-- <p class="text-xl font-semibold text-blue-600">{{ $tutorial->judul }}</p> --}}
                                        <a href="{{ route('details.index', $tutorial->finished) }}" 
                                        class="text-xl font-semibold text-sky-600 hover:underline">
                                            {{ $tutorial->judul }}
                                        </a>
                                        <p class="text-gray-500 text-sm mt-1">Kode Matkul: <span class="font-medium">{{ $tutorial->kode_mata_kuliah }}</span></p>
                                        <p class="text-gray-500 text-sm">Creator: <span class="font-medium">{{ $tutorial->creator_email }}</span></p>
                                        <p class="text-gray-500 text-xs mt-2">Created: {{ $tutorial->created_at->diffForHumans() }} | Updated: {{ $tutorial->updated_at->diffForHumans() }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <div x-data="{ open: false }">
                                            {{-- Tombol Edit --}}
                                            <button @click="open = true"
                                                    class="p-2 rounded-full bg-sky-500 hover:bg-sky-600 text-white transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                                </svg>
                                            </button>
                                        
                                            {{-- Modal --}}
                                            <div x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-800/40 z-50">
                                                <div @click.away="open = false" class="bg-white p-6 rounded-xl shadow-lg max-w-md w-full">
                                                    <h2 class="text-xl font-semibold text-gray-700">Edit Tutorial</h2>
                                                    <form action="{{ route('tutorials.update', $tutorial->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                        
                                                        {{-- Input Judul --}}
                                                        <div class="mt-4">
                                                            <label class="text-gray-600">Judul</label>
                                                            <input type="text" name="judul" value="{{ $tutorial->judul }}" required
                                                                class="w-full mt-1 p-2 border rounded-md focus:ring focus:ring-blue-300">
                                                        </div>
                                        
                                                        {{-- Input Kode Mata Kuliah --}}
                                                        <div class="mt-4">
                                                            <label class="text-gray-600">Kode Mata Kuliah</label>
                                                            
                                                            <select name="kode_mata_kuliah" id="editKodeMataKuliah" class="w-full mt-1 p-2 border rounded-md focus:ring focus:ring-blue-300" required>
                                                                <option value="" disabled selected>-- Pilih Mata Kuliah --</option>
                                                                @foreach ($matkul as $mk)
                                                                    <option value="{{ $mk['kdmk'] }}" 
                                                                        {{ $tutorial->kode_mata_kuliah == $mk['kdmk'] ? 'selected' : '' }}>
                                                                        {{ $mk['kdmk'] }} - {{ $mk['nama'] }}
                                                                    </option>
                                                                @endforeach
                                                            </select>                                                    
                                                        </div>
                                        
                                                        {{-- Tombol Simpan & Batal --}}
                                                        <div class="mt-6 flex justify-end space-x-2">
                                                            <button type="button" @click="open = false"
                                                                    class="px-4 py-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">
                                                                Batal
                                                            </button>
                                                            <button type="submit"
                                                                    class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                                                                Simpan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                        
                                        {{-- Tombol Delete --}}
                                        <div x-data="{ open: false }">
                                            {{-- Tombol Hapus --}}
                                            <button @click="open = true"
                                                    class="p-2 rounded-full bg-red-500 hover:bg-red-600 text-white transition-all">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        
                                            {{-- Modal Konfirmasi --}}
                                            <div x-show="open" x-cloak class="fixed inset-0 flex items-center justify-center bg-gray-800/40 z-50">
                                                <div @click.away="open = false" class="bg-white p-6 rounded-xl shadow-lg max-w-md w-full">
                                                    <h2 class="text-lg font-semibold text-gray-700">Konfirmasi Hapus</h2>
                                                    <p class="text-gray-600 mt-2">Apakah Anda yakin ingin menghapus tutorial ini?</p>
                                        
                                                    {{-- Tombol Aksi --}}
                                                    <div class="mt-6 flex justify-end space-x-2">
                                                        <button @click="open = false"
                                                                class="px-4 py-2 text-gray-600 bg-gray-200 rounded-md hover:bg-gray-300">
                                                            Batal
                                                        </button>
                                                        <form action="{{ route('tutorials.destroy', $tutorial->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                                
                                    </div>
                                </div>
                        
                                <div x-data="{ copied: false }" class="mt-4 flex items-center space-x-4">
                                    <!-- Link Presentation -->
                                    <a href="{{ route('presentation', $tutorial->presentation) }}" target="_blank" class="text-sky-500 hover:text-sky-600 flex items-center cursor-pointer">Presentation</a>
                                   
                                    <span class="text-gray-300">|</span>
                                    
                                    <!-- Link Finished -->
                                    <a href="{{ route('finished', $tutorial->finished) }}" target="_blank" class="text-sky-500 hover:text-sky-600 flex items-center cursor-pointer">Finished</a>
                                   
                                    <span class="text-gray-300">|</span>
                                    
                                    <!-- Link Download -->
                                    <a href="{{ route('printpdf', $tutorial->presentation)}}" class="text-sky-500 hover:text-sky-600 flex items-center cursor-pointer">
                                        Download PDF
                                    </a>
                                
                                    <!-- Notifikasi -->
                                    <div x-show="copied" x-cloak class="fixed bottom-5 right-5 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg transition-opacity duration-300">
                                        Link disalin!
                                    </div>
                                </div>
                                
                            </div>
                        @endforeach
                    @endif
                </div>
                 <!-- Pagination -->
                <div class="mt-4">
                    {{ $tutorials->links('pagination::tailwind') }} 
                </div>
            </div>

            {{-- Form Tambah Tutorial --}}
            <div class="w-1/4 p-6 bg-white shadow-lg fixed top-25 right-10 overflow-auto rounded-xl">
                <h2 class="text-xl font-bold mb-4">Tambah Tutorial</h2>
                <form action="{{ route('tutorials.store') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="text" name="judul" placeholder="Judul" class="w-full p-2 border rounded" required>
                    <select name="kode_mata_kuliah" class="w-full p-2 border rounded" required>
                        <option value="">-- Pilih Mata Kuliah --</option>
                        @foreach ($matkul as $mk)
                            <option value="{{ $mk['kdmk'] }}">{{ $mk['kdmk'] }} - {{ $mk['nama'] }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="w-full bg-sky-800 text-white py-2 rounded cursor-pointer hover:bg-sky-900">Tambah</button>
                </form>
            </div>
        </div>
    </div>
@endsection