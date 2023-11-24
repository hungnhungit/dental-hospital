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
            font-size: 12px;
        }

        .text-center {
            text-align: center;
        }
    </style>
    <title>Bill</title>
</head>

<body>
    <h2 class="text-center">Phòng khám nha khoa quốc tế DR DEE</h2>
    <p class="text-center">Danh sách hóa đơn từ ngày {{ $start }} đến ngày {{ $end }}</p>
    <table>
        <tr>
            <th>TÊN HOÁ ĐƠN</th>
            <th>BỆNH NHÂN</th>
            <th>BÁC SĨ</th>
            <th>TỔNG TIỀN</th>
            <th>GIẢM GIÁ</th>
            <th>NGÀY TẠO</th>
            <th>NGƯỜI TẠO</th>
            <th>TRẠNG THÁI</th>
            <th>DỊCH VỤ</th>
        </tr>
        @foreach ($bills as $item)
        <tr>
            <td>{{ $item['TenHoaDon'] }}</td>
            <td>{{ $item['BenhNhan'] }}</td>
            <td>{{ $item['TenBacSi'] }}</td>
            <td>{{ $item['TongSoTien'] }} VND</td>
            <td>{{ $item['GiamGia'] ?? 0 }}%</td>
            <td>{{ $item['NgayLap'] }}</td>
            <td>{{ $item['NguoiTao'] }}</td>
            <td>{{ $item['TrangThai'] }}</td>
            <td>
                <table border="1" style="width: 100%;">
                    <tr>
                        <td>Tên dịch vụ</td>
                        <td>Số lượng</td>
                    </tr>
                    @foreach ($item['DichVu'] as $s)
                    <tr>
                        <td>{{ $s['TenDichVu'] }}</td>
                        <td>{{ $s['SoLuong'] }}</td>
                    </tr>
                    @endforeach

                </table>
            </td>
        </tr>



        @endforeach

    </table>
    <h4>Tông tiền: {{ $TongTien }} VND</h4>
</body>

</html>