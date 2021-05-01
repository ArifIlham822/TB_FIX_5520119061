<html><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <title>Data Buku</title>
</head>
<body>
        <h1 class="text-center">Data Buku</h1>
        <p class="text-center">Laporan Data buku Tahun 2021</p>
        </br>
        <table id="table-data" class="table table-bordered">
            <thead>
                <tr>
                    <th>NO</th>
                    <th>NAME</th>
                    <th>QYT</th>
                    <th>MEREK</th>
                    <th>KATEEGORI</th>
                    <th>COVER</th>
                </tr>
            </thead>
            <tbody>
                @php $no=1; @endphp
                @foreach ($product as $product)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->qty }}</td>
                    <td>{{ $product->brands->name }}</td>
                    <td>{{ $product->categories->name }}</td>
                    <td>
                        @if ($product->photo !== null)
                            <img src="{{ public_path('storage/photo_product/'.$product->photo) }}" width="80px"/>
                        @else
                            [Gambar tidak tersedia]
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
</body>
</html>
