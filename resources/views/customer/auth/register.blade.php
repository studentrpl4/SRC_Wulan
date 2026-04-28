@extends('layout.app')

@section('title', 'Login')

@section('content')
    <header class="flex items-center mb-20">
        <div class="p-2 bg-primary-green/20 rounded-lg mr-3">
            <img src="{{ asset('assets/images/logo_src wulan.png') }}" alt="Logo SRC Wulan" class="w-6 h-6 object-cover">
        </div>
        <h1 class="text-xl font-semibold text-gray-800">SRC Wulan 🏪</h1>
    </header>
    <div class="min-h-screen flex flex-col items-center pt-10">

        {{-- Login Box --}}
        <div class="w-full max-w-md px-3">

            <h2 class="text-3xl font-bold text-gray-800">Registrasi</h2>
            <p class="text-secondary-text text-sm mt-1 mb-6">Silahkan buat akun anda dengan masukan email</p>

            {{-- Alert for errors --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg animate-fade-in">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mt-2 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Email --}}
            <form action="{{ route('customer.auth.register') }}" method="POST">
                @csrf
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}"
                    class="w-full bg-white rounded-full py-3 px-5 text-gray-700 shadow-sm border border-gray-200 focus:ring-primary-green focus:ring-2 outline-none transition-all duration-300"
                    placeholder="Masukkan email anda">
                <div class="error-message mt-1" id="email-error">
                    @if($errors->has('email'))
                        {{ $errors->first('email') }}
                    @endif
                </div>

                {{-- Password --}}
                <label for="password" class="block text-sm font-semibold text-gray-700 mt-3 mb-1">Password</label>
                <div class="relative group">
                    <input type="password" id="password" name="password"
                        class="w-full bg-white rounded-full py-3 px-5 pr-12 text-gray-700 shadow-sm border border-gray-200 focus:ring-primary-green focus:ring-2 outline-none transition-all duration-300"
                        placeholder="Masukkan password anda">
                    
                    {{-- Eye Icon for Password Toggle --}}
                    <button type="button" class="togglePasswordBtn absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#e40312] transition-colors duration-300 focus:outline-none" data-target="password">
                        <!-- Eye Icon (Open) -->
                        <svg class="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" 
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <!-- Eye-Slash Icon (Hidden) -->
                        <svg class="eyeSlashIcon hidden" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" 
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
                <div class="error-message mt-1" id="password-error">
                    @if($errors->has('password'))
                        {{ $errors->first('password') }}
                    @endif
                </div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mt-3 mb-1">Konfirmasi Password</label>
                <div class="relative group">
                    <input type="password" id="password_confirmation" name="password_confirmation"
                        class="w-full bg-white rounded-full py-3 px-5 pr-12 text-gray-700 shadow-sm border border-gray-200 focus:ring-primary-green focus:ring-2 outline-none transition-all duration-300"
                        placeholder="Masukkan password anda">
                    
                    {{-- Eye Icon for Password Toggle --}}
                    <button type="button" class="togglePasswordBtn absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#e40312] transition-colors duration-300 focus:outline-none" data-target="password_confirmation">
                        <!-- Eye Icon (Open) -->
                        <svg class="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" 
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <!-- Eye-Slash Icon (Hidden) -->
                        <svg class="eyeSlashIcon hidden" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" 
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>
                <div class="error-message mt-1" id="password_confirmation-error">
                    @if($errors->has('password_confirmation'))
                        {{ $errors->first('password_confirmation') }}
                    @endif
                </div>

                {{-- Forget --}}
                <div class="text-right mt-2 mb-5">
                    {{-- <a href="#" class="text-secondary-text text-sm hover:text-primary-green">Lupa Password?</a> --}}
                </div>

                {{-- Register Button --}}
                <button id="registerBtn" type="submit"
                    class="w-full py-3 px-4 bg-gray-300 text-white rounded-full text-lg font-semibold cursor-not-allowed transition-all duration-300 ease-out transform hover:scale-105 active:scale-95 relative overflow-hidden disabled:hover:scale-100">
                    Register
                </button>
            </form>
            {{-- Register --}}
            <p class="text-center mt-4 text-secondary-text text-sm">
                Sudah punya akun?
                <a href="{{ route('customer.auth.login') }}" class="text-[#e40312] font-semibold">Login</a>
            </p>
        </div>

    </div>
    <style>
        /* Enhanced button effects */
        #registerBtn {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #registerBtn:not(:disabled):hover {
            box-shadow: 0 10px 15px rgba(228, 3, 18, 0.3);
            background-color: #e40312;
        }

        #registerBtn:not(:disabled):active {
            box-shadow: 0 2px 4px rgba(228, 3, 18, 0.2);
        }

        #registerBtn.bg-\[\#e40312\] {
            background-color: #e40312;
            color: white;
        }

        #registerBtn.bg-\[\#e40312\]:hover:not(:disabled) {
            background-color: #c40210;
        }

        #registerBtn.bg-\[\#e40312\]:active:not(:disabled) {
            background-color: #a60109;
        }

        /* Password field focus effect */
        #password:focus,
        #password_confirmation:focus {
            box-shadow: 0 0 0 3px rgba(228, 3, 18, 0.1);
            border-color: #e40312;
        }

        /* Error message styles */
        .error-message {
            color: #dc2626;
            font-size: 0.875rem;
            opacity: 0;
            transform: translateY(-5px);
            transition: all 0.3s ease;
            height: 0;
            overflow: hidden;
        }

        .error-message.show {
            opacity: 1;
            transform: translateY(0);
            height: auto;
        }

        /* Error input styles */
        input.error {
            border-color: #dc2626 !important;
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.1) !important;
        }

        /* Alert animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
    </style>

    <script>
        const email = document.getElementById("email");
        const password = document.getElementById("password");
        const passwordConfirmation = document.getElementById("password_confirmation");
        const registerBtn = document.getElementById("registerBtn");
        const form = document.querySelector("form");

        // Toggle password visibility for both fields
        document.querySelectorAll(".togglePasswordBtn").forEach(btn => {
            btn.addEventListener("click", function(e) {
                e.preventDefault();
                const target = document.getElementById(this.dataset.target);
                const isPassword = target.getAttribute("type") === "password";
                
                target.setAttribute("type", isPassword ? "text" : "password");
                
                // Toggle icons
                const eyeIcon = this.querySelector(".eyeIcon");
                const eyeSlashIcon = this.querySelector(".eyeSlashIcon");
                eyeIcon.classList.toggle("hidden", !isPassword);
                eyeSlashIcon.classList.toggle("hidden", isPassword);
            });
        });

        // Validation functions
        function validateEmail() {
            const value = email.value.trim();
            const errorDiv = document.getElementById("email-error");
            let message = "";

            if (value === "") {
                message = "Email wajib diisi.";
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value)) {
                message = "Format email tidak valid.";
            }

            showError(errorDiv, message);
            email.classList.toggle("error", message !== "");
            return message === "";
        }

        function validatePassword() {
            const value = password.value;
            const errorDiv = document.getElementById("password-error");
            let message = "";

            if (value === "") {
                message = "Password wajib diisi.";
            } else if (value.length < 8) {
                message = "Password minimal 8 karakter.";
            } else if (!/(?=.*[a-zA-Z])(?=.*\d)/.test(value)) {
                message = "Password harus mengandung huruf dan angka.";
            }

            showError(errorDiv, message);
            password.classList.toggle("error", message !== "");
            return message === "";
        }

        function validatePasswordConfirmation() {
            const value = passwordConfirmation.value;
            const errorDiv = document.getElementById("password_confirmation-error");
            let message = "";

            if (value === "") {
                message = "Konfirmasi password wajib diisi.";
            } else if (value !== password.value) {
                message = "Konfirmasi password tidak cocok.";
            }

            showError(errorDiv, message);
            passwordConfirmation.classList.toggle("error", message !== "");
            return message === "";
        }

        function showError(errorDiv, message) {
            if (message) {
                errorDiv.textContent = message;
                errorDiv.classList.add("show");
            } else {
                errorDiv.classList.remove("show");
                setTimeout(() => {
                    errorDiv.textContent = "";
                }, 300);
            }
        }

        function validateAll() {
            const emailValid = validateEmail();
            const passwordValid = validatePassword();
            const confirmationValid = validatePasswordConfirmation();

            const isValid = emailValid && passwordValid && confirmationValid;

            if (isValid) {
                registerBtn.classList.remove("bg-gray-300", "cursor-not-allowed");
                registerBtn.classList.add("bg-[#e40312]", "cursor-pointer");
                registerBtn.disabled = false;
            } else {
                registerBtn.classList.add("bg-gray-300", "cursor-not-allowed");
                registerBtn.classList.remove("bg-[#e40312]", "cursor-pointer");
                registerBtn.disabled = true;
            }
        }

        // Event listeners
        email.addEventListener("input", () => {
            validateEmail();
            validateAll();
        });
        password.addEventListener("input", () => {
            validatePassword();
            validatePasswordConfirmation(); // Re-validate confirmation when password changes
            validateAll();
        });
        passwordConfirmation.addEventListener("input", () => {
            validatePasswordConfirmation();
            validateAll();
        });

        // Form submit loading state
        form.addEventListener("submit", function() {
            registerBtn.disabled = true;
            registerBtn.textContent = "Mendaftarkan...";
        });
        
        // Initial validation
        validateAll();

        // Show backend errors on load
        document.addEventListener("DOMContentLoaded", function() {
            ["email", "password", "password_confirmation"].forEach(field => {
                const errorDiv = document.getElementById(field + "-error");
                if (errorDiv.textContent.trim()) {
                    errorDiv.classList.add("show");
                    document.getElementById(field).classList.add("error");
                }
            });
            validateAll();

            // Focus on first error field
            const firstErrorField = ["email", "password", "password_confirmation"].find(field => document.getElementById(field + "-error").textContent.trim());
            if (firstErrorField) {
                document.getElementById(firstErrorField).focus();
            }

            // Reset button state
            registerBtn.disabled = false;
            registerBtn.textContent = "Register";
        });
    </script>
@endsection