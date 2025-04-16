@extends('layouts.app')

@section('title', $title)

@section('content')
    <div class="h-screen flex max-lg:flex-col">
        <div class="flex basis-7/12  bg-sky-100 lg:justify-around items-center max-lg:h-8">
            <img src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-login-form/draw2.webp"
                class="w-2/3 max-lg:object-contain max-lg:h-full" alt="image" />
        </div>

        <div class="flex basis-5/12 justify-center bg-white">

            <form class="bg-white my-30" action="{{ route('login') }}" method="POST">
                @csrf
                <h1 class="text-gray-800 font-bold text-3xl mb-4">Welcome!</h1>
                <p class="text-sm font-normal text-gray-600 mb-8">Please login to your account.</p>
                {{-- @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative"
                        role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif --}}
                
                @if ($errors->has('msg'))
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Failed!</strong>
                        <span class="block sm:inline">{{ $errors->first('msg') }}</span>
                    </div>
                @endif

                <div class="flex items-center border-2 py-2 px-3 rounded-2xl mt-6 mb-5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                    </svg>
                    <input class="pl-2 outline-none border-none" type="email" name="email" id="email"
                        placeholder="Email Address" required />
                </div>
                <div class="flex items-center border-2 py-2 px-3 rounded-2xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                            clip-rule="evenodd" />
                    </svg>
                    <input class="pl-2 outline-none border-none" type="password" name="password" id="password"
                        placeholder="Password" />
                </div>
                <button type="submit"
                    class="block w-full bg-sky-800 mt-5 py-2 rounded-2xl text-white font-semibold mb-2 cursor-pointer">Login</button>

            </form>
        </div>
    </div>
@endsection
