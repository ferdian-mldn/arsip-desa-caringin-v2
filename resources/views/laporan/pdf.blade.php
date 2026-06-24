<!DOCTYPE html>
<html>
<head>
    <title>Laporan Rekapitulasi Arsip</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 18px; text-transform: uppercase; }
        .header p { margin: 2px 0; font-size: 12px; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px 8px; text-align: left; }
        th { background-color: #f0f0f0; font-weight: bold; text-align: center; }
        
        .meta-info { margin-bottom: 15px; }
        .meta-info td { border: none; padding: 2px; }

        .footer { margin-top: 30px; text-align: right; font-size: 11px; }
        .signature { margin-top: 50px; text-align: right; margin-right: 30px; }
        .bg-accent { background-color: var(--accent); }
    .text-accent { color: var(--accent); }
</style>
</head>
<body>

    <div class="header">
        <h1>Pemerintahan Desa Caringin</h1>
        <p>Alamat: Jl. Raya Caringin No. 123, Sukabumi, Jawa Barat</p>
        <p>Telepon: (0266) 123456 | Email: desa.caringin@example.com</p>
    </div>

    <div class="meta-info">
        <h3 style="text-align:center; text-decoration: underline;">LAPORAN REKAPITULASI ARSIP DOKUMEN</h3>
        <table style="width: auto; margin: 0 auto; margin-top:10px;">
            <tr>
                <td width="100">Periode</td>
                <td>: {{ \Carbon\Carbon::parse($tgl_awal)->format('d M Y') }} s/d {{ \Carbon\Carbon::parse($tgl_akhir)->format('d M Y') }}</td>
            </tr>
            <tr>
                <td>Kategori</td>
                <td>: {{ $kategori }}</td>
            </tr>
            <tr>
                <td>Total Data</td>
                <td>: {{ $dokumen->count() }} Dokumen</td>
            </tr>
        </table>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">No. Dokumen</th>
                <th width="25%">Judul Dokumen</th>
                <th width="15%">Kategori</th>
                <th width="15%">Unit Kerja</th>
                <th width="15%">Tanggal Upload</th>
                <th width="10%">Ket</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dokumen as $index => $d)
            <tr>
                <td style="text-align:center;">{{ $index + 1 }}</td>
                <td>{{ $d->nomor_dokumen }}</td>
                <td>{{ $d->judul_dokumen }}</td>
                <td>{{ $d->kategori->nama_kategori }}</td>
                <td>{{ $d->unitKerja->nama_unit ?? '-' }}</td>
                <td style="text-align:center;">{{ $d->tanggal_unggah->format('d/m/Y') }}</td>
                <td style="text-align:center;">{{ $d->status_retensi }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; padding: 20px;">Tidak ada data pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y, H:i') }}</p>
        <p>Oleh: {{ Auth::user()->nama_lengkap }}</p>
    </div>

    <div class="signature">
        <p>Mengetahui,</p>
        <p>Kepala Desa Caringin</p>
        <br><br><br>
        <p><strong>( ..................................... )</strong></p>
    </div>

</body>
</html>