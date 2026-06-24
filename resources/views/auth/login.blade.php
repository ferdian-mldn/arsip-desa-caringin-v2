<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Pengarsipan Desa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root { --accent: #FFD600;
            --navy: #0F9D58;
            --steel: #34A853;
            --offwhite: #F5F7FA;
            --text-main: #000000;
            --softgray: #E5E7EB;
            --gold: #C9A24D;
            --gold-light: #E6D3A6;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--offwhite);
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%230A2540' fill-opacity='0.03' fill-rule='evenodd'/%3E%3C/svg%3E");
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        
        .login-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(15, 157, 88, 0.1);
            overflow: hidden;
            border: 1px solid var(--softgray);
            max-width: 440px;
            width: 100%;
        }
        
        .login-header {
            background: linear-gradient(135deg, var(--navy) 0%, var(--steel) 100%);
            padding: 2.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }
        
        .login-header::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }
        
        .login-header::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -30%;
            width: 150px;
            height: 150px;
            border-radius: 50%;
            background: rgba(201, 162, 77, 0.1);
        }
        
        .logo-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            position: relative;
            z-index: 2;
        }
        
        .logo-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--navy);
            font-size: 1.5rem;
            box-shadow: 0 10px 20px rgba(201, 162, 77, 0.2);
        }
        
        .logo-text {
            text-align: left;
        }
        
        .form-container {
            padding: 2.5rem;
        }
        
        .input-field {
            width: 100%;
            padding: 0.875rem 1.25rem;
            border-radius: 10px;
            border: 1px solid var(--softgray);
            background-color: white;
            font-family: 'Inter', sans-serif;
            font-size: 0.95rem;
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(201, 162, 77, 0.1);
        }
        
        .input-group {
            margin-bottom: 1.5rem;
        }
        
        .input-label {
            display: block;
            font-weight: 500;
            color: var(--navy);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }
        
        .btn-login {
            width: 100%;
            padding: 1rem;
            border-radius: 10px;
            border: none;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--navy) 0%, var(--steel) 100%);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(15, 157, 88, 0.2);
        }
        
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        
        .checkbox-input {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 1px solid var(--softgray);
            margin-right: 0.75rem;
            cursor: pointer;
            accent-color: var(--gold);
        }
        
        .checkbox-label {
            color: var(--steel);
            font-size: 0.9rem;
            cursor: pointer;
        }
        
        .alert-error {
            background: linear-gradient(135deg, rgba(239, 68, 68, 0.1) 0%, rgba(239, 68, 68, 0.05) 100%);
            border-left: 4px solid #ef4444;
            padding: 1.25rem;
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        
        .alert-title {
            font-weight: 600;
            color: #dc2626;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .error-list {
            list-style-type: none;
            padding-left: 0;
            margin: 0;
        }
        
        .error-item {
            color: #b91c1c;
            font-size: 0.875rem;
            padding: 0.25rem 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .footer-text {
            text-align: center;
            color: var(--steel);
            font-size: 0.875rem;
            margin-top: 2rem;
            padding-top: 1.5rem;
            border-top: 1px solid var(--softgray);
        }
        
        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--steel);
            cursor: pointer;
            padding: 0.25rem;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        @media (max-width: 480px) {
            .login-card {
                max-width: 100%;
            }
            
            .form-container {
                padding: 2rem;
            }
            
            .login-header {
                padding: 2rem;
            }
        }
        .bg-accent { background-color: var(--accent); }
    .text-accent { color: var(--accent); }
</style>
</head>
<body>
    <div class="login-card">
        <!-- Header -->
        <div class="login-header">
            <div class="logo-container">
                <div class="logo-icon">
                    <i class="fas fa-archive"></i>
                </div>
                <div class="logo-text">
                    <h1 class="text-2xl font-bold text-white mb-1">SIPE DESA</h1>
                    <p class="text-sm text-gray-300">Sistem Pengarsipan Desa Caringin</p>
                </div>
            </div>
            <p class="text-gray-300 text-sm relative z-10">Masuk ke sistem pengarsipan digital</p>
        </div>
        
        <!-- Form Container -->
        <div class="form-container">
            @if ($errors->any())
            <div class="alert-error">
                <p class="alert-title">
                    <i class="fas fa-exclamation-circle"></i>
                    Login Gagal
                </p>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li class="error-item">
                            <i class="fas fa-times-circle"></i>
                            {{ $error }}
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{ route('login.process') }}" id="loginForm">
                @csrf
                
                <div class="input-group">
                    <label class="input-label" for="username">
                        <i class="fas fa-user mr-2"></i>
                        Username
                    </label>
                    <div class="input-wrapper">
                        <input class="input-field" 
                               id="username" 
                               type="text" 
                               name="username" 
                               placeholder="Masukkan username" 
                               value="{{ old('username') }}" 
                               required 
                               autofocus>
                    </div>
                </div>

                <div class="input-group">
                    <label class="input-label" for="password">
                        <i class="fas fa-lock mr-2"></i>
                        Password
                    </label>
                    <div class="input-wrapper">
                        <input class="input-field" 
                               id="password" 
                               type="password" 
                               name="password" 
                               placeholder="Masukkan password" 
                               required>
                        <button type="button" class="password-toggle" id="togglePassword">
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <div class="checkbox-container">
                    <input class="checkbox-input" 
                           id="remember" 
                           name="remember" 
                           type="checkbox">
                    <label class="checkbox-label" for="remember">
                        Ingat Saya
                    </label>
                </div>

                <button class="btn-login btn-primary" type="submit" id="loginButton">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>MASUK KE SISTEM</span>
                </button>
            </form>

            <div class="footer-text">
                <p>© {{ date('Y') }} Pemerintah Desa Caringin • Kabupaten Sukabumi</p>
                <p class="mt-1 text-xs opacity-70">Hanya untuk akses perangkat desa yang berwenang</p>
            </div>
        </div>
    </div>

    <script>
        // Toggle password visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = togglePassword.querySelector('i');
        
        togglePassword.addEventListener('click', function() {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle eye icon
            if (type === 'text') {
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
        
        // Form submission animation
        const loginForm = document.getElementById('loginForm');
        const loginButton = document.getElementById('loginButton');
        
        loginForm.addEventListener('submit', function(e) {
            // Add loading state to button
            loginButton.innerHTML = '<i class="fas fa-spinner fa-spin"></i><span>MEMPROSES...</span>';
            loginButton.disabled = true;
            
            // Prevent double submission
            setTimeout(() => {
                if (!loginForm.checkValidity()) {
                    loginButton.innerHTML = '<i class="fas fa-sign-in-alt"></i><span>MASUK KE SISTEM</span>';
                    loginButton.disabled = false;
                }
            }, 2000);
        });
        
        // Add focus effects to inputs
        const inputs = document.querySelectorAll('.input-field');
        inputs.forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.classList.add('ring-2', 'ring-opacity-20');
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.classList.remove('ring-2', 'ring-opacity-20');
            });
        });
        
        // Auto-focus username field if empty
        document.addEventListener('DOMContentLoaded', function() {
            const usernameField = document.getElementById('username');
            if (usernameField && !usernameField.value) {
                usernameField.focus();
            }
        });
    </script>
</body>
</html>