@extends('layout.app')

@section('title', 'Login')

@section('content')
    <header class="flex items-center mb-20 mt-5">
        <div class="p-2 bg-primary-green/20 rounded-lg mr-3">
            <img src="{{ asset('assets/images/logo_src wulan.png') }}" alt="Logo SRC Wulan" class="w-6 h-6 object-cover">
        </div>
        <h1 class="text-xl font-semibold text-gray-800">SRC Wulans</h1>
    </header>
    <div class="min-h-screen flex flex-col items-center pt-10">

        {{-- Login Box --}}
        <div class="w-full max-w-md px-3">

            <h2 class="text-3xl font-bold text-gray-800">Login</h2>
            <p class="text-secondary-text text-sm mt-1 mb-6">Masukkan username anda</p>

            {{-- Username --}}
            <form action="{{ route('customer.auth.login') }}" method="POST" id="loginForm">
                @csrf
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1">Username</label>
                <input type="email" id="email" name="email"
                    class="w-full bg-white rounded-full py-3 px-5 text-gray-700 shadow-sm border border-gray-200 focus:ring-primary-green focus:ring-2 outline-none"
                    placeholder="Masukkan email anda">

                {{-- Password --}}
                <label for="password" class="block text-sm font-semibold text-gray-700 mt-5 mb-1">Password</label>
                <div class="relative group">
                    <input type="password" id="password" name="password"
                        class="w-full bg-white rounded-full py-3 px-5 pr-12 text-gray-700 shadow-sm border border-gray-200 focus:ring-primary-green focus:ring-2 outline-none transition-all duration-300"
                        placeholder="Masukkan password anda">
                    
                    {{-- Eye Icon for Password Toggle --}}
                    <button type="button" id="togglePassword" 
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#e40312] transition-colors duration-300 focus:outline-none">
                        <!-- Eye Icon (Open) -->
                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" 
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                        <!-- Eye-Slash Icon (Hidden) -->
                        <svg id="eyeSlashIcon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" 
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden">
                            <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                    </button>
                </div>

                {{-- Forget --}}
                <div class="text-right mt-2 mb-5">
                    <a href="#"
                        class="text-secondary-text text-sm hover:text-primary-green">Lupa Password?</a>
                </div>

                {{-- Login Button --}}
                <button id="loginBtn" type="submit"
                    class="w-full py-3 px-4 bg-gray-300 text-white rounded-full text-lg font-semibold cursor-not-allowed transition-all duration-300 ease-out transform hover:scale-105 active:scale-95 relative overflow-hidden disabled:hover:scale-100">
                    Login
                </button>
            </form>
            {{-- Register --}}
            <p class="text-center mt-4 text-secondary-text text-sm">
                Belum punya akun?
                <a href="{{ route('customer.auth.register') }}" class="text-[#e40312] font-semibold">Daftar</a>
            </p>
        </div>

    </div>
    <style>
        /* Enhanced button effects */
        #loginBtn {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #loginBtn:not(:disabled):hover {
            box-shadow: 0 10px 15px rgba(228, 3, 18, 0.3);
            background-color: #e40312;
        }

        #loginBtn:not(:disabled):active {
            box-shadow: 0 2px 4px rgba(228, 3, 18, 0.2);
        }

        #loginBtn.bg-\[\#e40312\] {
            background-color: #e40312;
            color: white;
        }

        #loginBtn.bg-\[\#e40312\]:hover:not(:disabled) {
            background-color: #c40210;
        }

        #loginBtn.bg-\[\#e40312\]:active:not(:disabled) {
            background-color: #a60109;
        }

        /* Password field focus effect */
        #password:focus {
            box-shadow: 0 0 0 3px rgba(228, 3, 18, 0.1);
            border-color: #e40312;
        }

        /* Smooth animation */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-2px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>

    <script>
        const username = document.getElementById("email");
        const password = document.getElementById("password");
        const loginBtn = document.getElementById("loginBtn");
        const togglePasswordBtn = document.getElementById("togglePassword");
        const eyeIcon = document.getElementById("eyeIcon");
        const eyeSlashIcon = document.getElementById("eyeSlashIcon");
        const form = document.getElementById("loginForm");

        // Toggle password visibility
        togglePasswordBtn.addEventListener("click", function(e) {
            e.preventDefault();
            const isPassword = password.getAttribute("type") === "password";
            
            password.setAttribute("type", isPassword ? "text" : "password");
            eyeIcon.classList.toggle("hidden", !isPassword);
            eyeSlashIcon.classList.toggle("hidden", isPassword);
        });

        // Prevent form submission if password field is empty and showing
        togglePasswordBtn.addEventListener("keydown", function(e) {
            if (e.key === "Enter") {
                e.preventDefault();
            }
        });

        function toggleButton() {
            if (username.value.trim() !== "" && password.value.trim() !== "") {
                loginBtn.classList.remove("bg-gray-300", "cursor-not-allowed");
                loginBtn.classList.add("bg-[#e40312]", "cursor-pointer");
                loginBtn.disabled = false;
            } else {
                loginBtn.classList.add("bg-gray-300", "cursor-not-allowed");
                loginBtn.classList.remove("bg-[#e40312]", "cursor-pointer");
                loginBtn.disabled = true;
            }
        }



        username.addEventListener("input", toggleButton);
        password.addEventListener("input", toggleButton);
        
        // Initial state
        toggleButton();
    </script>
@endsection