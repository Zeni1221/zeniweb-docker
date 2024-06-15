<?php
    include 'cek_koneksi.php' ;
    session_start();
 
    if (isset($_POST['submit'])) {
        $email = $_POST['email'] ;
        $password = $_POST['password']; // Hash the input password using SHA-256
        
        //ambil data terbesar 
        $char = 'USER';
        $query = mysqli_query($conn,"SELECT max(id) as max_kode FROM login WHERE id LIKE '{$char}%' ORDER BY id DESC LIMIT 1");
        $data = mysqli_fetch_array($query);
        $kodeBarang = $data['max_kode'];

        //mengambil data menggunakan fungsi subtr, 
        //misal data BRG001 akan diambil 001 
        $no = substr($kodeBarang, -3, 3);

        //setelah substring bilangan diambil lantas dicasting menjadi integer
        $no = (int) $no;

        //bilangan yang diambil akan ditambah 1 untuk menentukan nomor urut berikutnya
        $no += 1;

        //perintah sprintf("%03s", $no) berguna untuk membuat string menjadi 3 karakter
        $newKodeBarang = $char . sprintf("%03s", $no);
        
        $username = "sjaojso";

        $sql = "INSERT INTO login VALUES ('$newKodeBarang', '$email', '$username','$password')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Query berhasil dieksekusi
            // Lakukan tindakan yang diperlukan
            $_SESSION['username'] = $username; // Menyimpan username dalam session
            echo "berhasill"; // Pesan untuk pengguna (opsional)
            header("Location: ../index.html"); // Arahkan pengguna ke halaman beranda
            exit(); // Hentikan eksekusi skrip
        } else {
            // Query gagal dieksekusi
            // Tampilkan pesan kesalahan atau lakukan tindakan lainnya
            echo "Error: " . mysqli_error($conn);
        }
        
        
        if($result){
            if ($result->num_rows > 0) {
                $row = mysqli_fetch_assoc($result);
                $_SESSION['username'] = $row['username'];
                echo "berhasill";
                header("Location: ../index.html");
                exit();
            } else {
                echo "<script>alert('Email atau password Anda salah. Silakan coba lagi!')</script>";
            }
        }
        
    }
?>

<!DOCTYPE html>
<html>
<head>
  <title>SIGN UP</title>
  <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
  <style>
        body {
            background: -webkit-linear-gradient(bottom, #78b1fc, #4609e0);
            background-repeat: no-repeat;
        }
        #card {
            background: #fbfbfb;
            border-radius: 8px;
            box-shadow: 1px 2px 8px rgba(0, 0, 0, 0.65);
            height: 410px;
            margin: 6rem auto 8.1rem auto;
            width: 329px;

            #card-content {
            padding: 12px 44px;
        }
        #card-title {
            font-family: "Raleway Thin", sans-serif;
            letter-spacing: 4px;
            padding-bottom: 23px;
            padding-top: 13px;
            text-align: center;
        }
        .underline-title {
            background: -webkit-linear-gradient(right, #78b1fc, #4609e0);
            height: 2px;
            margin: -1.1rem auto 0 auto;
            width: 89px;
        }
        a {
            text-decoration: none;
        }
        label {
            font-family: "Raleway", sans-serif;
            font-size: 11pt;
        }
        #forgot-pass {
            color: #ff3705;
            font-family: "Raleway", sans-serif;
            font-size: 10pt;
            margin-top: 3px;
            text-align: right;
        }
        .form {
            align-items: left;
            display: flex;
            flex-direction: column;
        }
        .form-border {
            background: -webkit-linear-gradient(right, #78b1fc, #4609e0);
            height: 1px;
            width: 100%;
        }
        .form-content {
            background: #fbfbfb;
            border: none;
            outline: none;
            padding-top: 14px;
        }
        #signup {
            color: #ff3705;
            font-family: "Raleway", sans-serif;
            font-size: 10pt;
            margin-top: 16px;
            text-align: center;
        }
        #submit-btn {
            background: -webkit-linear-gradient(right, #78b1fc, #4609e0);
            border: none;
            border-radius: 21px;
            box-shadow: 0px 1px 8px #010e04;
            cursor: pointer;
            color: white;
            font-family: "Raleway SemiBold", sans-serif;
            height: 42.3px;
            margin: 0 auto;
            margin-top: 50px;
            transition: 0.25s;
            width: 153px;
        }
        #submit-btn:hover {
            box-shadow: 0px 1px 18px #010e04;
        }
        }
        </style>
</head>
<body>
<div id="card">
    <div id="card-title">
        <h2>SIGN UP</h2>
        <div class="underline-title"></div>
        <form method="post" class="form"> 
            <label for="user-email" style="padding-top:13px">&nbsp;Email</label>
  <input
   id="user-email"
   class="form-content"
   type="email"
   name="email"
   autocomplete="on"
   required />
  <div class="form-border"></div>
<label for="user-password" style="padding-top:22px">&nbsp;Password</label>
  <input
   id="user-password"
   class="form-content"
   type="password"
   name="password"
   required />
  <div class="form-border"></div>
<input id="submit-btn" type="submit" name="submit" value="submit" />
        </form>
      </div>
</div>
 </body>
</html>
