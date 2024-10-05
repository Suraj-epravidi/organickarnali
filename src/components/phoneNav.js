import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import { Link } from "react-router-dom";
import logoImg from "./img/logo_1.png";
import NavBtn from "./img/NavButton.png";
import "./css/PhoneNav.css"; // Import your CSS file
export default function PhoneNav(props) {
  const [isLightboxVisible, setLightboxVisible] = useState(false);
  const navigate = useNavigate();
  const toggleLightbox = () => {
    setLightboxVisible(!isLightboxVisible);
  };
  function logoBtn() {
    navigate("/");
  }

  return (
    <div className={`phoneNav ${props.color} ${props.fixed}`}>
      <img
        src={logoImg}
        alt="Logo"
        className="phoneLogo"
        onClick={logoBtn}
        style={{ cursor: "pointer" }}
      />
      <img
        src={NavBtn}
        alt="Menu"
        id="nav3Btn"
        class="nav3Btn"
        onClick={toggleLightbox}
        style={{ cursor: "pointer" }}
      />
      {isLightboxVisible && (
        <div className="lightbox">
          <div className="lightbox-content">
            <button className="close-btn" onClick={toggleLightbox}>
              X
            </button>
            <nav>
              <ul>
                <li>
                  <Link to="/">Home</Link>
                </li>
                <li>
                  <Link to="/about">About Us</Link>
                </li>
                <li>
                  <Link to="/product">Products</Link>
                </li>
                <li>
                  <Link to="/shop">Shop</Link>
                </li>
                <li>
                  <Link to="/cart">Cart</Link>
                </li>
                <li>
                  <Link to="/profile">Profile</Link>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      )}
    </div>
  );
}
