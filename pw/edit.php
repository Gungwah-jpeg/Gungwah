<?php
include 'koneksi.php';
$id = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM barang WHERE id=$id"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes slideIn {
            from { transform: translateX(-30px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
        
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0px); }
        }
        
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: rgb(13, 71, 161);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            animation: fadeIn 0.6s ease-out;
        }
        
        .form-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            width: 400px;
            animation: slideIn 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
            transition: all 0.3s ease;
        }
        
        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.25);
        }
        
        h2 {
            text-align: center;
            color: #0d47a1;
            margin-bottom: 25px;
            font-size: 24px;
        }
        
        h2 span {
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }
        
        label {
            font-weight: 600;
            margin-top: 12px;
            display: block;
            margin-bottom: 6px;
            color: #333;
            font-size: 14px;
            animation: fadeIn 0.5s ease-out;
            animation-fill-mode: both;
        }
        
        /* Staggered animation for labels */
        label:nth-child(1) { animation-delay: 0.1s; }
        label:nth-child(2) { animation-delay: 0.2s; }
        label:nth-child(3) { animation-delay: 0.3s; }
        label:nth-child(4) { animation-delay: 0.4s; }
        
        input[type="text"], 
        input[type="file"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            margin-bottom: 15px;
            font-size: 14px;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        input[type="text"]:focus, 
        input[type="file"]:focus {
            outline: none;
            border-color: #0d47a1;
            box-shadow: 0 0 0 3px rgba(13, 71, 161, 0.2);
            transform: translateY(-2px);
        }
        
        button {
            background-color: #0d47a1;
            color: #fff;
            border: none;
            padding: 14px;
            width: 100%;
            border-radius: 6px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            margin-top: 10px;
            font-size: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        
        button:hover {
            background-color: #1565c0;
            transform: translateY(-3px);
            box-shadow: 0 7px 14px rgba(0,0,0,0.15);
        }
        
        button:active {
            transform: translateY(1px);
        }
        
        .file-input-container {
            position: relative;
            overflow: hidden;
            margin-bottom: 15px;
        }
        
        .file-input-label {
            display: block;
            padding: 12px;
            border: 2px dashed #ddd;
            border-radius: 6px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #f9f9f9;
        }
        
        .file-input-label:hover {
            border-color: #0d47a1;
            background-color: #e3f2fd;
        }
        
        .file-input {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="form-container">
    <h2><span>✏️</span> Edit Barang</h2>
    <form action="proses_edit.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $data['id'] ?>">

        <label for="nama_barang">Nama Barang</label>
        <input type="text" name="nama_barang" id="nama_barang" 
               value="<?= htmlspecialchars($data['nama_barang']) ?>" required>

        <label for="no_barang">Jumlah Barang</label>
        <input type="text" name="no_barang" id="no_barang" 
               value="<?= htmlspecialchars($data['no_barang']) ?>" required>

        <label for="tipe">Tipe</label>
        <input type="text" name="tipe" id="tipe" 
               value="<?= htmlspecialchars($data['tipe']) ?>" required>

        <label for="gambar">Ganti Foto (Opsional)</label>
        <div class="file-input-container">
            <label class="file-input-label" for="gambar">
                📷 Klik untuk memilih file
                <input type="file" name="gambar" id="gambar" class="file-input">
            </label>
        </div>

        <button type="submit">
            <span>💾</span> Simpan Perubahan
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add animation to form elements when focused
    const inputs = document.querySelectorAll('input[type="text"]');
    inputs.forEach(input => {
        input.addEventListener('focus', () => {
            input.style.transform = 'translateY(-2px)';
            input.style.boxShadow = '0 5px 15px rgba(0,0,0,0.1)';
        });
        
        input.addEventListener('blur', () => {
            input.style.transform = '';
            input.style.boxShadow = '';
        });
    });
    
    // Add click effect to button
    const button = document.querySelector('button');
    button.addEventListener('mousedown', () => {
        button.style.transform = 'translateY(1px)';
    });
    
    button.addEventListener('mouseup', () => {
        button.style.transform = 'translateY(-3px)';
    });
});
</script>
</body>
</html>