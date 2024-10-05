import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
export default function Honey(props) {
  const navigate = useNavigate();
  var nameUser;
  useEffect(() => {
    const fetchUserData = async () => {
      try {
        const response = await fetch(
          `https://karnaliorganics.com/php/fetchUser.php?sessionId=${encodeURIComponent(
            props.cookieValue
          )}`
        );
        const data = await response.json();
        if (data.error) {
          console.error(data.error);
        } else {
          nameUser = data.name;
        }
      } catch (err) {
        console.error("Failed to fetch user data.");
      }
    };

    if (props.sessionId) {
      fetchUserData();
    }
  }, [props.sessionId]);

  const handleAddToCart = async () => {
    if (props.cookieValue < 0) {
      alert("Please sign in first.");
      return;
    }

    try {
      const response = await fetch(
        "https://karnaliorganics.com/php/addToCart.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({
            product_name: props.name,
            quantity: "1",
            user: nameUser,
          }),
        }
      );

      const data = await response.json();

      if (data.success) {
        alert(data.message);
      } else {
        alert(data.message);
      }
    } catch (error) {
      console.error("Error adding product to cart:", error);
      alert("An error occurred while adding the product to the cart.");
    }
  };

  const handleDivClick = () => {
    navigate(`/product-detail/${encodeURIComponent(props.name)}`);
  };
  return (
    <div className="items" id="madHoney">
      <img src={props.image} alt={props.alt} onClick={handleDivClick} />
      <span className="itemDetails">
        <h5>{props.name}</h5>
        <h5> Rs. {props.price}</h5>
      </span>
      <p>Free Delivery</p>
      <button className={`${props.status}`} onClick={handleAddToCart}>
        Add To Cart
      </button>
    </div>
  );
}
