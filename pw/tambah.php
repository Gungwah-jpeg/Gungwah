<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Barang</title>
    <style>
        :root {
            --primary: #4361ee;
            --primary-light: #e6e9ff;
            --secondary: #6c757d;
            --text: #333;
            --background: rgb(13, 71, 161);
            --card: #ffffff;
            --border: #e0e0e0;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes slideIn {
            from { transform: translateX(-20px); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-5px); }
            100% { transform: translateY(0px); }
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: var(--background);
            color: var(--text);
            margin: 0;
            padding: 20px;
            font-size: 14px;
            animation: fadeIn 0.6s ease-out;
        }
        
        .container {
            max-width: 480px;
            margin: 20px auto;
            background: var(--card);
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            border: 1px solid var(--border);
            animation: slideIn 0.5s cubic-bezier(0.25, 0.8, 0.25, 1);
            transition: all 0.3s ease;
        }

        .container:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
        }
        
        h2 {
            color: var(--primary);
            margin: 0 0 25px 0;
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        h2 span {
            display: inline-block;
            animation: float 3s ease-in-out infinite;
        }
        
        .form-group {
            margin-bottom: 18px;
            animation: fadeIn 0.5s ease-out;
            animation-fill-mode: both;
        }

        /* Staggered animation for form groups */
        .form-group:nth-child(1) { animation-delay: 0.1s; }
        .form-group:nth-child(2) { animation-delay: 0.2s; }
        .form-group:nth-child(3) { animation-delay: 0.3s; }
        .form-group:nth-child(4) { animation-delay: 0.4s; }
        
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--text);
            font-size: 14px;
        }
        
        input[type="text"] {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            box-sizing: border-box;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        input[type="text"]:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px var(--primary-light);
            transform: translateY(-2px);
        }
        
        .btn {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .btn:active {
            transform: translateY(1px);
        }
        
        .btn-secondary {
            background-color: var(--secondary);
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }
        
        .file-input-container {
            border: 2px dashed var(--border);
            border-radius: 8px;
            padding: 25px;
            text-align: center;
            cursor: pointer;
            background-color: #fafafa;
            transition: all 0.3s ease;
        }

        .file-input-container:hover {
            border-color: var(--primary);
            background-color: var(--primary-light);
            animation: pulse 1s ease-in-out;
        }
        
        .file-input-text {
            color: #777;
            margin-top: 10px;
            font-size: 12px;
        }
        
        .file-input {
            display: none;
        }
        
        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }
        
        .button-group .btn {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>
            <span>➕</span>
            Tambah Barang
        </h2>
        
        <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="no_barang">No Barang</label>
                <input type="text" id="no_barang" name="no_barang" required placeholder="Nomor barang">
            </div>
            
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" name="nama_barang" required placeholder="Nama barang">
            </div>
            
            <div class="form-group">
                <label for="tipe">Tipe</label>
                <input type="text" id="tipe" name="tipe" required placeholder="Tipe barang">
            </div>
            
            <div class="form-group">
                <label for="gambar">Foto Barang</label>
                <label for="gambar" class="file-input-container">
                    <div>📷 Klik untuk upload</div>
                    <div class="file-input-text">JPG/PNG (max 2MB)</div>
                    <input type="file" id="gambar" name="gambar" class="file-input" accept="image/*">
                </label>
            </div>
            
            <div class="button-group">
                <a href="index.php" class="btn btn-secondary">
                    <span>←</span>
                    Kembali
                </a>
                <button type="submit" class="btn">
                    <span>💾</span>
                    Simpan
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation to input fields when focused
            const inputs = document.querySelectorAll('input[type="text"]');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    input.style.transform = 'translateY(-2px)';
                    input.style.boxShadow = '0 5px 15px rgba(67, 97, 238, 0.2)';
                });
                
                input.addEventListener('blur', () => {
                    input.style.transform = '';
                    input.style.boxShadow = '';
                });
            });
            
            // Add click effect to buttons
            const buttons = document.querySelectorAll('.btn');
            buttons.forEach(btn => {
                btn.addEventListener('mousedown', () => {
                    btn.style.transform = 'translateY(1px)';
                });
                
                btn.addEventListener('mouseup', () => {
                    btn.style.transform = 'translateY(-3px)';
                });
                
                btn.addEventListener('mouseleave', () => {
                    btn.style.transform = '';
                });
            });
            
            // Add file selection feedback
            const fileInput = document.querySelector('.file-input');
            const fileContainer = document.querySelector('.file-input-container');
            
            fileInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    fileContainer.innerHTML = '✓ ' + this.files[0].name + 
                                           '<div class="file-input-text">File terpilih</div>';
                    fileContainer.style.borderColor = '#43a047';
                    fileContainer.style.backgroundColor = '#e8f5e9';
                    
                    // Add temporary animation
                    fileContainer.style.animation = 'none';
                    void fileContainer.offsetWidth; // Trigger reflow
                    fileContainer.style.animation = 'pulse 0.5s ease-in-out';
                }
            });
        });
    </script>
</body>
</html>