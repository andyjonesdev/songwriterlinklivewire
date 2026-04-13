@if ($lyric->plagiarism_flagged === false)
    <span class="inline-block bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-0.5 rounded-full border border-blue-300">✓ Plagiarism Checked</span>
@elseif ($lyric->plagiarism_flagged === true)
    {{-- Only shown to admins; flagged lyrics are hidden from buyers --}}
    <span class="inline-block bg-red-100 text-red-800 text-xs font-semibold px-2 py-0.5 rounded-full border border-red-300">⚠ Plagiarism Flagged</span>
@endif
