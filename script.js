function getCart() {
  return JSON.parse(localStorage.getItem('cart')) || [];
}

function saveCart(cart) {
  localStorage.setItem('cart', JSON.stringify(cart));
}

function updateCartCount() {
  const cart = getCart();
  const cartCount = cart.reduce((total, item) => total + item.quantity, 0);
  const cartBadge = document.querySelector('.products-number');
  if (cartBadge) cartBadge.textContent = cartCount;
}

function addToCart(item) {
  const cart = getCart();
  const existingItem = cart.find((cartItem) => cartItem.id === item.id);

  if (existingItem) {
    existingItem.quantity += 1;
  } else {
    cart.push({ ...item, quantity: 1 });
  }

  saveCart(cart);
  updateCartCount();
}

document.querySelectorAll('.add-to-cart').forEach((button) => {
  button.addEventListener('click', (e) => {
    const card = e.target.closest('.card');
    const item = {
      id: card.querySelector('.card-title').textContent.trim(),
      title: card.querySelector('.card-title').textContent.trim(),
      price: parseFloat(
        card.querySelector('.text-danger').textContent.replace('$', '')
      ),
      image: card.querySelector('img').src,
    };

    addToCart(item);
  });
});

document.addEventListener('DOMContentLoaded', updateCartCount);
