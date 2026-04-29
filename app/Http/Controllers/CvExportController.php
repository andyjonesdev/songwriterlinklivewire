<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CvExportController extends Controller
{
    public function export(): Response
    {
        $user = Auth::user();

        abort_unless($user->isProPlus(), 403);

        $profile = $user->profile;
        $credits  = $user->credits()->orderByDesc('year')->orderBy('title')->get();

        $pdf = Pdf::loadView('pdf.credits', [
            'user'    => $user,
            'profile' => $profile,
            'credits' => $credits,
        ])->setPaper('a4');

        $filename = 'songwriterlink-cv-' . ($profile?->slug ?? $user->id) . '.pdf';

        return $pdf->download($filename);
    }
}
