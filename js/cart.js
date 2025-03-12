// Function to render cart items
function renderCart() {
  const cart = getCart();
  const cartContainer = document.querySelector('.row.g-4');
  const subtotalElement = document.querySelector('.subtotal');

  cartContainer.innerHTML = '';
  let subtotal = 0;

  if (cart.length === 0) {
    cartContainer.innerHTML = `<p class="text-center">Your cart is empty.</p>`;
    subtotalElement.textContent = '$0.00';
    return;
  }

  cart.forEach((item, index) => {
    subtotal += item.price * item.quantity;

    cartContainer.innerHTML += `
          <div class="col-md-6 col-lg-4">
              <div class="card shadow-sm">
                  <div class="card-body d-flex align-items-center justify-content-between">
                      <button class="btn btn-danger btn-sm remove-item" data-index="${index}">
                          <i class="fa-solid fa-trash-can"></i>
                      </button>
                      <p class="mb-0 text-danger fw-bold">$${item.price.toFixed(
                        2
                      )}</p>
                      <div class="input-group input-group-sm" style="width: 100px;">
                          <button class="btn btn-secondary decrement-quantity" data-index="${index}">-</button>
                          <input type="text" class="form-control text-center quantity" value="${
                            item.quantity
                          }" readonly />
                          <button class="btn btn-secondary increment-quantity" data-index="${index}">+</button>
                      </div>
                      <p class="mb-0">${item.title}</p>
                      <img src="${
                        item.image
                      }" alt="Product" class="img-thumbnail" style="width: 70px;" />
                  </div>
              </div>
          </div>
      `;
  });

  subtotalElement.textContent = `$${subtotal.toFixed(2)}`;
}

// Function to handle quantity changes
function handleQuantityChange(e) {
  const index = e.target.dataset.index;
  const cart = getCart();

  if (e.target.classList.contains('increment-quantity')) {
    cart[index].quantity += 1;
  } else if (
    e.target.classList.contains('decrement-quantity') &&
    cart[index].quantity > 1
  ) {
    cart[index].quantity -= 1;
  }

  saveCart(cart);
  renderCart();
  updateCartCount();
}

// Function to handle item removal
function handleItemRemoval(e) {
  const index = e.target.dataset.index;
  const cart = getCart();

  cart.splice(index, 1);
  saveCart(cart);
  renderCart();
  updateCartCount();
}

// Function to clear the cart
function clearCart() {
  localStorage.removeItem('cart');
  renderCart();
  updateCartCount();
}

// Function to handle checkout
function handleCheckout() {
  const cart = getCart();
  if (cart.length === 0) {
    alert('Your cart is empty!');
    return;
  }

  fetch('../backend/checkout.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ cart }),
  })
    .then((response) => response.text())
    .then((data) => {
      console.log(data);
      if (data.includes('Order placed successfully')) {
        alert('Thank you for your purchase!');
        clearCart();
        window.location.href = '../backend/orders.php';
      } else {
        alert('Error processing order. Please try again.');
      }
    })
    .catch((error) => console.error('Checkout Error:', error));
}

// Event listeners for the cart page
document.addEventListener('DOMContentLoaded', () => {
  renderCart();

  document.querySelector('.row.g-4').addEventListener('click', (e) => {
    if (
      e.target.classList.contains('increment-quantity') ||
      e.target.classList.contains('decrement-quantity')
    ) {
      handleQuantityChange(e);
    } else if (e.target.classList.contains('remove-item')) {
      handleItemRemoval(e);
    }
  });

  document.querySelector('.clear-cart').addEventListener('click', clearCart);
  document
    .querySelector('.checkout-button')
    .addEventListener('click', handleCheckout);
});
