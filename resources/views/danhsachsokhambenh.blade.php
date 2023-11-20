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
    <h2>Danh sách sổ khám bệnh</h2>

    <table>
        <tr>
            <th>BỆNH NHÂN</th>
            <th>BÁC SĨ</th>
            <th>CHUẨN ĐOÁN BỆNH</th>
            <th>TRẠNG THÁI</th>
        </tr>
        @foreach ($healthRecords as $item)
        <tr>
            <td>{{ $item['HoVaTen'] }}</td>
            <td>{{ $item['BacSi'] }}</td>
            <td>{{ $item['ChanDoanBenh'] }}</td>
            <td>{{ $item['TrangThai'] }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>