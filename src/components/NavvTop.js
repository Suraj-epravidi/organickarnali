import React from "react";
import { Link } from "react-router-dom";
import logoImg from "./img/logo_1.png";
import searchImg from "./img/search.png";
import basketImg from "./img/basket.png";
import userImg from "./img/user_icon.png";

export default function NavTop(props) {
  return (
    <nav className={`${props.fixed} ${props.fixed2}`}>
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
            <img src={searchImg} alt="Search Icon" />
          </a>

          <Link to="/cart">
            <img src={basketImg} alt="Basket Icon" />
          </Link>

          <a href="../profile/profile.php">
            <img src={userImg} alt="User Icon" />
          </a>
        </div>
      </div>
    </nav>
  );
}
