@extends('layout.app')

@section('title', 'Login')

@section('content')

    <div class="min-h-screen flex flex-col items-center pt-10">

        {{-- Login Box --}}
        <div class="w-full max-w-md px-3">

            <h2 class="text-3xl font-bold text-gray-800">Set Up Profile</h2>
            <p class="text-secondary-text text-sm mt-1 mb-6">Silahkan data anda</p>

            {{-- Username --}}
            <form action="{{ route('customer.setupProfile') }}" method="POST">
                @csrf
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Nama lengkap</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}"
                    class="w-full bg-white rounded-full py-3 px-5 text-gray-700 shadow-sm border border-gray-200 focus:ring-primary-green focus:ring-2 outline-none"
                    placeholder="Masukkan nama anda">

                {{-- Password --}}
                <label for="phone" class="block text-sm font-semibold text-gray-700 mt-3 mb-1">Nomer Telepon</label>
                <div class="relative">
                    <input type="text" name="phone" id="phone" value="{{ old('phone') }}"
                        class="w-full bg-white rounded-full py-3 px-5 text-gray-700 shadow-sm border border-gray-200 focus:ring-primary-green focus:ring-2 outline-none"
                        placeholder="Masukkan nomer anda">

                </div>
                <label for="gender" class="block text-sm font-semibold text-gray-700 mt-3 mb-1">Jenis Kelamin</label>
                <div class="relative">
                    <select name="gender" id="gender" required
                        class="w-full bg-white rounded-full py-3 px-5 text-gray-700 shadow-sm border border-gray-200 focus:ring-primary-green focus:ring-2 outline-none">
                        <option value="">-- Pilih --</option>
                        <option value="laki-laki" {{ old('gender') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="perempuan" {{ old('gender') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>

                <label for="birth_date" class="block text-sm font-semibold text-gray-700 mt-3 mb-1">Tanggal Lahir</label>
                <div class="relative">
                    <input type="date" name="birth_date" id="birth_date" value="{{ old('birth_date') }}"
                        class="w-full bg-white rounded-full py-3 px-5 text-gray-700 shadow-sm border border-gray-200 focus:ring-primary-green focus:ring-2 outline-none"
                        placeholder="Masukkan password anda">

                </div>

                {{-- Forget --}}
                <div class="text-right mt-2 mb-5">
                    {{-- <a href="#" class="text-secondary-text text-sm hover:text-primary-green">Lupa Password?</a> --}}
                </div>

                {{-- Login Button --}}
                <button id="loginBtn" type="submit"
                    class="w-full py-3 bg-gray-300 text-white rounded-full text-lg font-medium cursor-not-allowed">
                    Simpan dan Lanjutkan
                </button>
            </form>
            {{-- Register --}}
            {{-- <p class="text-center mt-4 text-secondary-text text-sm">
                Sudah punya akun?
                <a href="{{ route('customer.auth.login') }}" class="text-[#e40312] font-semibold">Login</a>
            </p> --}}
        </div>

    </div>
    <style>
        /* Button styles */
        #loginBtn {
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        #loginBtn:not(:disabled):hover {
            box-shadow: 0 10px 15px rgba(228, 3, 18, 0.3);
            background-color: #e40312;
            transform: translateY(-2px);
        }

        #loginBtn:not(:disabled):active {
            box-shadow: 0 2px 4px rgba(228, 3, 18, 0.2);
            transform: translateY(0);
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
    </style>
    <script>
        const nameField = document.getElementById("name");
        const phoneField = document.getElementById("phone");
        const genderField = document.getElementById("gender");
        const birthDateField = document.getElementById("birth_date");
        const saveBtn = document.getElementById("loginBtn");

        // Validation functions
        function validateName() {
            return nameField.value.trim() !== "";
        }

        function validatePhone() {
            return phoneField.value.trim() !== "";
        }

        function validateGender() {
            return genderField.value !== "";
        }

        function validateBirthDate() {
            const value = birthDateField.value;
            return value !== "" && !isNaN(Date.parse(value));
        }

        function validateAll() {
            const isValid = validateName() && validatePhone() && validateGender() && validateBirthDate();

            if (isValid) {
                saveBtn.classList.remove("bg-gray-300", "cursor-not-allowed");
                saveBtn.classList.add("bg-[#e40312]", "cursor-pointer");
                saveBtn.disabled = false;
            } else {
                saveBtn.classList.add("bg-gray-300", "cursor-not-allowed");
                saveBtn.classList.remove("bg-[#e40312]", "cursor-pointer");
                saveBtn.disabled = true;
            }
        }

        // Event listeners
        nameField.addEventListener("input", validateAll);
        phoneField.addEventListener("input", validateAll);
        genderField.addEventListener("change", validateAll);
        birthDateField.addEventListener("input", validateAll);

        // Initial validation
        validateAll();
    </script>
@endsection