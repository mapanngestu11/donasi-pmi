<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pendapatan & Pengeluaran</title>
    <style>
        @media print {
            body {
                margin: 0;
                padding: 10px;
            }
            .no-print {
                display: none;
            }
            @page {
                margin: 0.8cm;
                size: A4 landscape;
            }
            .kop-surat {
                page-break-after: avoid;
            }
            .header {
                page-break-after: avoid;
            }
            .summary-info {
                page-break-after: avoid;
            }
            table {
                page-break-inside: auto;
            }
            table thead {
                display: table-header-group;
            }
            table tfoot {
                display: table-footer-group;
            }
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 0;
            padding: 20px;
            background: white;
        }
        .print-button {
            text-align: center;
            margin-bottom: 20px;
        }
        .print-button button {
            background-color: #DC143C;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 14px;
            cursor: pointer;
            border-radius: 5px;
        }
        .print-button button:hover {
            background-color: #B71C1C;
        }
        /* Kop Surat */
        .kop-surat {
            width: 100%;
            background: white;
            padding: 20px;
            margin-bottom: 25px;
            border-bottom: 3px solid #DC143C;
        }
        .kop-content {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        .kop-left {
            display: table-cell;
            vertical-align: middle;
            width: auto;
        }
        .kop-left-inner {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .kop-logo {
            width: 55px;
            height: 55px;
            flex-shrink: 0;
        }
        .kop-logo img,
        .kop-logo svg {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }
        .kop-text {
            display: flex;
            flex-direction: column;
        }
        .kop-text .org-name {
            font-size: 13px;
            font-weight: bold;
            color: #333;
            line-height: 1.4;
            margin: 0;
        }
        .kop-right {
            display: table-cell;
            text-align: right;
            vertical-align: middle;
            width: 100%;
        }
        .kop-right .org-name-full {
            font-size: 15px;
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kop-right .org-location {
            font-size: 13px;
            font-weight: bold;
            color: #333;
            margin-bottom: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .kop-right .org-address {
            font-size: 10px;
            color: #666;
            font-weight: normal;
            margin: 0;
        }
        .kop-bar {
            width: 100%;
            height: 10px;
            background: linear-gradient(to right, #B71C1C 0%, #DC143C 100%);
            margin-top: 12px;
            border-radius: 0;
        }
        .header {
            text-align: center;
            margin: 20px 0;
            padding: 10px;
        }
        .header h1 {
            margin: 0;
            font-size: 18px;
            color: #333;
            font-weight: bold;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0;
            color: #666;
            font-size: 11px;
        }
        /* Summary Info Boxes */
        .summary-info {
            display: table;
            width: 100%;
            margin: 20px 0;
            page-break-inside: avoid;
        }
        .summary-info-row {
            display: table-row;
        }
        .summary-box {
            display: table-cell;
            width: 33.33%;
            padding: 12px;
            vertical-align: top;
        }
        .summary-box-inner {
            border: 2px solid;
            border-radius: 5px;
            padding: 12px;
            text-align: center;
            height: 100%;
        }
        .summary-box.pendapatan .summary-box-inner {
            border-color: #28a745;
            background-color: #f8fff9;
        }
        .summary-box.pengeluaran .summary-box-inner {
            border-color: #dc3545;
            background-color: #fff8f8;
        }
        .summary-box.saldo .summary-box-inner {
            border-color: #DC143C;
            background-color: #fff5f5;
        }
        .summary-box-title {
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        .summary-box.pendapatan .summary-box-title {
            color: #28a745;
        }
        .summary-box.pengeluaran .summary-box-title {
            color: #dc3545;
        }
        .summary-box.saldo .summary-box-title {
            color: #DC143C;
        }
        .summary-box-value {
            font-size: 16px;
            font-weight: bold;
            margin: 5px 0;
        }
        .summary-box.pendapatan .summary-box-value {
            color: #28a745;
        }
        .summary-box.pengeluaran .summary-box-value {
            color: #dc3545;
        }
        .summary-box.saldo .summary-box-value {
            color: #DC143C;
        }
        .summary-box-icon {
            font-size: 20px;
            margin-bottom: 5px;
            line-height: 1;
        }
        .summary-box.pendapatan .summary-box-icon {
            color: #28a745;
        }
        .summary-box.pengeluaran .summary-box-icon {
            color: #dc3545;
        }
        .summary-box.saldo .summary-box-icon {
            color: #DC143C;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 9px;
            page-break-inside: auto;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }
        table th {
            background-color: #DC143C;
            color: white;
            font-weight: bold;
            text-align: center;
            font-size: 9px;
        }
        table tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }
        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        table td {
            vertical-align: top;
            word-wrap: break-word;
        }
        table td:nth-child(1) { width: 3%; }
        table td:nth-child(2) { width: 8%; }
        table td:nth-child(3) { width: 10%; }
        table td:nth-child(4) { width: 15%; }
        table td:nth-child(5) { width: 20%; }
        table td:nth-child(6) { width: 12%; }
        table td:nth-child(7) { width: 10%; }
        table td:nth-child(8) { width: 12%; }
        .summary {
            margin-top: 20px;
            padding: 12px;
            background-color: #f8f9fc;
            border: 1px solid #ddd;
        }
        .summary-row {
            display: flex;
            justify-content: space-between;
            padding: 4px 0;
            border-bottom: 1px solid #ddd;
            font-size: 11px;
        }
        .summary-row:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 12px;
            margin-top: 8px;
            padding-top: 8px;
        }
        .text-right {
            text-align: right;
        }
        .text-success {
            color: #28a745;
        }
        .text-danger {
            color: #dc3545;
        }
        .badge {
            padding: 3px 8px;
            border-radius: 3px;
            font-size: 10px;
            font-weight: bold;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="print-button no-print">
        <button onclick="window.print()">Cetak / Simpan sebagai PDF</button>
    </div>
    
    <!-- Kop Surat -->
    <div class="kop-surat">
        <div class="kop-content">
            <div class="kop-left">
                <div class="kop-left-inner">
                    <div class="kop-logo">
                        @if(isset($logoPath) && $logoPath)
                            <img src="{{ $logoPath }}" alt="Logo PMI" onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                            <svg width="55" height="55" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:none;">
                                <path d="M25 8 C28 8, 31 9, 33 11 C35 13, 36 16, 36 19 C38 20, 39 22, 39 25 C39 28, 38 30, 36 31 C36 34, 35 37, 33 39 C31 41, 28 42, 25 42 C22 42, 19 41, 17 39 C15 37, 14 34, 14 31 C12 30, 11 28, 11 25 C11 22, 12 20, 14 19 C14 16, 15 13, 17 11 C19 9, 22 8, 25 8 Z" stroke="#DC143C" stroke-width="2.5" fill="#FFFFFF"/>
                                <rect x="23" y="18" width="4" height="14" fill="#DC143C" rx="0.5"/>
                                <rect x="18" y="23" width="14" height="4" fill="#DC143C" rx="0.5"/>
                            </svg>
                        @else
                            <!-- SVG Logo PMI inline -->
                            <svg width="55" height="55" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M25 8 C28 8, 31 9, 33 11 C35 13, 36 16, 36 19 C38 20, 39 22, 39 25 C39 28, 38 30, 36 31 C36 34, 35 37, 33 39 C31 41, 28 42, 25 42 C22 42, 19 41, 17 39 C15 37, 14 34, 14 31 C12 30, 11 28, 11 25 C11 22, 12 20, 14 19 C14 16, 15 13, 17 11 C19 9, 22 8, 25 8 Z" stroke="#DC143C" stroke-width="2.5" fill="#FFFFFF"/>
                                <rect x="23" y="18" width="4" height="14" fill="#DC143C" rx="0.5"/>
                                <rect x="18" y="23" width="14" height="4" fill="#DC143C" rx="0.5"/>
                            </svg>
                        @endif
                    </div>
                    <div class="kop-text">
                        <div class="org-name">Palang Merah<br>Indonesia</div>
                    </div>
                </div>
            </div>
            <div class="kop-right">
                <div class="org-name-full">PALANG MERAH INDONESIA</div>
                <div class="org-location">KOTA TANGERANG</div>
                <div class="org-address">Jl. Raya Tangerang, Kota Tangerang, Banten</div>
            </div>
        </div>
        <div class="kop-bar"></div>
    </div>

    <div class="header">
        <h1>Laporan Pendapatan & Pengeluaran</h1>
        <p>Periode: {{ date('d/m/Y', strtotime('-1 month')) }} - {{ date('d/m/Y') }}</p>
    </div>

    <!-- Summary Info Boxes -->
    <div class="summary-info">
        <div class="summary-info-row">
            <div class="summary-box pendapatan">
                <div class="summary-box-inner">
                    <div class="summary-box-icon" style="font-size: 28px; font-weight: bold;">▲</div>
                    <div class="summary-box-title">Total Pendapatan</div>
                    <div class="summary-box-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="summary-box pengeluaran">
                <div class="summary-box-inner">
                    <div class="summary-box-icon" style="font-size: 28px; font-weight: bold;">▼</div>
                    <div class="summary-box-title">Total Pengeluaran</div>
                    <div class="summary-box-value">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                </div>
            </div>
            <div class="summary-box saldo">
                <div class="summary-box-inner">
                    <div class="summary-box-icon" style="font-size: 28px; font-weight: bold;">●</div>
                    <div class="summary-box-title">Saldo</div>
                    <div class="summary-box-value">Rp {{ number_format($saldo, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Jenis</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Detail</th>
                <th>Nama/Penanggung Jawab</th>
                <th>Bank</th>
                <th class="text-right">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $index => $row)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    @if($row['type'] == 'Pendapatan')
                        <span class="badge badge-success">Pendapatan</span>
                    @else
                        <span class="badge badge-danger">Pengeluaran</span>
                    @endif
                </td>
                <td style="white-space: nowrap;">{{ $row['tanggal'] }}</td>
                <td>{{ $row['keterangan'] }}</td>
                <td style="max-width: 200px;">{{ strlen($row['detail']) > 80 ? substr($row['detail'], 0, 80) . '...' : $row['detail'] }}</td>
                <td>{{ $row['nama'] }}</td>
                <td>{{ $row['bank'] }}</td>
                <td class="text-right">
                    @if($row['type'] == 'Pendapatan')
                        <span class="text-success">Rp {{ number_format($row['nominal'], 0, ',', '.') }}</span>
                    @else
                        <span class="text-danger">Rp {{ number_format(abs($row['nominal']), 0, ',', '.') }}</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-row">
            <span>Total Pendapatan:</span>
            <span class="text-success text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span>Total Pengeluaran:</span>
            <span class="text-danger text-right">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span>Saldo:</span>
            <span class="text-right {{ $saldo >= 0 ? 'text-success' : 'text-danger' }}">Rp {{ number_format($saldo, 0, ',', '.') }}</span>
        </div>
    </div>

    <div style="margin-top: 30px; text-align: right;">
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>

