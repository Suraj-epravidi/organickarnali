import React, { useState, useEffect } from "react";
import ReactDOM from "react-dom/client";
import { BrowserRouter as Router, Routes, Route } from "react-router-dom";

import "./components/css/style.css";
import NavBar from "./components/NavBar";
import Footer from "./components/Footer";
import Home from "./pages/Home";
import About from "./pages/AboutUs";
import Products from "./pages/Products";
import Shop from "./pages/Shop";
import Cart from "./pages/Cart";
import ProductDetail from "./pages/ProductDetail";
import reportWebVitals from "./reportWebVitals";
import { Nav2Provider } from "./components/Nav2context"; // Ensure correct path
import { NavStatusProvider } from "./components/NavStatusContext";
import "simplebar/dist/simplebar.min.css"; // Import the SimpleBar CSS

const App = () => {
  const [cookieValue, setCookieValue] = useState(null);

  useEffect(() => {
    const fetchCookieValue = async () => {
      try {
        const response = await fetch("../php/user.php"); // Ensure correct path
        const data = await response.json();
        setCookieValue(data.cookieValue);
      } catch (error) {
        console.error("Error fetching cookie value:", error);
      }
    };

    fetchCookieValue();
  }, []);

  return (
    <NavStatusProvider>
      <Nav2Provider>
        <Router>
          {" "}
          {/* Adjust height if needed */}
          <NavBar />
          <Routes>
            <Route path="/" element={<Home sessionId={cookieValue} />} />
            <Route path="/about" element={<About sessionId={cookieValue} />} />
            <Route
              path="/product"
              element={<Products sessionId={cookieValue} />}
            />
            <Route path="/shop" element={<Shop sessionId={cookieValue} />} />
            <Route path="/cart" element={<Cart sessionId={cookieValue} />} />
            <Route
              path="/product-detail/:productName"
              element={<ProductDetail sessionId={cookieValue} />}
            />
          </Routes>
          <Footer />
        </Router>
      </Nav2Provider>
    </NavStatusProvider>
  );
};

const root = ReactDOM.createRoot(document.getElementById("root"));
root.render(
  <React.StrictMode>
    <App />
  </React.StrictMode>
);

reportWebVitals();
