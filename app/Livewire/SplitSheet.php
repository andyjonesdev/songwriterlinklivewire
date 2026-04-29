<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;

#[Layout('components.layouts.app.sidebar')]
#[Title('Split Sheet Generator')]
class SplitSheet extends Component
{
    // Song details
    public string $songTitle    = '';
    public string $songArtist   = '';
    public string $recordedDate = '';
    public string $isrc         = '';
    public string $iswc         = '';
    public string $publisher    = '';
    public string $notes        = '';

    // Writers (array of {name, role, share, pro, ipi})
    public array $writers = [
        ['name' => '', 'role' => 'Songwriter', 'share' => '', 'pro' => '', 'ipi' => ''],
    ];

    protected function rules(): array
    {
        return [
            'songTitle'              => 'required|string|max:200',
            'songArtist'             => 'nullable|string|max:200',
            'recordedDate'           => 'nullable|date',
            'isrc'                   => 'nullable|string|max:20',
            'iswc'                   => 'nullable|string|max:20',
            'publisher'              => 'nullable|string|max:200',
            'notes'                  => 'nullable|string|max:1000',
            'writers'                => 'required|array|min:1',
            'writers.*.name'         => 'required|string|max:200',
            'writers.*.role'         => 'required|string|max:100',
            'writers.*.share'        => 'required|numeric|min:0|max:100',
            'writers.*.pro'          => 'nullable|string|max:50',
            'writers.*.ipi'          => 'nullable|string|max:20',
        ];
    }

    public function mount(): void
    {
        if (! Auth::user()->isProPlus()) {
            abort(403, 'Split Sheet generator is a Pro+ feature.');
        }

        // Pre-fill first writer with the current user's name
        $this->writers[0]['name'] = Auth::user()->profile?->display_name ?? Auth::user()->name;
        $this->writers[0]['role'] = ucfirst(Auth::user()->role ?? 'Songwriter');
    }

    public function addWriter(): void
    {
        $this->writers[] = ['name' => '', 'role' => 'Songwriter', 'share' => '', 'pro' => '', 'ipi' => ''];
    }

    public function removeWriter(int $index): void
    {
        if (count($this->writers) <= 1) return;
        array_splice($this->writers, $index, 1);
        $this->writers = array_values($this->writers);
    }

    public function totalShare(): float
    {
        return collect($this->writers)->sum(fn ($w) => (float) ($w['share'] ?? 0));
    }

    public function generatePdf()
    {
        $this->validate();

        $total = $this->totalShare();
        if (abs($total - 100) > 0.01) {
            $this->addError('writers', 'Shares must total exactly 100%. Current total: ' . number_format($total, 2) . '%');
            return;
        }

        // Store in session and redirect to controller for PDF generation
        session(['split_sheet_data' => [
            'songTitle'    => $this->songTitle,
            'songArtist'   => $this->songArtist,
            'recordedDate' => $this->recordedDate,
            'isrc'         => $this->isrc,
            'iswc'         => $this->iswc,
            'publisher'    => $this->publisher,
            'notes'        => $this->notes,
            'writers'      => $this->writers,
            'generatedBy'  => Auth::user()->profile?->display_name ?? Auth::user()->name,
            'generatedAt'  => now()->toDateString(),
        ]]);

        return redirect()->route('split-sheet.export');
    }

    public function render()
    {
        return view('livewire.split-sheet', [
            'totalShare' => $this->totalShare(),
        ]);
    }
}
