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
    </style>
    <title>Thuốc</title>
</head>

<body>
    <h2>Danh sách bệnh nhân</h2>
    <table>
        <tr>
            <th>HỌ VÀ TÊN</th>
            <th>MÃ</th>
            <th>NGÀY SINH</th>
            <th>ĐỊA CHỈ</th>
            <th>CCCD</th>
            <th>CÂN NẶNG</th>
            <th>CHIỀU CAO</th>
            <th>NHÓM MÁU</th>
        </tr>
        @foreach ($patients as $item)
        <tr>
            <td>{{ $item['HoVaTen'] }}</td>
            <td>{{ $item['Ma'] }}</td>
            <td>{{ $item['NgaySinh'] }}</td>
            <td>{{ $item['DiaChi'] }}</td>
            <td>{{ $item['CMND'] }}</td>
            <td>{{ $item['ChieuCao'] }}</td>
            <td>{{ $item['CanNang'] }}</td>
            <td>{{ $item['NhomMau'] }}</td>
        </tr>
        @endforeach
    </table>
</body>

</html>