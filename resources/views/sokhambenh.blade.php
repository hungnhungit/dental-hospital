<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table,
        td,
        th {
            border: 1px solid;
            text-align: center;
        }
    </style>
    <title>Bill</title>
</head>

<body>
    <div className="text-lg">
        <span className="font-bold">Bệnh nhân: </span>
        {{ $records['BenhNhan'] }}
    </div>
    <div>
        <span className="font-bold">Bác sĩ: </span>

        {{ $records['BacSi'] }}
    </div>
    <div>
        <span className="font-bold">Chuẩn đoán bệnh: </span>
        {{ $records['ChanDoanBenh'] }}
    </div>

    <h2>Tiến trình điểu trị</h2>

    <table>
        <tr>
            <th>THUỐC</th>
            <th>VẬT TƯ</th>
            <th>CHI TIẾT ĐIỀU TRỊ</th>
            <th>NGÀY ĐIỀU TRỊ</th>
        </tr>
        @foreach ($process as $item)
        <tr>
            <td>{{ $item['Thuoc'] }}</td>
            <td>{{ $item['VatTu'] }}</td>
            <td>{{ $item['ChiTietDieuTri'] }}</td>
            <td>{{ $item['NgayDieuTri'] }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>
