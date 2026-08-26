const productImage = document.querySelector('#product-image');
const productThumbs = document.querySelectorAll('.product-thumb');
const productImages = [
    'https://images.unsplash.com/photo-1598032895397-b9472444bf93?auto=format&fit=crop&w=1000&q=85',
    'https://images.unsplash.com/photo-1596755389378-c31d21fd1273?auto=format&fit=crop&w=1000&q=85',
    'https://images.unsplash.com/photo-1603252110481-7ba873bf42ab?auto=format&fit=crop&w=1000&q=85',
];

productThumbs.forEach((thumbnail) => {
    thumbnail.addEventListener('click', () => {
        const imageIndex = Number(thumbnail.dataset.image);

        if (productImage) {
            productImage.src = productImages[imageIndex];
        }

        productThumbs.forEach((item) => item.classList.replace('border-black', 'border-transparent'));
        thumbnail.classList.replace('border-transparent', 'border-black');
    });
});

const quantity = document.querySelector('#quantity');
document.querySelectorAll('.quantity-button').forEach((button) => {
    button.addEventListener('click', () => {
        const currentQuantity = Number(quantity.textContent);
        const nextQuantity = button.dataset.action === 'increase' ? currentQuantity + 1 : Math.max(1, currentQuantity - 1);

        quantity.textContent = nextQuantity;
    });
});

const cartItems = document.querySelectorAll('.cart-item');
const subtotalElement = document.querySelector('#cart-subtotal');
const discountElement = document.querySelector('#cart-discount');
const totalElement = document.querySelector('#cart-total');
const emptyCartMessage = document.querySelector('#empty-cart');

const formatRupiah = (amount) => `Rp${amount.toLocaleString('id-ID')}`;

const updateCartSummary = () => {
    let subtotal = 0;
    let visibleItems = 0;

    cartItems.forEach((item) => {
        if (!item.classList.contains('hidden')) {
            subtotal += Number(item.dataset.price) * Number(item.querySelector('.item-quantity').textContent);
            visibleItems += 1;
        }
    });

    const discount = subtotal * 0.1;
    subtotalElement.textContent = formatRupiah(subtotal);
    discountElement.textContent = `-${formatRupiah(discount)}`;
    totalElement.textContent = formatRupiah(subtotal - discount);
    emptyCartMessage.classList.toggle('hidden', visibleItems !== 0);
};

document.querySelectorAll('.cart-quantity').forEach((button) => {
    button.addEventListener('click', () => {
        const item = button.closest('.cart-item');
        const itemQuantity = item.querySelector('.item-quantity');
        const currentQuantity = Number(itemQuantity.textContent);
        const nextQuantity = button.dataset.action === 'increase' ? currentQuantity + 1 : Math.max(1, currentQuantity - 1);

        itemQuantity.textContent = nextQuantity;
        updateCartSummary();
    });
});

document.querySelectorAll('.remove-cart-item').forEach((button) => {
    button.addEventListener('click', () => {
        button.closest('.cart-item').classList.add('hidden');
        updateCartSummary();
    });
});

if (cartItems.length > 0) {
    updateCartSummary();
}

document.querySelectorAll('.payment-radio').forEach((radio) => {
    radio.addEventListener('change', () => {
        document.querySelectorAll('.payment-option').forEach((option) => {
            option.classList.remove('border-black', 'border-2', 'bg-zinc-50');
            option.classList.add('border', 'border-zinc-200');
        });

        radio.closest('.payment-option').classList.add('border-black', 'border-2', 'bg-zinc-50');
        radio.closest('.payment-option').classList.remove('border-zinc-200', 'border');
    });
});
