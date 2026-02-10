<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
        }

        th {
            background: #DC143C;
            color: #fff;
        }
    </style>
</head>

<body>

    <h3 align="center">Laporan {{ ucfirst($type) }}</h3>
    <p align="center">{{ now()->format('d M Y H:i') }}</p>

    <table>
        <thead>
            <tr>
                @foreach ($headers as $h)
                    <th>{{ $h }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $i => $row)
                <tr>
                    <td>{{ $i + 1 }}</td>

                    @if ($type === 'pemasukan')
                        <td>{{ optional($row->settlement_time)->format('d M Y') ?? '-' }}</td>
                        <td>Rp {{ number_format($row->jumlah ?? 0, 0, ',', '.') }}</td>
                    @else
                        <td>Pengeluaran</td>
                        <td>{{ optional($row->created_at)->format('d/m/Y H:i') ?? '-' }}</td>
                        <td>{{ $row->nama_kegiatan ?? '-' }}</td>
                        <td>{{ $row->rincian ?? '-' }}</td>
                        <td>{{ $row->penanggung_jawab ?? '-' }}</td>
                        <td>-</td>
                        <td>Rp {{ number_format($row->besar_anggaran ?? 0, 0, ',', '.') }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
        @if ($type === 'pemasukan')
            <tfoot>
                <tr>
                    <td colspan="2" align="right"><strong>TOTAL</strong></td>
                    <td><strong>Rp {{ number_format($totalAnggaran, 0, ',', '.') }}</strong></td>
                </tr>
            </tfoot>
        @endif
    </table>

</body>

</html>
