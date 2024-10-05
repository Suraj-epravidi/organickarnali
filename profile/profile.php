<?php
$cookieName = 'user_login';

// Check if the cookie is set
if (!isset($_COOKIE[$cookieName])) {
    // Redirect to login page
    header("Location: https://karnaliorganics.com/login/login.html");
    // Ensure no further code is executed
    exit();
}

// Cookie is set; you can proceed with the rest of your script here
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Organic Karnali - Profile</title>
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css"
    />
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css"
    />
    <link rel="shortcut icon" href="apple-touch-icon.png" type="image/x-icon" />
    <link rel="stylesheet" href="./style.css" />
  </head>
  <body>
    <!-- partial:index.partial.html -->
    <div class="my-app">
      <p class="home"><a href="https://karnaliorganics.com">< Home</a></p>

      <main>
        <!-- Begin content header -->
        <section class="my-app__header">
          <div class="container">
            <div class="my-app__header-inner">
              <div class="my-app__header-text media pfp">
                <div class="profile-container">
                  <form
                    action="upload.php"
                    method="post"
                    enctype="multipart/form-data"
                    id="uploadForm"
                  >
                    <input
                      type="file"
                      id="fileInput"
                      name="profilePic"
                      style="display: none"
                      accept="image/*"
                    />
                    <label for="fileInput" class="profile-pic-container">
                      <img
                        id="profilePic"
                        src="default-profile-pic.png"
                        alt="Profile Picture"
                        class="profile-pic"
                        height="40px"
                        width="40px"
                      />
                    </label>
                    <button type="submit" style="display: none">Upload</button>
                  </form>
                </div>

                <div class="titleBody">
                  <h1 class="my-app__header-title">Hi there!</h1>
                  <p>Welcome to the heart of Karnali.</p>
                </div>
              </div>
              <div class="my-action-buttons my-app__header__buttons">
                <button class="my-action-button">
                  <img
                    class="my-action-button__icon"
                    src="./images/icon-money.svg"
                    alt
                  
                  />
                  Promo
                </button>
                <button class="my-action-button">
                  <img
                    class="my-action-button__icon"
                    src="./images/icon-cart.svg"
                    alt
                  />
                  Shopping deals
                </button>
              </div>
            </div>
          </div>
        </section>
        <!-- End content header -->

        <!-- Begin content body -->
        <section class="my-app__body">
          <div class="container">
            <div class="row">
              <div class="col-4">
                <!-- Begin Payment Balance card -->
                <div class="my-card card">
                  <div class="my-card__header card-header">
                    <div class="my-card__header-title">
                      <div class="my-text-overline">User Info</div>
                      <h3 class="my-text-headline" id="userName">User Name</h3>
                    </div>
                  </div>
                  <div class="my-card__body card-body">
                    <div class="my-text-overline">Contact Info</div>
                    <dl class="my-list my-list--definitions my-dl">
                      <dt>Email</dt>
                      <dd id="email">Loading...</dd>
                      <dt>Phone</dt>
                      <dd id="phone">Loading...</dd>
                      <dt>Alternate Phone</dt>
                      <dd id="altPhone">Loading...</dd>
                    </dl>
                    <button class="address button" id="openLightbox2">
                      Update Info
                    </button>
                    <hr class="my-divider" />
                    <div class="my-text-overline">Address Info</div>
                    <ul class="my-list my-list--simple list-inline mb-0">
                      <li id="fullAddress">Loading...</li>
                      <li id="suburb">Loading...</li>
                      <li id="state">Loading...</li>
                      <li id="postcode">Loading...</li>
                    </ul>
                    <button class="address button" id="openLightbox">
                      Update Address
                    </button>
                  </div>
                </div>
                <!-- End Payment Balance card -->
              </div>

              <div class="lightbox" id="lightbox">
                <div class="lightbox-content">
                  <span class="close-lightbox" id="closeLightbox">&times;</span>
                  <h3>Address Details</h3>
                  <form
                    class="checkout-bill-form"
                    method="post"
                    action="address.php"
                    id="checkoutForm"
                  >
                    <select class="checkout-select" name="country" id="country">
                      <option value="" disabled selected>
                        Select a country
                      </option>
                      <option value="Nepal">Nepal</option>
                    </select>
                    <input
                      class="checkout-input"
                      type="text"
                      name="address1"
                      placeholder="Address Line 1"
                      id="address1"
                    />
                    <input
                      class="checkout-input"
                      type="text"
                      name="address2"
                      placeholder="Address Line 2"
                      id="address2"
                    />
                    <input
                      class="checkout-input"
                      type="text"
                      name="suburb"
                      placeholder="Suburb"
                      id="suburb"
                    />
                    <select class="checkout-select" name="state" id="state">
                      <option value="" disabled selected>Select a state</option>
                      <option value="Bagmati">Bagmati</option>
                    </select>
                    <input
                      class="checkout-input"
                      type="text"
                      name="postcode"
                      placeholder="Postcode"
                      id="postcode"
                    />
                    <button class="button submit" type="submit">Submit</button>
                  </form>
                </div>
              </div>
              <div class="lightbox" id="lightbox2">
                <div class="lightbox-content">
                  <span class="close-lightbox" id="closeLightbox2"
                    >&times;</span
                  >
                  <h3>Contact Details</h3>
                  <form
                    class="checkout-bill-form"
                    method="post"
                    action="contact.php"
                    id="checkoutForm2"
                  >
                    <input
                      class="checkout-input"
                      type="text"
                      name="phone"
                      placeholder="Phone"
                      id="phone"
                    />
                    <input
                      class="checkout-input"
                      type="text"
                      name="altPhone"
                      placeholder="Alternate Phone Number"
                      id="altPhone"
                    />
                    <button class="button submit" type="submit">Submit</button>
                  </form>
                </div>
              </div>

              <div class="col-8">
                <div class="my-alert alert alert-info">
                  <img
                    class="my-alert__icon"
                    src="./images/icon-alert.svg"
                    alt
                  />
                  <span class="my-alert__text">
                    Your latest transaction may take a few minutes to show up in
                    your activity.
                  </span>
                </div>

                <!-- Begin Pending card -->
                <div class="my-card card">
                  <div class="my-card__header card-header">
                    <h3 class="my-card__header-title card-title">Pending</h3>
                  </div>
                  <ul class="my-list list-group list-group-flush">
                    <li class="my-list-item list-group-item">
                      <div class="my-list-item__date">
                        <span class="my-list-item__date-day">28</span>
                        <span class="my-list-item__date-month">jul</span>
                      </div>
                      <div class="my-list-item__text">
                        <h4 class="my-list-item__text-title">
                          Bank of America
                        </h4>
                        <p class="my-list-item__text-description">
                          Withdraw to bank account
                        </p>
                      </div>
                      <div class="my-list-item__fee">
                        <span class="my-list-item__fee-delta">+250.00</span>
                        <span class="my-list-item__fee-currency">USD</span>
                      </div>
                    </li>
                    <li class="my-list-item list-group-item">
                      <div class="my-list-item__date">
                        <span class="my-list-item__date-day">28</span>
                        <span class="my-list-item__date-month">jul</span>
                      </div>
                      <div class="my-list-item__text">
                        <h4 class="my-list-item__text-title">
                          Bank of America
                        </h4>
                        <p class="my-list-item__text-description">
                          Withdraw to bank account
                        </p>
                      </div>
                      <div class="my-list-item__fee">
                        <span class="my-list-item__fee-delta">+250.00</span>
                        <span class="my-list-item__fee-currency">USD</span>
                      </div>
                    </li>
                    <li class="my-list-item list-group-item">
                      <div class="my-list-item__date">
                        <span class="my-list-item__date-day">28</span>
                        <span class="my-list-item__date-month">jul</span>
                      </div>
                      <div class="my-list-item__text">
                        <h4 class="my-list-item__text-title">
                          Bank of America
                        </h4>
                        <p class="my-list-item__text-description">
                          Withdraw to bank account
                        </p>
                      </div>
                      <div class="my-list-item__fee">
                        <span class="my-list-item__fee-delta">+250.00</span>
                        <span class="my-list-item__fee-currency">USD</span>
                      </div>
                    </li>
                  </ul>
                </div>
                <!-- End Pending card -->
              </div>
            </div>
          </div>
        </section>
        <!-- End content body -->
      </main>
    </div>
    <!-- partial -->
    <script>
      document.addEventListener("DOMContentLoaded", function () {
        // Function to fetch user details and update HTML
        function fetchUserDetails() {
          fetch("fetchUserDetails.php")
            .then((response) => response.json())
            .then((data) => {
              // Update HTML with user details
              document.getElementById("userName").textContent =
                data.username || "Not available";
              document.getElementById("email").textContent =
                data.email || "Not available";
              document.getElementById("phone").textContent =
                data.phone || "Not available";
              document.getElementById("altPhone").textContent =
                data.altPhone || "Not available";
                document.getElementById("profilePic").src = data.pfp;

              // Concatenate address1 and address2
              const address =
                (data.address1 || "") + " " + (data.address2 || "");
              document.getElementById("fullAddress").textContent =
                address || "Not available";

              // Display other address details
              document.getElementById("suburb").textContent =
                data.suburb || "Not available";
              document.getElementById("state").textContent =
                data.state || "Not available";
              document.getElementById("postcode").textContent =
                data.postcode || "Not available";
            })
            .catch((error) => {
              console.error("Error fetching user details:", error);
            });
        }

        // Call the function to fetch user details
        fetchUserDetails();
      });
      const openLightbox = document.getElementById("openLightbox");
      const lightbox = document.getElementById("lightbox");
      const closeLightbox = document.getElementById("closeLightbox");

      openLightbox.addEventListener("click", function (event) {
        event.preventDefault();
        lightbox.style.display = "flex";
      });

      closeLightbox.addEventListener("click", function () {
        lightbox.style.display = "none";
      });

      const openLightbox2 = document.getElementById("openLightbox2");
      const lightbox2 = document.getElementById("lightbox2");
      const closeLightbox2 = document.getElementById("closeLightbox2");

      openLightbox2.addEventListener("click", function (event) {
        event.preventDefault();
        lightbox2.style.display = "flex";
      });

      closeLightbox2.addEventListener("click", function () {
        lightbox2.style.display = "none";
      });

      window.addEventListener("click", function (event) {
        if (event.target === lightbox) {
          lightbox.style.display = "none";
        } else if (event.target === lightbox2) {
          lightbox2.style.display = "none";
        }
      });
      document
        .getElementById("fileInput")
        .addEventListener("change", function (event) {
          const file = event.target.files[0];
          if (file) {
            const reader = new FileReader();
            reader.onload = function (e) {
              document.getElementById("profilePic").src = e.target.result;
            };
            reader.readAsDataURL(file);
          }
        });
        document.getElementById('fileInput').addEventListener('change', function() {
      if (this.files && this.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('profilePic').src = e.target.result;
        }
        reader.readAsDataURL(this.files[0]);

        // Automatically submit the form
        document.getElementById('uploadForm').submit();
      }
    });
    </script>
  </body>
</html>
