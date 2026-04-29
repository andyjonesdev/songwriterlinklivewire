<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class SplitSheetController extends Controller
{
    public function export(): Response
    {
        $user = Auth::user();

        abort_unless($user->isProPlus(), 403);

        $data = session('split_sheet_data');

        if (! $data) {
            return redirect()->route('split-sheet.index');
        }

        // Clear session data after use
        session()->forget('split_sheet_data');

        $pdf = Pdf::loadView('pdf.split-sheet', $data)->setPaper('a4');

        $slug     = \Illuminate\Support\Str::slug($data['songTitle'] ?? 'split-sheet');
        $filename = 'split-sheet-' . $slug . '.pdf';

        return $pdf->download($filename);
    }
}
