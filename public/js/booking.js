// Ambil harga asli dari Blade (ditulis lewat atribut data)
const defaultPrice = parseInt(document.getElementById('subtotal').dataset.price);

const quantityDisplay = document.getElementById('quantity-display');
const quantityInput = document.getElementById('quantity');
const subtotalEl = document.getElementById('subtotal');

document.getElementById('minus').addEventListener('click', () => {
    let quantity = parseInt(quantityInput.value);
    if (quantity > 1) {
        quantity--;
        updateDisplay(quantity);
    }
});

document.getElementById('plus').addEventListener('click', () => {
    let quantity = parseInt(quantityInput.value);
    quantity++;
    updateDisplay(quantity);
});

function formatRupiah(number) {
    return number.toLocaleString('id-ID');
}

function updateDisplay(quantity) {
    quantityInput.value = quantity;
    quantityDisplay.textContent = quantity;

    const subtotal = quantity * defaultPrice;
    subtotalEl.textContent = formatRupiah(subtotal);
}

// Saat halaman pertama kali load
document.addEventListener('DOMContentLoaded', () => {
    updateDisplay(parseInt(quantityInput.value));
});
