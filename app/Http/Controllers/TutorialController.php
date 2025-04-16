<?php

namespace App\Http\Controllers;

use App\Models\Tutorial;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TutorialController extends Controller
{
    public function index()
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('refreshToken')
        ])->get('https://jwt-auth-eight-neon.vercel.app/getMakul');

        $data = $response->json();
        $matkul = $data['data'];

        $tutorials = Tutorial::orderBy('updated_at', 'desc')->paginate(5);
        return view('tutorials.index', compact('tutorials', 'matkul'))->with('title', 'Tutorials');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'judul' => 'required|max:255',
            'kode_mata_kuliah' => 'required',
        ]);

        $slugPresentation = Str::slug($request->judul . '-' . uniqid());
        $slugFinished = Str::slug($request->judul . '-' . uniqid());

        Tutorial::create([
            'judul' => $request->judul,
            'kode_mata_kuliah' => $request->kode_mata_kuliah,
            'presentation' => $slugPresentation,
            'finished' => $slugFinished,
            'creator_email' => session('user_email'),
        ]);

        return redirect()->route('tutorials.index')->with('success', 'Tutorial berhasil ditambahkan!');
    }

    public function update(Request $request, Tutorial $tutorial)
    {
        $request->validate([
            'judul' => 'required',
            'kode_mata_kuliah' => 'required',
        ]);
        
        $tutorial->update($request->all());

        return redirect()->route('tutorials.index')->with('success', 'Tutorial berhasil diperbarui!');
    }

    public function destroy(Tutorial $tutorial)
    {
        $tutorial->delete();
        return redirect()->route('tutorials.index')->with('success', 'Tutorial berhasil dihapus!');
    }

    public function getByMataKuliah($kdmk)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . session('refreshToken')
        ])->get('https://jwt-auth-eight-neon.vercel.app/getMakul');

        $tutorials = Tutorial::where('kode_mata_kuliah', $kdmk)->get();

        if ($tutorials->isEmpty()) {
            return response()->json([
                "result" => [],
                "status" => [
                    "code" => 404,
                    "description" => "Not found data $kdmk"
                ]
            ], 404);
        }

        $result = [];
        foreach ($tutorials as $index => $tutorial) {
            $result[$index] = [
                "kode_matkul" => $tutorial->kode_mata_kuliah,
                // "nama_matkul" => $tutorial->judul,
                "judul" => $tutorial->judul,
                "url_presentation" => route('presentation', $tutorial->presentation),
                "url_finished" => route('finished', $tutorial->finished),
                "creator_email" => $tutorial->creator_email,
                "created_at" => $tutorial->created_at,
                "updated_at" => $tutorial->updated_at
            ];
        }

        return response()->json([
            "result" => (object) $result,
            "status" => [
                "code" => 200,
                "description" => "OK"
            ]
        ], 200);
    }
}

