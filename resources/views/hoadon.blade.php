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
</body>

</html>
