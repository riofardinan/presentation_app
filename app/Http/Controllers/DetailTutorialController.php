<?php

namespace App\Http\Controllers;

use Livewire\Livewire;
use App\Models\Tutorial;
use PDF;
use Illuminate\Http\Request;
use App\Events\DetailUpdated;
use App\Models\DetailTutorial;
use App\Http\Controllers\Controller;

class DetailTutorialController extends Controller {
    public function index($slug) {
        $tutorial = Tutorial::where('finished', $slug)->first();
        $details = DetailTutorial::where('tutorial_id', $tutorial->id)->get();
        return view('tutorials.details', compact('tutorial', 'details'))->with('title', 'Detail');
    }

    public function store(Request $request, $tutorial_id) {
        // $request->validate([
        //     'tutorial_id' => 'required|exists:tutorials,id',
        //     'content' => 'required',
        //     'order' => 'required|integer',
        //     'status' => 'required|in:show,hide',
        // ]);
        // dd($request->all());
        $request->validate([
            'content.*' => 'required', // Validasi tiap section
        ]);

        $existingIds = $request->detail_id ?? [];

        DetailTutorial::where('tutorial_id', $tutorial_id)
            ->whereNotIn('id', $existingIds)
            ->delete();

        foreach ($request->content as $index => $content) {
            DetailTutorial::updateOrCreate(
                ['id' => $existingIds[$index] ?? null], // Jika ada, update; jika tidak, insert
                [
                    'tutorial_id' => $tutorial_id,
                    'content' => $content,
                    'order' => $index,
                    'status' => $request->status[$index]
                ]
            );
        }

        DetailUpdated::dispatch($tutorial_id);

        return redirect()->route('tutorials.index')->with('success', 'Detail tutorial berhasil ditambahkan!');
    }

    public function presentation($slug)
    {
        $tutorial = Tutorial::where('presentation', $slug)->with([
            'details' => function ($query) {
                $query->where('status', 'show');
            }
        ])->firstOrFail();
    
        return view('tutorials.presentation', compact('tutorial'))->with('title', 'Presentation');
    }

    public function finished($slug)
    {
        $tutorial = Tutorial::where('finished', $slug)->with('details')->firstOrFail();
    
        return view('tutorials.presentation', compact('tutorial'))->with('title', 'Finished');
    }

    public function printPdf($slug)
    {
        $tutorial = Tutorial::where('presentation', $slug)->with('details')->firstOrFail();
        $pdf = PDF::loadView('tutorials.printpdf', compact('tutorial'))
                ->setPaper('A4', 'portrait')
                ->setOptions(['isHtml5ParserEnabled' => true, 'isPhpEnabled' => true]);

        return $pdf->download("$tutorial->judul.pdf");        
    }
}

