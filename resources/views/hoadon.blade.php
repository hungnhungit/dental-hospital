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
    <p>GiamGia: {{ $bill['GiamGia'] ?? 0  }}%</p>

    <h2>Tiến trình điểu trị</h2>

    <table>
        <tr>
            <th>MÃ</th>
            <th>DỊCH VỤ</th>
            <th>THUỐC</th>
            <th>SỐ THUỐC</th>
            <th>VẬT TƯ</th>
            <th>SỐ VẬT TƯ</th>
            <th>CHI TIẾT ĐIỀU TRỊ</th>
            <th>NGÀY ĐIỀU TRỊ</th>
        </tr>
        <tr>
            <td>{{ $process['TenTienTrinh'] }}</td>
            <td>{{ $process['DichVu'] }}</td>
            <td>{{ $process['Thuoc'] }}</td>
            <td>{{ $process['Sothuoc'] }}</td>
            <td>{{ $process['VatTu'] }}</td>
            <td>{{ $process['SoVatTu'] }}</td>
            <td>{{ $process['ChiTietDieuTri'] }}</td>
            <td>{{ $process['NgayDieuTri'] }}</td>
        </tr>
    </table>
</body>

</html>
