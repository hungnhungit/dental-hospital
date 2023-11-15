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
    <h2>Danh sách hoá đơn</h2>

    <table>
        <tr>
            <th>TÊN HOÁ ĐƠN</th>
            <th>TỔNG TIỀN</th>
            <th>GIẢM GIÁ</th>
            <th>NGÀY TẠO</th>
            <th>NGƯỜI TẠO</th>
            <th>BỆNH NHÂN</th>
        </tr>
        @foreach ($bills as $item)
        <tr>
            <td>{{ $item['TenHoaDon'] }}</td>
            <td>{{ $item['TongSoTien'] }} VND</td>
            <td>{{ $item['GiamGia'] ?? 0 }}%</td>
            <td>{{ $item['NgayLap'] }}</td>
            <td>{{ $item['NguoiTao'] }}</td>
            <td>{{ $item['BenhNhan'] }}</td>
        </tr>
        @endforeach

    </table>
</body>

</html>
