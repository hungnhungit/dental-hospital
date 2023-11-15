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
    <p>Tên hoá đơn: {{ $bill['TenHoaDon'] }}</p>
    <p>Bệnh nhân: {{ $bill['BenhNhan'] }}</p>
    <p>Người tạo: {{ $bill['NguoiTao'] }}</p>
    <p>Tổng số tiền: {{ $bill['TongSoTien'] }} VND</p>
    <p>Giảm giá: {{ $bill['GiamGia'] ?? 0  }}%</p>

    <h2>Tiến trình điểu trị</h2>

    <table>
        <tr>
            <th>Tên dịch vụ</th>
            <th>Giá</th>
            <th>Số tiền</th>
        </tr>
        @foreach ($services as $service)
        <tr>
            <td>{{ $service['TenDichVu'] }}</td>
            <td>{{ $service['Gia'] }}</td>
            <td>{{ $service['TongTien'] }} VND</td>
        </tr>
        @endforeach

    </table>
</body>

</html>
