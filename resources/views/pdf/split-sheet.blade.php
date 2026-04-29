<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Split Sheet — {{ $songTitle }}</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 11px;
            color: #18181b;
            line-height: 1.5;
            padding: 40px 48px;
        }
        .header {
            border-bottom: 2px solid #7c3aed;
            padding-bottom: 16px;
            margin-bottom: 24px;
            text-align: center;
        }
        .header h1 {
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #7c3aed;
        }
        .header h2 {
            font-size: 16px;
            font-weight: 700;
            margin-top: 6px;
            color: #18181b;
        }
        .header .artist {
            font-size: 12px;
            color: #71717a;
            margin-top: 2px;
        }
        .meta-grid {
            display: table;
            width: 100%;
            margin-bottom: 24px;
        }
        .meta-grid .col {
            display: table-cell;
            width: 50%;
            padding-right: 16px;
            vertical-align: top;
        }
        .meta-item {
            margin-bottom: 6px;
        }
        .meta-label {
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #a1a1aa;
        }
        .meta-value {
            font-size: 11px;
            color: #3f3f46;
        }
        .section-title {
            font-size: 13px;
            font-weight: 700;
            color: #7c3aed;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e4e4e7;
            padding-bottom: 4px;
            margin-bottom: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead tr {
            background: #f4f4f5;
        }
        thead th {
            text-align: left;
            padding: 6px 8px;
            font-size: 9px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: #52525b;
        }
        tbody tr {
            border-bottom: 1px solid #e4e4e7;
        }
        tbody tr:nth-child(even) {
            background: #fafafa;
        }
        tbody td {
            padding: 8px 8px;
            vertical-align: middle;
        }
        .share-cell {
            font-size: 14px;
            font-weight: 700;
            color: #7c3aed;
        }
        .total-row td {
            font-weight: 700;
            background: #ede9fe;
            border-top: 2px solid #7c3aed;
            padding: 8px 8px;
        }
        .sig-section {
            margin-top: 32px;
        }
        .sig-grid {
            display: table;
            width: 100%;
            margin-top: 16px;
        }
        .sig-col {
            display: table-cell;
            width: 50%;
            padding-right: 32px;
            vertical-align: top;
        }
        .sig-name {
            font-weight: 600;
            font-size: 12px;
            margin-bottom: 4px;
        }
        .sig-role {
            font-size: 10px;
            color: #71717a;
            margin-bottom: 12px;
        }
        .sig-line {
            border-bottom: 1px solid #a1a1aa;
            margin-top: 24px;
            margin-bottom: 4px;
        }
        .sig-label {
            font-size: 9px;
            color: #a1a1aa;
        }
        .notes {
            margin-top: 24px;
            padding: 10px 12px;
            background: #f4f4f5;
            border-left: 3px solid #d4d4d8;
            font-size: 10px;
            color: #52525b;
        }
        .footer {
            margin-top: 36px;
            padding-top: 12px;
            border-top: 1px solid #e4e4e7;
            font-size: 9px;
            color: #a1a1aa;
            text-align: center;
        }
        .disclaimer {
            margin-top: 20px;
            font-size: 9px;
            color: #a1a1aa;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Song Split Sheet</h1>
        <h2>{{ $songTitle }}</h2>
        @if(!empty($songArtist))
            <div class="artist">Recorded by: {{ $songArtist }}</div>
        @endif
    </div>

    {{-- Song metadata --}}
    <div class="meta-grid">
        <div class="col">
            @if(!empty($recordedDate))
                <div class="meta-item">
                    <div class="meta-label">Date Recorded / Written</div>
                    <div class="meta-value">{{ \Carbon\Carbon::parse($recordedDate)->format('d M Y') }}</div>
                </div>
            @endif
            @if(!empty($isrc))
                <div class="meta-item">
                    <div class="meta-label">ISRC</div>
                    <div class="meta-value">{{ $isrc }}</div>
                </div>
            @endif
        </div>
        <div class="col">
            @if(!empty($publisher))
                <div class="meta-item">
                    <div class="meta-label">Publisher</div>
                    <div class="meta-value">{{ $publisher }}</div>
                </div>
            @endif
            @if(!empty($iswc))
                <div class="meta-item">
                    <div class="meta-label">ISWC</div>
                    <div class="meta-value">{{ $iswc }}</div>
                </div>
            @endif
        </div>
    </div>

    <div class="section-title">Ownership Splits</div>

    <table>
        <thead>
            <tr>
                <th style="width:28%">Writer Name</th>
                <th style="width:18%">Role</th>
                <th style="width:12%">Share %</th>
                <th style="width:20%">PRO / Collection Society</th>
                <th style="width:22%">IPI / CAE Number</th>
            </tr>
        </thead>
        <tbody>
            @foreach($writers as $writer)
                <tr>
                    <td style="font-weight:600">{{ $writer['name'] }}</td>
                    <td>{{ $writer['role'] }}</td>
                    <td class="share-cell">{{ number_format((float)($writer['share'] ?? 0), 2) }}%</td>
                    <td>{{ !empty($writer['pro']) ? $writer['pro'] : '—' }}</td>
                    <td style="font-size:10px;color:#71717a">{{ !empty($writer['ipi']) ? $writer['ipi'] : '—' }}</td>
                </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="2">Total</td>
                <td class="share-cell">{{ number_format(collect($writers)->sum(fn($w) => (float)($w['share'] ?? 0)), 2) }}%</td>
                <td colspan="2"></td>
            </tr>
        </tbody>
    </table>

    @if(!empty($notes))
        <div class="notes"><strong>Notes:</strong> {{ $notes }}</div>
    @endif

    {{-- Signature blocks --}}
    <div class="sig-section">
        <div class="section-title">Signatures</div>
        <div class="sig-grid">
            @foreach(collect($writers)->chunk(2) as $pair)
                @foreach($pair as $writer)
                    <div class="sig-col">
                        <div class="sig-name">{{ $writer['name'] }}</div>
                        <div class="sig-role">{{ $writer['role'] }} &nbsp;·&nbsp; {{ number_format((float)($writer['share'] ?? 0), 2) }}%</div>
                        <div class="sig-line"></div>
                        <div class="sig-label">Signature &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Date</div>
                    </div>
                @endforeach
            @endforeach
        </div>
    </div>

    <p class="disclaimer">
        This split sheet is a record of the agreed ownership splits for the song listed above.
        All parties should sign a copy. This document does not replace formal publishing or
        co-writing agreements. Generated via SongwriterLink — songwriterlink.com
    </p>

    <div class="footer">
        Generated by {{ $generatedBy }} &nbsp;·&nbsp; {{ $generatedAt }} &nbsp;·&nbsp; SongwriterLink
    </div>

</body>
</html>
