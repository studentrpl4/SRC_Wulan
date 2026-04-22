document.addEventListener("DOMContentLoaded", () => {
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    // Elemen utama untuk interaksi checkbox
    const selectAllCheckbox = document.getElementById("selectAll");
    const itemCheckboxes = document.querySelectorAll(".item-checkbox");
    const totalPriceDisplay = document.getElementById("grand-total"); // ID yang saya buat di kode sebelumnya
    const cartItems = document.querySelectorAll(".cart-item"); // Kelas untuk setiap baris produk

    // --- UTILITY FUNCTIONS ---

    // 1. Fungsi untuk memformat angka menjadi Rupiah (sesuai format ID)
    const formatRupiah = (number) => {
        // Hapus semua karakter non-digit kecuali tanda minus, lalu format
        const cleanNumber = parseInt(String(number).replace(/[^\d]/g, ""));
        return "Rp " + cleanNumber.toLocaleString("id-ID");
    };

    // 2. Fungsi utama untuk menghitung dan memperbarui Total Harga
    const calculateGrandTotal = () => {
        let grandTotal = 0;

        // Iterasi melalui semua item di keranjang
        cartItems.forEach((item) => {
            const checkbox = item.querySelector(".item-checkbox");

            // Periksa apakah item dicentang
            if (checkbox.checked) {
                // Ambil subtotal dari elemen display yang sudah diformat (misalnya 'Rp 40.000')
                // Kita gunakan subtotal yang sudah di-render, diasumsikan subtotal ini benar
                const subtotalElement = item.querySelector(
                    ".item-subtotal-display"
                );

                // Ambil teks, hilangkan "Rp " dan titik pemisah ribuan
                let subtotalText = subtotalElement.textContent
                    .replace("Rp ", "")
                    .replace(/\./g, "");
                let subtotal = parseInt(subtotalText) || 0;

                grandTotal += subtotal;

                // Atur opacity (visual feedback)
                item.classList.remove("opacity-80");
            } else {
                item.classList.add("opacity-80");
            }
        });

        // Perbarui tampilan total harga
        totalPriceDisplay.textContent = formatRupiah(grandTotal);
    };

    // 3. Fungsi untuk memeriksa status "Pilih Semua"
    const checkSelectAllStatus = () => {
        const allChecked = Array.from(itemCheckboxes).every((cb) => cb.checked);
        selectAllCheckbox.checked = allChecked;
    };

    document
        .querySelectorAll(".btn-increase, .btn-decrease")
        .forEach((button) => {
            button.addEventListener("click", function () {
                const cartId = this.dataset.id;
                const action = this.classList.contains("btn-increase")
                    ? "increase"
                    : "decrease";

                fetch(`/cart/${cartId}/update-quantity`, {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken,
                    },
                    body: JSON.stringify({ action }),
                })
                    .then((res) => res.json())
                    .then((data) => {
                        if (!data.error) {
                            // update quantity display
                            const qtySpan = document.querySelector(
                                `.qty-display[data-id="${cartId}"]`
                            );
                            qtySpan.textContent = data.quantity;

                            // update subtotal display
                            const subtotal = document.querySelector(
                                `#cart-subtotal-${cartId}`
                            );
                            subtotal.textContent = "Rp " + data.subtotal;

                            // update grand total
                            const grandTotal = Object.values(
                                document.querySelectorAll(
                                    '[id^="cart-subtotal-"]'
                                )
                            ).reduce((sum, el) => {
                                let num = parseInt(
                                    el.textContent.replace(/\D/g, "")
                                );
                                return sum + num;
                            }, 0);
                            document.getElementById("grand-total").textContent =
                                "Rp " + grandTotal.toLocaleString("id-ID");
                        }
                    });
            });

        });
    selectAllCheckbox.addEventListener("change", (e) => {
        const checked = e.target.checked;
        itemCheckboxes.forEach((checkbox) => {
            checkbox.checked = checked; // Set semua item sesuai status 'Pilih Semua'
        });
        calculateGrandTotal(); // Hitung ulang total
    });
    itemCheckboxes.forEach((checkbox) => {
        checkbox.addEventListener("change", () => {
            calculateGrandTotal(); // Hitung ulang total
            checkSelectAllStatus(); // Perbarui status 'Pilih Semua'
        });
    });

    // Panggil saat DOM selesai dimuat untuk menginisialisasi total
    // (Total awal harus dihitung berdasarkan item yang dicentang di HTML awal)
    calculateGrandTotal();
});
