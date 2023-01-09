<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <title>Print Data Menu</title>
  </head>
  <style media="print">
    body{
        background-color: whitesmoke
    }
    #bg {
        background-color: #f57e7e;
    }
  </style>
  <body>
    <div class="container">
        <h1 class="my-5 text-center">Data Menu Makanan & Minuman</h1>
        <table class="table table-bordered text-center">
            <thead class="bg-secondary text-white">
                <tr>
                    <th>No</th>
                    <th>Kode</th>
                    <th>Nama Makanan / Minuman</th>
                    <th>Kategori</th>
                    <th>Stcok</th>
                    <th>Harga Satuan</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($data as $item)
                    @if ($item->jumlah < 5)
                        <tr id="bg">
                            <th class="" style="">{{ $no++ }}</th>
                            <td class="" style="">{{ $item->kode }}</td>
                            <td class="" style="">{{ $item->nm_barang }}</td>
                            <td class="" style="">{{ $item->kategori->nm_kategori }}</td>
                            <td class="" style="">{{ $item->jumlah }}</td>
                            <td class="" style="">Rp.{{ number_format($item->harga) }}</td>
                        </tr>
                    @else
                        <tr>
                            <th>{{ $no++ }}</th>
                            <td>{{ $item->kode }}</td>
                            <td>{{ $item->nm_barang }}</td>
                            <td>{{ $item->kategori->nm_kategori }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>Rp.{{ number_format($item->harga) }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-right">Total Pendapatan Setiap Bulan : </th>
                    <th colspan="5">Rp.{{ number_format($data->sum('harga') * $data->sum('jumlah')) }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>
    <script>
        window.print()
    </script>
</body>
</html>