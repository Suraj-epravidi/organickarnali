<?php
// Define the cookie name
$cookieName = 'user_login';

// Check if the cookie is set
if (!isset($_COOKIE[$cookieName])) {
    // Cookie is not set, redirect to the specified URL
    header('Location: https://karnaliorganics.com');
    exit(); // Make sure to stop further script execution
}

// Optional: If you need to perform additional validation on the cookie, you can add that here

// Cookie is set, continue with your script
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Organic Karnali - Checkout</title>

    <link
      href="https://fonts.googleapis.com/css?family=Poppins"
      rel="stylesheet"
    />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="checkout.css" />
    <link rel="icon" href="favicon.ico" />
  </head>
  <body>
    <!-- partial:index.partial.html -->
    <div class="checkout">
      <div class="container checkout-container">
        <a href="https://karnaliorganics.com"><h3><- Back</h3></a>
        <div class="checkout-order">
          <div class="checkout-col order-col">
            <h3 class="checkout-col-headline">
              Your order<i class="checkout-icon fa fa-angle-up"></i>
            </h3>
            <div class="checkout-col-inner">
              <div class="checkout-col-header">
                <div class="checkout-button">
                  <button class="black-button bold-text" onclick="takeToCart()">
                    <i class="fa fa-chevron-left"></i>Edit Cart
                  </button>
                </div>
              </div>
              <div class="checkout-order-info">
                <div id="cartContainer"><h3>Failed to load cart items. Please try again later.</h3></div>
                <div id="errorMessage" style="color: red; display: none;">Failed to load cart items. Please try again later.</div>
                <div class="checkout-order-discount gray-bg">
                  <form class="order-discount-form">
                    <input class="checkout-input" placeholder="Discount Code" />
                  </form>
                  <button class="black-button bold-text">Apply</button>
                </div>
              </div>
            </div>
          </div>
          <div class="checkout-col bill-col">
            <h3 class="checkout-col-headline">
              Billing Details<i class="checkout-icon fa fa-angle-up"></i>
            </h3>
            <div class="checkout-bill-credit">
              <input
                type="checkbox"
                name="addressMethod"
                value="fromProfile"
                id="defaultAddress"
              /><span class="bold-text bill-credit-title">Deafult Address</span>
            </div>
            <div class="checkout-bill-credit">
              <input
                type="checkbox"
                name="addressMethod"
                value="newAddress"
                id="newAddress"
              /><span class="bold-text bill-credit-title">New Address</span>
            </div>
            <div
              class="checkout-col-inner"
              id="checkoutColInner"
              style="display: none"
            >
              <form
                class="checkout-bill-form"
                method="post"
                action="/"
                id="checkoutForm"
              >
                <div class="order-row">
                  <span class="bill-small-col">
                    <label class="bold-text p-small" for="first-name"
                      >First name</label
                    >
                    <input class="checkout-input" type="text" id="firstName" />
                  </span>
                  <span class="bill-small-col">
                    <label class="bold-text p-small" for="last-name"
                      >Last name</label
                    >
                    <input class="checkout-input" type="text" id="lastName" />
                  </span>
                </div>
                <div class="order-row">
                  <span class="bill-full-col">
                    <label class="bold-text p-small" for="country"
                      >Country</label
                    >
                    <select class="checkout-select" id="country">
                      <option value="volvo">Select a country</option>
                      <option value="Nepal">Nepal</option>
                    </select>
                  </span>
                </div>
                <div class="order-row">
                  <span class="bill-full-col">
                    <label class="bold-text p-small" for="address1"
                      >Address</label
                    >
                    <input
                      class="checkout-input"
                      type="text"
                      placeholder="Address Line 1"
                      id="address1"
                    />
                    <input
                      class="checkout-input"
                      type="text"
                      placeholder="Address Line 2"
                      id="address2"
                    />
                  </span>
                </div>
                <div class="order-row">
                  <span class="bill-full-col">
                    <label class="bold-text p-small" for="suburb">Suburb</label>
                    <input
                      class="checkout-input"
                      type="text"
                      placeholder="Suburb"
                      id="suburb"
                    />
                  </span>
                </div>
                <div class="order-row">
                  <span class="bill-small-col">
                    <label class="bold-text p-small" for="state">State</label>
                    <select class="checkout-select" id="state">
                      <option value="Bagmati">Bagmati</option>
                    </select>
                  </span>
                  <span class="bill-small-col">
                    <label class="bold-text p-small" for="postcode"
                      >Postcode</label
                    >
                    <input class="checkout-input" type="text" id="postcode" />
                  </span>
                </div>
                <div class="order-row">
                  <span class="bill-full-col">
                    <label class="bold-text p-small" for="phone">Phone</label>
                    <input
                      class="checkout-input"
                      type="text"
                      placeholder="Phone"
                      id="phone"
                    />
                  </span>
                </div>
                <div class="order-row">
                  <span class="bill-full-col">
                    <label class="bold-text p-small" for="alternatePhone"
                      >Alternate Number</label
                    >
                    <input
                      class="checkout-input"
                      type="text"
                      placeholder="Alternate Phone Number"
                      id="altPhone"
                    />
                  </span>
                </div>
              </form>
            </div>
          </div>
          <div class="checkout-col bill-col">
            <div class="checkout-col-footer">
              <h3 class="checkout-col-headline">
                Additional Information<i
                  class="checkout-icon fa fa-angle-up"
                ></i>
              </h3>
              <div class="checkout-order-note">
                <span class="order-note-title">Order notes</span>
                <textarea
                  rows="4"
                  placeholder="Note about your order"
                  class="order-textarea"
                  id="orderNotes"
                ></textarea>
              </div>
              <h3 class="checkout-col-headline">
                Payment Details<i class="checkout-icon fa fa-angle-up"></i>
              </h3>
              <div class="checkout-col-inner checkout-col-bottom gray-bg">
                <div class="bill-credit-inner gray-bg">
                  <div class="checkout-bill-credit">
                    <input
                      type="checkbox"
                      name="paymentMethod"
                      value="esewa"
                      id="esewa"
                    /><span class="bold-text bill-credit-title">Esewa</span>
                  </div>
                  <div class="bill-credit-inner">
                    <div class="checkout-bill-credit">
                      <input
                        type="checkbox"
                        name="paymentMethod"
                        value="cash"
                        id="cash"
                      /><span class="bold-text bill-credit-title">Cash</span>
                    </div>
                  </div>
                </div>
                <div class="bill-col-inner">
                  <div class="order-row">
                    <div class="checkout-button">
                      <button
                        class="black-button bold-text red-bg"
                        id="proceedButton"
                      >
                        Proceed
                      </button>
                    </div>
                  </div>
                  <div class="checkout-title-notice">
                    <span class="checkout-title-text p-small"
                      >By completing your purchase, you agree to these
                    </span>
                    <a href="#" class="checkout-title-text red-text p-small"
                      >Terms and Conditions</a
                    >
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- partial -->
    <script>
  document.addEventListener("DOMContentLoaded", function () {
    const checkbox = document.getElementById("newAddress");
    const checkoutColInner = document.getElementById("checkoutColInner");

    // Show or hide address details based on checkbox state
    checkbox.addEventListener("change", function () {
      if (checkbox.checked) {
        checkoutColInner.style.display = "block";
      } else {
        checkoutColInner.style.display = "none";
      }
    });

    // Handle the proceed button click
    document.getElementById("proceedButton").addEventListener("click", function (event) {
      event.preventDefault();

      // Validate address method
      const addressMethodChecked = document.querySelector('input[name="addressMethod"]:checked');
      if (!addressMethodChecked) {
        alert("Please select an address method.");
        return;
      }

      // Validate payment method
      const paymentMethodChecked = document.querySelector('input[name="paymentMethod"]:checked');
      if (!paymentMethodChecked) {
        alert("Please select a payment method.");
        return;
      }

      // Handle Esewa payment method check
      const eseewaChecked = document.getElementById("esewa").checked;
      if (eseewaChecked) {
        alert("Esewa is not available at the moment.");
        return;
      }

      // Prepare data based on the default address method
      const defaultAddress = document.getElementById("defaultAddress").checked;
      let data;

      if (defaultAddress) {
        data = {
          orderNotes: document.getElementById("orderNotes").value,
          paymentMethod: paymentMethodChecked.value,
        };

        fetch("orderAdd.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        })
          .then(response => response.json())
          .then(result => {
            if (result.redirect) {
              window.location.href = result.redirect;
            } else {
              console.log(result);
            }
          })
          .catch(error => console.error("Error:", error));
      } else {
        data = {
          firstName: document.getElementById("firstName").value,
          lastName: document.getElementById("lastName").value,
          country: document.getElementById("country").value,
          address1: document.getElementById("address1").value,
          address2: document.getElementById("address2").value,
          suburb: document.getElementById("suburb").value,
          state: document.getElementById("state").value,
          postcode: document.getElementById("postcode").value,
          phone: document.getElementById("phone").value,
          altPhone: document.getElementById("altPhone").value,
          orderNotes: document.getElementById("orderNotes").value,
          paymentMethod: paymentMethodChecked.value,
        };

        fetch("proceed.php", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(data),
        })
          .then(response => response.json())
          .then(result => {
            if (result.redirect) {
              window.location.href = result.redirect;
            } else {
              console.log(result);
            }
          })
          .catch(error => console.error("Error:", error));
      }
    });

    function loadCartItems() {
  fetch('https://karnaliorganics.com/php/cart.php')
    .then(response => {
      // Check if the response is OK (status 200)
      if (!response.ok) {
        throw new Error('Network response was not ok');
      }
      return response.json();
    })
    .then(data => {
      if (data.success) {
        displayCartItems(data.items);
      } else {
        // Display error message from the server
        document.getElementById("errorMessage").textContent = data.error || 'An error occurred while fetching cart items.';
        document.getElementById("errorMessage").style.display = "block";
      }
    })
    .catch(error => {
      console.error("Error fetching cart items:", error);
      document.getElementById("errorMessage").textContent = 'An error occurred while fetching cart items.';
      document.getElementById("errorMessage").style.display = "block";
    });
}

function displayCartItems(items) {
  const cartContainer = document.getElementById("cartContainer");
  cartContainer.innerHTML = ''; // Clear existing content

  if (items.length === 0) {
    cartContainer.innerHTML = "<p>No items in cart.</p>";
    return;
  }

  let total = 0; // Variable to keep track of the total price

  items.forEach(item => {
    // Ensure item.price is a number
    const price = Number(item.price);

    if (!isNaN(price)) {
      // Add to total
      total += price;

      // Create HTML for each product
      const productDiv = document.createElement("div");
      productDiv.className = "order-card";
      productDiv.innerHTML = `
        <div class="order-row order-detail">
          <img class="order-img" src="${item.thumbnail}" alt="${item.product_name}">
          <i class="order-icon red-text fa fa-close"></i>
        </div>
        <div class="order-row">
          <span class="order-product-name red-text bold-text">${item.product_name}</span>
          <span class="order-product-price text-right">Rs.${price.toFixed(2)}</span>
        </div>
      `;
      cartContainer.appendChild(productDiv);
    } else {
      console.error("Invalid price:", item.price);
    }
  });

  // Display total price
  const totalDiv = document.createElement("div");
  totalDiv.className = "order-card-bill";
  totalDiv.innerHTML = `
    <span class="order-bill-row">
      <span class="order-bill-sub text-right">Subtotal: Rs.${total.toFixed(2)}</span>
      <span class="order-bill-total text-right bold-text">Total: Rs.${total.toFixed(2)}</span>
    </span>
  `;
  cartContainer.appendChild(totalDiv);
}

    loadCartItems(); // Call to load cart items on page load

    // Redirect to cart page
    function takeToCart() {
      window.location.href = "https://karnaliorganics.com/cart";
    }
  });
</script>

  </body>
</html>
