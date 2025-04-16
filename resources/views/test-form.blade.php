<form action="/test-form" method="POST">
    @csrf
    <input type="text" name="email" value="{{ old('email') }}" placeholder="Email">
    <button type="submit">Kirim</button>

    @if ($errors->has('msg'))
        <div class="text-red-500">{{ $errors->first('msg') }}</div>
    @endif
</form>
