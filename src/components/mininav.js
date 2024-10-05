import React from "react";
import { Link } from "react-router-dom"; // Import Link if using React Router
import "./css/mininavbar.css"; // Ensure you include this CSS file
import logoImg from "./img/logo_1.png";
import searcImg from "./img/search.png";
import basketImg from "./img/basket.png";
import userImg from "./img/user_icon.png";
const MiniNavbar = () => {
  return (
    <nav>
      <div className="nav-links" id="nav1">
        <Link to="/">Home</Link>
        <Link to="/about">About</Link>
        <Link to="/shop">Shop</Link>
      </div>

      <img src={logoImg} className="logo" alt="Logo" />

      <div className="nav-links" id="nav2">
        <Link to="/product">Products</Link>

        <div className="nav-icons">
          <a href="/">
            <img src={searcImg} alt="Search Icon" />
          </a>

          <a href="checkout.html">
            <img src={basketImg} alt="Basket Icon" />
          </a>

          <a href="profile.html">
            <img src={userImg} alt="User Icon" />
          </a>
        </div>
      </div>
    </nav>
  );
};

export default MiniNavbar;
