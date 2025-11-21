<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Laporan Transaksi</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
      color: #000;
      background: #fff;
    }
    h1 {
      text-align: center;
      margin-bottom: 20px;
    }
    .stats {
      display: flex;
      justify-content: space-around;
      margin-bottom: 30px;
    }
    .stat-box {
      border: 1px solid #333;
      padding: 15px 25px;
      border-radius: 6px;
      text-align: center;
      width: 22%;
    }
    .stat-box p {
      margin: 0;
      font-weight: bold;
      font-size: 18px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
    }
    th, td {
      border: 1px solid #333;
      padding: 8px;
      text-align: left;
    }
    th {
      background-color: #eee;
    }
    @media print {
      body {
        margin: 0;
      }
      .no-print {
        display: none;
      }
    }
  </style>
</head>
<body>

  <h1>Laporan Transaksi</h1>

  <div class="stats">
    <div class="stat-box">
      Total Pendapatan
      <p>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
    </div>
    <div class="stat-box">
      Total Order
      <p>{{ $totalOrders }}</p>
    </div>
    <div class="stat-box">
      Order Selesai
      <p>{{ $completedOrders }}</p>
    </div>
    <div class="stat-box">
      Order Pending
      <p>{{ $pendingOrders }}</p>
    </div>
  </div>

  <table>
    <thead>
      <tr>
        <th>Kode Order</th>
        <th>Customer</th>
        <th>Tanggal Order</th>
        <th>Estimasi Selesai</th>
        <th>Layanan</th>
        <th>Total</th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($orders as $order)
        <tr>
          <td>{{ $order->order_code }}</td>
          <td>{{ $order->customer->customer_name }}</td>
          <td>{{ $order->order_date->format('d/m/Y') }}</td>
          <td>{{ $order->order_end_date->format('d/m/Y') }}</td>
          <td>
            @foreach ($order->transOrderDetails as $detail)
              <div>{{ $detail->typeOfService->service_name }} ({{ $detail->qty }}kg)</div>
            @endforeach
          </td>
          <td>Rp {{ number_format($order->total, 0, ',', '.') }}</td>
          <td>{{ $order->status_text }}</td>
        </tr>
      @empty
        <tr><td colspan="7" style="text-align:center;">Tidak ada data transaksi</td></tr>
      @endforelse
    </tbody>
  </table>

  <script>
    window.onload = function() {
      window.print();
    };
  </script>

</body>
</html>
