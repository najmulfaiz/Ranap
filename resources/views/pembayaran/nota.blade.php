<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Pembayaran</title>
    <style>
        body { width: 900px; margin: 8px; }
        h3 { text-align:center; }
        table.rincian {
            width: 100%;
            margin-top: 25px;
            margin-bottom: 25px;
            border-collapse: collapse;
        }
        table.rincian > thead {
            font-weight: bold;
        }
        table.rincian > thead td {
            border-top: 1px solid black;
            border-bottom: 1px solid black;
        }
        table.rincian > tfoot td {
            border-top: 1px solid black;
        }
    </style>
</head>
<body>
    <h3>RSUD KAYEN PATI</h3>
    <table>
        <tr>
            <td colspan="2">Kepada Yth</td>
        </tr>
        <tr>
            <td width="150px">Nama Pasien</td>
            <td>{{ $pendaftaran->pasien->nama }}</td>
        </tr>
        <tr>
            <td>Nomor RM</td>
            <td>{{ $pendaftaran->nomr }}</td>
        </tr>
        <tr>
            <td>Tanggal Masuk</td>
            <td>{{ $pendaftaran->tanggal_masuk }}</td>
        </tr>
        <tr>
            <td>Tanggal Bayar</td>
            <td>{{ $pendaftaran->tanggal_keluar == '' ? '-' : $pendaftaran->tanggal_keluar }}</td>
        </tr>
    </table>
    <table class="rincian">
        <thead>
            <tr>
                <td>Nama Jasa</td>
                <td align="center">Tanggal</td>
                <td align="center">Harga</td>
            </tr>
        </thead>
        <tbody>
            @php 
                $total = 0;
            @endphp
            @foreach($pembayaran as $pembayaran)
                <tr>
                    @if($pembayaran->jenis_tarif_id == 3)
                        <td>Pelayanan Farmasi</td>
                    @else
                        <td>{{ $pembayaran->tarif->nama }}</td>
                    @endif
                    <td align="center">{{ $pembayaran->created_at }}</td>
                    <td align="right">Rp. {{ number_format($pembayaran->tarifrs, 0, '.', '.') }}</td>
                </tr>
                @php 
                    $total += $pembayaran->tarifrs;
                @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td align="right" colspan="2">Total Bayar</td>
                <td align="right">Rp. {{ number_format($total, 0, '.', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <table style="float: right; margin-right: 50px;">
        <tr>
            <td align="center">Kasir</td>
        </tr>
        <tr>
            <td><br /><br /><br /></td>
        </tr>
        <tr>
            <td align="center">( Pembayaran )</td>
        </tr>
    </table>
</body>
</html>