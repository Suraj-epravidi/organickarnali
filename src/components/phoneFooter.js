import React from "react";
import logo from "./img/logo_1.png";
import locationIcon from "./img/location_icon.png";
import mailIcon from "./img/mail_icon.png";
import phoneIcon from "./img/phone_icon.png";
import fbIcon from "./img/fb_icon.png";
import igIcon from "./img/ig_icon.png";

export default function phoneFooter() {
  return (
    <div className="phoneFooter">
      <span className="phoneFooterLogo">
        <img src={logo} alt="" className="ftrLogoPhone" />
      </span>
      <span className="phoneFooterSubscribe subscribe">
        <h3>Subscribe</h3>

        <p>Join our mailing list to stay updated.</p>
        <div class="form">
          <input type="email" placeholder="Enter your Email" />

          <button>Subscribe</button>
        </div>

        <p>
          By subscribing, you agree to our Privacy Policy and consent
          <br />
          to receive updates from us.
        </p>
      </span>
      <span className="phoneFooterLinks">
        {" "}
        <div className="qLinks">
          <h3>Quick Links</h3>

          <a href="about.html">About</a>
          <a href="shop.html">Shop</a>
          <a href="products.html">Product</a>
          <a href="profile.html">Profile</a>
        </div>
        <div className="office">
          <h3>Office</h3>

          <span>
            <img src={locationIcon} alt="Location Icon" /> Mahalaxmi, Lalitpur
          </span>
          <span>
            <img src={mailIcon} alt="Mail Icon" /> info@organickarnali.com
          </span>
          <span>
            <img src={phoneIcon} alt="Phone Icon" />
            +977 - 9851015348
          </span>
        </div>
      </span>
      <span className="phoneFooterSocial">
        {" "}
        <div className="socials">
          <a href="/">
            <img src={fbIcon} alt="" />
          </a>
          <a href="/">
            {" "}
            <img src={igIcon} alt="" />
          </a>
        </div>
      </span>
      <span className="phoneFooterEnd">
        {" "}
        <span className="footerEnd">
          <u>
            <p>Privacy Policy</p>
          </u>
          <u>
            <p>Terms & Conditions</p>
          </u>
          <p>
            &copy; 2024 Organic Karnali. All rights reserved | Forged By
            E-pravidi Pvt. Ltd.
          </p>
        </span>
      </span>
    </div>
  );
}
