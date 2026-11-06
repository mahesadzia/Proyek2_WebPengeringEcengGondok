
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - Eceng Gondok</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f8faf7;
            color: #285d25;
        }

        /* LAYOUT */
        .container {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 265px;
            min-height: 100vh;
            background: linear-gradient(180deg, #55bb3d, #39802d);
            color: white;
            padding: 25px 10px;
            display: flex;
            flex-direction: column;
            flex-shrink: 0;
        }

        .logo {
            text-align: center;
            font-size: 25px;
            font-weight: 800;
            font-style: italic;
            color: white;
            border-bottom: 4px solid rgba(255,255,255,.8);
            padding: 8px 0 35px;
            margin-bottom: 25px;
        }

        .nav-menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .nav-menu a {
            display: flex;
            align-items: center;
            gap: 15px;
            color: white;
            text-decoration: none;
            padding: 12px;
            border-radius: 12px;
            font-size: 17px;
            transition: .3s;
        }

        .nav-menu a:hover,
        .nav-menu a.active {
            background: rgba(255,255,255,.35);
        }

        .nav-menu svg {
            width: 25px;
            height: 25px;
        }

        .sidebar-footer {
            margin-top: auto;
            padding: 20px 10px;
            text-align: center;
            font-size: 12px;
            color: rgba(255,255,255,.9);
        }

        /* MAIN CONTENT */
        .main-content {
            flex: 1;
            min-width: 0;
        }

        /* HEADER */
        .header {
            height: 105px;
            padding: 0 30px;
            background: white;
            border-bottom: 3px solid #ddd;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            font-size: 30px;
            font-weight: 700;
            color: #306c28;
        }

        .account-btn {
            border: none;
            background: linear-gradient(120deg, #9bd68d, #527b4b);
            color: white;
            padding: 12px 25px;
            border-radius: 10px;
            font-size: 17px;
            cursor: pointer;
        }

        /* CONTENT */
        .content {
            padding: 55px 35px;
        }

        .profile-card {
            background: white;
            border: 2px solid #285d25;
            border-radius: 13px;
            padding: 35px;
            box-shadow: 0 4px 15px rgba(0,0,0,.04);
        }

        .card-heading {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .card-heading h2 {
            font-size: 23px;
            color: #285d25;
        }

        .card-heading p {
            font-size: 13px;
            color: #777;
        }

        .edit-btn,
        .save-btn {
            border: none;
            padding: 12px 25px;
            border-radius: 9px;
            background: linear-gradient(120deg, #91cf7d, #397d2e);
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: .3s;
        }

        .edit-btn:hover,
        .save-btn:hover {
            opacity: .85;
        }

        .profile-content {
            display: flex;
            align-items: center;
            gap: 50px;
        }

        /* AVATAR */
        .avatar-wrapper {
            position: relative;
            flex-shrink: 0;
        }

        .avatar {
            width: 145px;
            height: 145px;
            border-radius: 18px;
            background: linear-gradient(135deg, #9cda8d, #438b34);
            border: 2px solid #39752e;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-size: 75px;
            font-weight: 700;
        }

        /* FORM */
        .profile-form {
            flex: 1;
            min-width: 0;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 15px;
            color: #39752e;
            margin-bottom: 5px;
        }

        .form-group input {
            width: 100%;
            padding: 10px 12px;
            border: none;
            border-bottom: 1px solid #444;
            outline: none;
            font-size: 18px;
            color: #285d25;
            font-weight: 600;
            background: transparent;
        }

        .form-group input:read-only {
            font-style: italic;
        }

        .form-group input:focus {
            border-bottom: 2px solid #55bb3d;
        }

        .form-group input:disabled {
            color: #285d25;
            opacity: 1;
        }

        /* PASSWORD */
        .password-wrapper {
            position: relative;
        }

        .password-wrapper input {
            padding-right: 75px;
        }

        .show-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #438b34;
            cursor: pointer;
            font-size: 12px;
        }

        /* BUTTON AREA */
        .button-area {
            display: none;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 25px;
        }

        .cancel-btn {
            padding: 11px 23px;
            border: 1px solid #aaa;
            border-radius: 8px;
            background: white;
            color: #555;
            cursor: pointer;
        }

        .save-btn {
            padding: 11px 23px;
        }

        /* INFORMATION */
        .information {
            margin-top: 30px;
            padding: 17px;
            background: #eaf5e6;
            border-radius: 10px;
            color: #39752e;
            font-size: 13px;
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                width: 75px;
                padding: 20px 8px;
            }

            .logo {
                font-size: 0;
                padding-bottom: 25px;
            }

            .nav-menu a {
                justify-content: center;
                padding: 12px 5px;
            }

            .nav-menu a span,
            .sidebar-footer {
                display: none;
            }

            .header {
                height: 80px;
                padding: 0 15px;
            }

            .header h1 {
                font-size: 21px;
            }

            .account-btn {
                padding: 9px 12px;
                font-size: 13px;
            }

            .content {
                padding: 25px 15px;
            }

            .profile-card {
                padding: 20px;
            }

            .card-heading {
                align-items: flex-start;
                gap: 10px;
            }

            .card-heading h2 {
                font-size: 18px;
            }

            .profile-content {
                flex-direction: column;
                gap: 25px;
            }

            .avatar {
                width: 110px;
                height: 110px;
                font-size: 55px;
            }

            .profile-form {
                width: 100%;
            }

            .form-group input {
                font-size: 15px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            ECENG GONDOK
        </div>

        <nav class="nav-menu">

            <a href="{{ url('/beranda') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 10L12 3L21 10V21H14V14H10V21H3Z"/>
                </svg>
                <span>Beranda</span>
            </a>

            <a href="{{ url('/batch') }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 2L22 7.5V16.5L12 22L2 16.5V7.5L12 2Z"/>
                    <path d="M2 7.5L12 13L22 7.5M12 13V22"/>
                </svg>
                <span>Batch</span>
            </a>

            <a href="{{ url('/pengaturan') }}" class="active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15A1.7 1.7 0 0020 17l-1.5 2.6a1.7 1.7 0 00-2-.3 1.7 1.7 0 00-1 1.7h-3a1.7 1.7 0 00-1-1.7 1.7 1.7 0 00-2 .3L8 17a1.7 1.7 0 00.6-2L7 13.5a1.7 1.7 0 00-1.7-1v-3a1.7 1.7 0 001.7-1 1.7 1.7 0 00-.3-2L8 4a1.7 1.7 0 002 .6 1.7 1.7 0 001-1.7h3a1.7 1.7 0 001 1.7 1.7 1.7 0 002-.6l1.5 2.6a1.7 1.7 0 00-.6 2 1.7 1.7 0 001.7 1v3a1.7 1.7 0 00-1.7 1z"/>
                </svg>
                <span>Pengaturan</span>
            </a>

        </nav>

        <div class="sidebar-footer">
            © 2026 Eceng Gondok<br>
            Monitoring Kadar Air
        </div>

    </aside>


    <!-- MAIN CONTENT -->
    <main class="main-content">

        <!-- HEADER -->
        <header class="header">

            <h1>Pengaturan</h1>

            <button class="account-btn">
                ♙ &nbsp; Akun
            </button>

        </header>


        <!-- CONTENT -->
        <section class="content">

            <div class="profile-card">

                <div class="card-heading">

                    <div>
                        <h2>Profil Pengguna</h2>
                        <p>Informasi akun yang terdaftar pada sistem.</p>
                    </div>

                    <button class="edit-btn" id="editBtn" onclick="enableEdit()">
                        ✎ Ubah
                    </button>

                </div>


                <div class="profile-content">

                    <!-- AVATAR -->
                    <div class="avatar-wrapper">
                        <div class="avatar" id="avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>
                    </div>


                    <!-- FORM PROFILE -->
                    <form class="profile-form"
                          id="profileForm"
                          action="{{ route('pengaturan.update') }}"
                          method="POST">

                        @csrf
                        @method('PUT')

                        <div class="form-group">

                            <label>Nama Pengguna</label>

                            <input
                                type="text"
                                name="name"
                                id="username"
                                value="{{ auth()->user()->name ?? '' }}"
                                readonly
                                required
                            >

                        </div>


                        <div class="form-group">

                            <label>Password Baru</label>

                            <div class="password-wrapper">

                                <input
                                    type="password"
                                    name="password"
                                    id="password"
                                    placeholder="Kosongkan jika tidak diubah"
                                    readonly
                                >

                                <button
                                    type="button"
                                    class="show-password"
                                    id="showPassword"
                                    onclick="togglePassword()"
                                    style="display:none">
                                    Lihat
                                </button>

                            </div>

                        </div>


                        <div class="button-area" id="buttonArea">

                            <button
                                type="button"
                                class="cancel-btn"
                                onclick="cancelEdit()">
                                Batal
                            </button>

                            <button type="submit" class="save-btn">
                                Simpan Perubahan
                            </button>

                        </div>

                    </form>

                </div>


                <!-- INFORMATION -->
                <div class="information">
                    <strong>ⓘ Informasi:</strong>
                    Untuk mengubah data akun, klik tombol <b>Ubah</b>.
                    Pastikan data yang dimasukkan sudah benar sebelum disimpan.
                </div>

            </div>

        </section>

    </main>

</div>


<!-- JAVASCRIPT -->
<script>

    const username = document.getElementById('username');
    const password = document.getElementById('password');
    const editBtn = document.getElementById('editBtn');
    const buttonArea = document.getElementById('buttonArea');
    const showPasswordBtn = document.getElementById('showPassword');

    let originalUsername = username.value;

    // AKTIFKAN MODE EDIT
    function enableEdit() {

        username.removeAttribute('readonly');
        password.removeAttribute('readonly');

        username.focus();

        password.placeholder = 'Masukkan password baru';

        editBtn.style.display = 'none';
        buttonArea.style.display = 'flex';
        showPasswordBtn.style.display = 'block';

    }


    // BATAL EDIT
    function cancelEdit() {

        username.value = originalUsername;
        password.value = '';

        username.setAttribute('readonly', true);
        password.setAttribute('readonly', true);

        password.type = 'password';
        password.placeholder = 'Kosongkan jika tidak diubah';

        editBtn.style.display = 'block';
        buttonArea.style.display = 'none';
        showPasswordBtn.style.display = 'none';

    }


    // LIHAT PASSWORD
    function togglePassword() {

        if (password.type === 'password') {

            password.type = 'text';
            showPasswordBtn.textContent = 'Sembunyikan';

        } else {

            password.type = 'password';
            showPasswordBtn.textContent = 'Lihat';

        }

    }

</script>

</body>
</html>
