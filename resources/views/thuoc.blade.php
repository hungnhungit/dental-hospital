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
    <title>Thuốc</title>
</head>

<body>
    <h2>Danh sách thuốc</h2>
    <table>
        <tr>
            <th>TÊN THUỐC</th>
            <th>TÊN LOẠI THUỐC</th>
            <th>ĐƠN VỊ</th>
            <th>SỐ LƯỢNG</th>
        </tr>
        @foreach ($data as $item)
        <tr>
            <td>{{ $item['Ten'] }}</td>
            <td>{{ $item['LoaiThuoc'] }}</td>
            <td>{{ $item['DonVi'] }}</td>
            <td>{{ $item['SoLuong'] }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>
