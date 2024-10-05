import React, { useState } from "react";
import Cross from "./img/cross_icon.png";

export default function CartItem(props) {
  const [quantity, setQuantity] = useState(props.quantity);

  const handleRemove = async () => {
    try {
      const response = await fetch(
        "https://karnaliorganics.com/php/removeItem.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({
            product_name: props.productName,
            user_name: props.user, // pass the user email here
          }),
        }
      );

      const data = await response.json();

      if (data.success) {
        props.onRemove(props.productName); // Notify parent component to remove item from state
      } else {
        alert(data.message);
      }
    } catch (error) {
      console.error("Error removing product from cart:", error);
      alert("An error occurred while removing the product from the cart.");
    }
  };

  const handleQuantityChange = async (event) => {
    var newQuantity = event.target.value;
    setQuantity(newQuantity);
    if (newQuantity > props.stock) {
      newQuantity = props.stock;
      setQuantity(newQuantity);
    }
    try {
      const response = await fetch(
        "https://karnaliorganics.com/php/handleQuantity.php",
        {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify({
            username: props.user,
            product_name: props.productName,
            quantity: newQuantity,
          }),
        }
      );

      const data = await response.json();

      if (data.success) {
        props.onQuantityChange(props.productName, newQuantity); // Notify parent component to update quantity
      } else {
        alert(data.message);
      }
    } catch (error) {
      console.error("Error updating product quantity:", error);
      alert("An error occurred while updating the product quantity.");
    }
  };

  return (
    <div>
      <span className="item">
        <img
          src={Cross}
          alt="cancelItem"
          id="cancelItem"
          onClick={handleRemove}
        />

        <div className="itemDesc">
          <img src={props.thumbnail} alt={`${props.productName} Image`} />
          <div className="productDesc">
            <h3>{props.productName}</h3>
            {props.description}
          </div>
          <h3 className="itemPrice">{props.price}</h3>
          <input
            type="number"
            value={quantity}
            onChange={handleQuantityChange}
            min="1"
            max={props.stock}
          />
          <h3 className="itemTotal">Rs. {props.price * quantity}</h3>
        </div>
      </span>
    </div>
  );
}
