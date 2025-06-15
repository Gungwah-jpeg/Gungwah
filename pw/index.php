<?php
session_start();
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

include 'koneksi.php';

$limit = 7;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$search = isset($_GET['search']) ? mysqli_real_escape_string($connect, $_GET['search']) : '';

if ($search) {
    $resultTotal = mysqli_query($connect, "SELECT COUNT(*) AS total FROM barang 
        WHERE nama_barang LIKE '%$search%' 
        OR no_barang LIKE '%$search%' 
        OR tipe LIKE '%$search%'");
    $rowTotal = mysqli_fetch_assoc($resultTotal);
    $totalData = $rowTotal['total'];
    $totalPage = ceil($totalData / $limit);

    $query = mysqli_query($connect, "SELECT * FROM barang 
        WHERE nama_barang LIKE '%$search%' 
        OR no_barang LIKE '%$search%' 
        OR tipe LIKE '%$search%' 
        ORDER BY id DESC 
        LIMIT $offset, $limit");
} else {
    $resultTotal = mysqli_query($connect, "SELECT COUNT(*) AS total FROM barang");
    $rowTotal = mysqli_fetch_assoc($resultTotal);
    $totalData = $rowTotal['total'];
    $totalPage = ceil($totalData / $limit);

    $query = mysqli_query($connect, "SELECT * FROM barang ORDER BY id DESC LIMIT $offset, $limit");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Peminjaman Barang</title>
    <style>
        :root {
            --primary: rgb(13, 71, 161);
            --accent: #ff9800;
            --danger: #e53935;
            --edit: #43a047;
            --bg: #f4f6f9;
            --white: #ffffff;
            --dark: #263238;
        }

        * { 
            box-sizing: border-box;
            scroll-behavior: smooth;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0px); }
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            background: var(--bg);
            color: var(--dark);
            animation: fadeIn 0.5s ease-out;
        }

        header {
            background: var(--primary);
            color: var(--white);
            text-align: center;
            padding: 30px 10px;
            font-size: 38px;
            letter-spacing: 1px;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.2);
            position: relative;
            animation: slideIn 0.6s ease-out;
        }

        .logout-box {
            position: absolute;
            top: 15px;
            right: 20px;
            background: var(--danger);
            color: white;
            border: none;
            border-radius: 6px;
            padding: 6px 14px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 3px 6px rgba(0,0,0,0.1);
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .logout-box:hover {
            background: #c62828;
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .container {
            max-width: 1100px;
            margin: 40px auto;
            padding: 0 20px;
            animation: fadeIn 0.8s ease-out;
        }

        .tambah-btn {
            background: var(--accent);
            color: white;
            padding: 12px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            display: inline-block;
        }

        .tambah-btn:hover {
            background: #fb8c00;
            transform: translateY(-2px);
            box-shadow: 0 7px 14px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
            border-radius: 10px;
            overflow: hidden;
            background: white;
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            animation: fadeIn 0.7s ease-out;
        }

        th, td {
            padding: 16px;
            text-align: center;
            font-size: 20px;
            transition: all 0.2s ease;
        }

        th {
            background: var(--primary);
            color: white;
            font-size: 15px;
            position: sticky;
            top: 0;
        }

        tr {
            animation: fadeIn 0.5s ease-out;
            animation-fill-mode: both;
        }

        /* Delay animation for each row */
        tr:nth-child(1) { animation-delay: 0.1s; }
        tr:nth-child(2) { animation-delay: 0.2s; }
        tr:nth-child(3) { animation-delay: 0.3s; }
        tr:nth-child(4) { animation-delay: 0.4s; }
        tr:nth-child(5) { animation-delay: 0.5s; }
        tr:nth-child(6) { animation-delay: 0.6s; }
        tr:nth-child(7) { animation-delay: 0.7s; }

        tr:nth-child(even) {
            background: #f1f5f9;
        }

        tr:hover {
            background: #e3f2fd;
            transform: translateX(5px);
        }

        td img {
            border-radius: 10px;
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 2px solid #ccc;
            transition: all 0.3s ease;
        }

        td img:hover {
            transform: scale(1.1);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .btn {
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            margin: 2px;
            display: inline-block;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .btn-edit {
            background-color: var(--edit);
            color: white;
        }

        .btn-edit:hover {
            background-color: #2e7d32;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-delete {
            background-color: var(--danger);
            color: white;
        }

        .btn-delete:hover {
            background-color: #b71c1c;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            animation: pulse 0.5s;
        }

        .pagination {
            text-align: center;
            margin: 30px 0;
            animation: fadeIn 0.9s ease-out;
        }

        .pagination a {
            display: inline-block;
            padding: 10px 16px;
            margin: 0 4px;
            background-color: var(--primary);
            color: white;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination a.active {
            background-color: var(--accent);
            animation: pulse 1.5s infinite;
        }

        .pagination a:hover:not(.active) {
            background-color: #1565c0;
            transform: translateY(-3px);
        }

        /* Search form animation */
        form[method="GET"] {
            animation: slideIn 0.6s ease-out;
        }

        form[method="GET"] input {
            transition: all 0.3s ease;
        }

        form[method="GET"] input:focus {
            transform: scale(1.02);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        form[method="GET"] button {
            transition: all 0.3s ease;
        }

        form[method="GET"] button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Floating icon in header */
        header span {
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body>

<header>
    <span>📦</span> Data Peminjaman Barang
    <a href="logout.php" class="logout-box" onclick="return confirmLogout()">🚪 Logout</a>
</header>

<div class="container">
    <a class="tambah-btn" href="tambah.php">➕ Tambah Barang</a>

    <!-- Form Search -->
    <form method="GET" style="margin: 20px 0;">
        <input type="text" name="search" placeholder="🔍 Cari barang..." value="<?= htmlspecialchars($search) ?>" 
               style="padding:10px; width:300px; border-radius:6px; border:1px solid #ccc;">
        <button type="submit" style="padding:10px 16px; background:var(--primary); color:white; border:none; border-radius:6px;">Cari</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Foto</th>
                <th>No Barang</th>
                <th>Tipe</th>
                <th>Nama Barang</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($data = mysqli_fetch_array($query)) : ?>
            <tr>
                <td>
                    <?php
                    $foto = $data['gambar'];
                    $fotoPath = "gambar/" . $foto;
                    echo (!empty($foto) && file_exists($fotoPath))
                        ? "<img src='$fotoPath' alt='Foto'>"
                        : "<span style='color:gray;'>Tidak Ada</span>";
                    ?>
                </td>
                <td><?= htmlspecialchars($data['no_barang']) ?></td>
                <td><?= htmlspecialchars($data['tipe']) ?></td>
                <td><?= htmlspecialchars($data['nama_barang']) ?></td>
                <td>
                    <a class="btn btn-edit" href="edit.php?id=<?= $data['id'] ?>">Edit</a>
                    <a class="btn btn-delete" href="hapus.php?id=<?= $data['id'] ?>" onclick="return confirm('Yakin ingin hapus?')">Hapus</a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="pagination">
        <?php for ($i = 1; $i <= $totalPage; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>" class="<?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

<script>
function confirmLogout() {
    return confirm("Apakah Anda yakin ingin logout?");
}

// Additional animation effects
document.addEventListener('DOMContentLoaded', function() {
    // Add hover effect to table rows
    const rows = document.querySelectorAll('tbody tr');
    rows.forEach(row => {
        row.addEventListener('mouseenter', () => {
            row.style.transform = 'translateX(5px)';
        });
        row.addEventListener('mouseleave', () => {
            row.style.transform = '';
        });
    });
    
    // Add click effect to buttons
    const buttons = document.querySelectorAll('.btn');
    buttons.forEach(btn => {
        btn.addEventListener('mousedown', () => {
            btn.style.transform = 'translateY(1px)';
        });
        btn.addEventListener('mouseup', () => {
            btn.style.transform = 'translateY(-2px)';
        });
    });
});
</script>

</body>
</html>