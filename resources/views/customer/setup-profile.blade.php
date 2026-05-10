@extends('layout.app')

@section('title', 'SRC Wulan 🏪')

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

                {{-- Hidden input for membership --}}
                <input type="hidden" name="membership" id="membership" value="{{ old('membership') }}">

                {{-- Member Selection Section --}}
                <div class="mt-3 mb-1">
                    <label for="birth_date" class="block text-sm font-semibold text-gray-700 mt-3 mb-1">Pilih data member yang tersedia</label>

                    {{-- Search Navigation --}}
                    <div class="relative mb-4">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" id="searchInput" placeholder="Cari nama member..."
                            class="w-full bg-white rounded-full py-3 pl-12 pr-5 text-gray-700 shadow-sm border border-gray-200 focus:border-[#e40312] focus:ring-2 focus:ring-red-100 outline-none transition-all duration-300">

                        {{-- Dropdown Member List --}}
                        <div id="memberDropdown" class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-lg border border-gray-100 max-h-64 overflow-y-auto hidden opacity-0 transform -translate-y-2 transition-all duration-300 z-50">
                            <div id="memberList" class="divide-y divide-gray-100">
                                <!-- Member items will be populated by JavaScript -->
                            </div>
                            <div id="emptyState" class="hidden p-4 text-center text-gray-400 text-sm">
                                Tidak ada member ditemukan
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Forget --}}
                <div class="text-right mt-2 mb-6">
                    {{-- <a href="#" class="text-secondary-text text-sm hover:text-primary-green">Lupa Password?</a> --}}
                </div>

                {{-- Login Button Simpan --}}
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

        /* Member dropdown styles */
        #memberDropdown {
            scrollbar-width: thin;
            scrollbar-color: #d1d5db #f9fafb;
        }

        #memberDropdown::-webkit-scrollbar {
            width: 6px;
        }

        #memberDropdown::-webkit-scrollbar-track {
            background: #f9fafb;
            border-radius: 10px;
        }

        #memberDropdown::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }

        #memberDropdown::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        #memberDropdown.show {
            display: block !important;
            opacity: 1;
            transform: translate(0, 0);
        }

        /* Member item styles */
        .member-item {
            background: white;
            padding: 12px 16px;
            box-shadow: none;
            cursor: pointer;
            transition: all 0.2s ease;
            border: none;
            position: relative;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .member-item:hover {
            background-color: #fafafa;
            transform: none;
        }

        /* Member avatar */
        .member-avatar {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: rgba(228, 3, 18, 0.15);
            color: #e40312;
            font-weight: 600;
            font-size: 16px;
            flex-shrink: 0;
        }

        /* Member info */
        .member-info {
            flex: 1;
            min-width: 0;
        }

        .member-name {
            font-weight: 600;
            color: #1f2937;
            font-size: 14px;
            margin: 0;
        }

        .member-address {
            font-size: 12px;
            color: #9ca3af;
            margin: 2px 0 0 0;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Member check icon */
        .member-check {
            display: none;
            width: 20px;
            height: 20px;
            color: #e40312;
            flex-shrink: 0;
        }

        .member-item.selected .member-check {
            display: block;
        }
    </style>
    <script>
        const nameField = document.getElementById("name");
        const phoneField = document.getElementById("phone");
        const genderField = document.getElementById("gender");
        const birthDateField = document.getElementById("birth_date");
        const membershipField = document.getElementById("membership");
        const saveBtn = document.getElementById("loginBtn");

        const searchInput = document.getElementById("searchInput");
        const memberDropdown = document.getElementById("memberDropdown");
        const memberList = document.getElementById("memberList");
        const emptyState = document.getElementById("emptyState");

        // Data dummy - Member data
        const members = [
            { id: 1, name: 'Ahmad Fauzan', address: 'Bandung, Jawa Barat' },
            { id: 2, name: 'Siti Rahma', address: 'Jakarta Selatan' },
            { id: 3, name: 'Budi Santoso', address: 'Surabaya' },
            { id: 4, name: 'Dinda Putri', address: 'Yogyakarta' },
            { id: 5, name: 'Rizky Ramadhan', address: 'Bekasi' }
        ];

        let selectedMember = membershipField.value;

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

        function validateMember() {
            return selectedMember !== "";
        }

        function validateAll() {
            const isValid = validateName() && validatePhone() && validateGender() && validateBirthDate() && validateMember();

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

        // Get initial of name
        function getInitial(name) {
            return name.charAt(0).toUpperCase();
        }

        // Show dropdown
        function showDropdown() {
            memberDropdown.classList.add('show');
        }

        // Hide dropdown
        function hideDropdown() {
            memberDropdown.classList.remove('show');
        }

        // Toggle empty state
        function updateEmptyState(filteredMembers) {
            if (filteredMembers.length === 0) {
                memberList.classList.add('hidden');
                emptyState.classList.remove('hidden');
            } else {
                memberList.classList.remove('hidden');
                emptyState.classList.add('hidden');
            }
        }

        // Render member list
        function renderMembers(filteredMembers) {
            memberList.innerHTML = '';
            filteredMembers.forEach(member => {
                const item = document.createElement('div');
                item.className = 'member-item';
                item.dataset.memberId = member.id;
                
                // Avatar
                const avatar = document.createElement('div');
                avatar.className = 'member-avatar';
                avatar.textContent = getInitial(member.name);
                
                // Info
                const info = document.createElement('div');
                info.className = 'member-info';
                
                const nameEl = document.createElement('p');
                nameEl.className = 'member-name';
                nameEl.textContent = member.name;
                
                const addressEl = document.createElement('p');
                addressEl.className = 'member-address';
                addressEl.textContent = member.address;
                
                info.appendChild(nameEl);
                info.appendChild(addressEl);
                
                // Check icon
                const checkIcon = document.createElement('svg');
                checkIcon.className = 'member-check';
                checkIcon.setAttribute('fill', 'none');
                checkIcon.setAttribute('stroke', 'currentColor');
                checkIcon.setAttribute('viewBox', '0 0 24 24');
                checkIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>';
                
                item.appendChild(avatar);
                item.appendChild(info);
                item.appendChild(checkIcon);
                
                item.addEventListener('click', () => selectMember(member));
                memberList.appendChild(item);
            });
            
            updateEmptyState(filteredMembers);
        }

        // Select member
        function selectMember(member) {
            selectedMember = member.name;
            membershipField.value = member.name;
            searchInput.value = member.name;
            hideDropdown();
            validateAll();
        }

        // Get filtered members
        function getFilteredMembers() {
            const searchValue = searchInput.value.toLowerCase();
            
            if (searchValue) {
                return members.filter(m => 
                    m.name.toLowerCase().includes(searchValue) || 
                    m.address.toLowerCase().includes(searchValue)
                );
            }
            
            return [];
        }

        // Update list
        function updateList() {
            const filtered = getFilteredMembers();
            renderMembers(filtered);
            
            if (searchInput.value.trim()) {
                showDropdown();
            } else {
                hideDropdown();
            }
        }

        // Click outside handler
        document.addEventListener('click', (e) => {
            if (!e.target.closest('.relative')) {
                hideDropdown();
            }
        });

        // Event listeners
        nameField.addEventListener("input", validateAll);
        phoneField.addEventListener("input", validateAll);
        genderField.addEventListener("change", validateAll);
        birthDateField.addEventListener("input", validateAll);

        searchInput.addEventListener('focus', () => {
            if (searchInput.value.trim()) {
                showDropdown();
            }
        });

        searchInput.addEventListener('input', updateList);

        // Initial validation
        validateAll();
    </script>
@endsection