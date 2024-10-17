import React, { useEffect, useContext, useState } from "react";
import { useNavigate } from "react-router-dom";
import { Nav2Context } from "../components/Nav2context";
import CartItem from "../components/cartItem";
import { NavStatusContext } from "../components/NavStatusContext";
const Cart = (props) => {
  const navigate = useNavigate();
  const { setNavStatus } = useContext(NavStatusContext);
  const cookieValue = props.sessionId;
  const [userName, setUserName] = useState(null);
  const [cartItems, setCartItems] = useState([]);

  document.title = "Organic Karnali - Cart";
  const checkOut = () => {
    window.location.href = "https://karnaliorganics.com/checkout/checkout.php";
    console.log("Button Clicked");
  };
  useEffect(() => {
    if (cookieValue <= 0) {
      navigate("/");
    }
  }, [cookieValue, navigate]);

  const { setNav2Props } = useContext(Nav2Context);

  useEffect(() => {
    setNavStatus(true);
    setNav2Props({
      heading: "Cart",
      subHeading: "Organic products from the hearts of karnali.",
      signup: cookieValue ? "hide" : "visible",
      shop: cookieValue ? "visible" : "visible",
    });
  }, [setNavStatus, setNav2Props, cookieValue]);

  useEffect(() => {
    const fetchUserData = async () => {
      try {
        const response = await fetch(
          `https://karnaliorganics.com/php/fetchUser.php?sessionId=${encodeURIComponent(
            props.sessionId
          )}`
        );
        const data = await response.json();
        if (data.error) {
          console.error(data.error);
        } else {
          setUserName(data.username); // Store the user name in the state
        }
      } catch (err) {
        console.error("Failed to fetch user data.", err);
      }
    };

    if (props.sessionId) {
      fetchUserData();
    }
  }, [props.sessionId]);

  useEffect(() => {
    const fetchCartDetails = async () => {
      if (!userName) {
        window.location.href = "https://karnaliorganics.com/login/login.html";
      }
      try {
        const response = await fetch(
          `https://karnaliorganics.com/php/cart.php`
        );
        const data = await response.json();
        if (data.error) {
          console.error(data.error);
        } else {
          setCartItems(data);
        }
      } catch (err) {
        console.error("Failed to fetch cart details.", err);
      }
    };

    fetchCartDetails();
  }, [userName]);

  const handleRemoveItem = (productName) => {
    setCartItems(cartItems.filter((item) => item.product_name !== productName));
  };

  const handleQuantityChange = async (productName, newQuantity) => {
    try {
      const response = await fetch(
        "https://karnaliorganics.com/php/handleQuantity.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            username: userName,
            product_name: productName,
            quantity: newQuantity,
          }),
        }
      );
      const data = await response.json();
      if (data.success) {
        setCartItems(
          cartItems.map((item) =>
            item.product_name === productName
              ? { ...item, quantity: newQuantity }
              : item
          )
        );
      } else {
        alert(data.error);
      }
    } catch (error) {
      alert("Error updating product quantity.");
    }
  };

  return (
    <div>
      <section className="cart">
        <div className="cartList">
          <div className="cartHead">
            <h3>Shopping List</h3>
            <ul>
              <li>Price</li>
              <li>Quantity</li>
              <li>Total</li>
            </ul>
          </div>
          {cartItems.length > 0 ? (
            cartItems.map((item, index) => (
              <CartItem
                key={index}
                productName={item.product_name}
                description={item.description}
                price={item.price}
                thumbnail={item.thumbnail}
                quantity={item.quantity}
                total={item.price * item.quantity}
                stock={item.stock}
                user={userName}
                onRemove={handleRemoveItem}
                onQuantityChange={handleQuantityChange}
              />
            ))
          ) : (
            <p>No items in the cart.</p>
          )}
        </div>
        <span className="checkout">
          <h3>
            Rs.{" "}
            {cartItems.reduce(
              (total, item) => total + item.price * item.quantity,
              0
            )}
          </h3>
          <button onClick={checkOut}>Checkout</button>
        </span>
      </section>
    </div>
  );
};

export default Cart;
