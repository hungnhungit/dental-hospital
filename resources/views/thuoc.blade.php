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
            font-size: 10px;
        }

        .text-center {
            text-align: center;
        }
    </style>
    <title>Thuốc</title>
</head>

<body>
    <h2 class="text-center">Danh sách thuốc</h2>
    <table>
        <tr>
            <th>TÊN THUỐC</th>
            <th>TÊN LOẠI THUỐC</th>
            <th>ĐƠN VỊ</th>
            <th>SỐ LƯỢNG NHẬP</th>
            <th>CHI PHÍ NHẬP</th>
            <th>SỐ LƯỢNG XUẤT</th>
            <th>CHI PHÍ XUẤT</th>
            <th>SỐ LƯỢNG HIỆN TẠI</th>
        </tr>
        @foreach ($data as $item)
        <tr>
            <td>{{ $item['Ten'] }}</td>
            <td>{{ $item['LoaiThuoc'] }}</td>
            <td>{{ $item['DonVi'] }}</td>
            <td>{{ $item['SoLuongNhap'] }}</td>
            <td>{{ $item['ChiPhiNhap']}} VND</td>
            <td>{{ $item['SoLuongXuat'] }}</td>
            <td>{{ $item['ChiPhiXuat']}} VND</td>
            <td>{{ $item['SoLuongHienTai'] }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>