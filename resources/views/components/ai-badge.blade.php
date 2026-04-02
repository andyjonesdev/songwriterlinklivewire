@if ($lyric->ai_flagged === false || $lyric->ai_approved === true)
    <span class="inline-block bg-green-100 text-green-800 text-xs font-semibold px-2 py-0.5 rounded-full border border-green-300">✓ AI Quality Checked</span>
@elseif (is_null($lyric->ai_flagged))
    <span class="inline-block bg-gray-100 text-gray-500 text-xs font-semibold px-2 py-0.5 rounded-full border border-gray-300">⏳ Pending AI Check</span>
@endif
