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
