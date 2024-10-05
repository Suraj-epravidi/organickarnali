import React, { useEffect, useContext, useState, useRef } from "react";
import { useParams } from "react-router-dom";
import { Nav2Context } from "../components/Nav2context";
import subIcon from "../components/img/subtract_icon.png";
import addIcon from "../components/img/plus_icon.png";
import Testimonial from "../components/testimonial";
import Comment from "../components/comment";
import { NavStatusContext } from "../components/NavStatusContext";
function ProductDetail(props) {
  const { setNavStatus } = useContext(NavStatusContext);
  const { productName } = useParams();
  const [product, setProduct] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [productQuantity, setProductQuantity] = useState(1); // State for quantity
  const quantityRef = useRef(null); // Create ref for quantity input
  const cookieValue = props.sessionId;
  useEffect(() => {
    const fetchProductDetails = async () => {
      try {
        const response = await fetch(
          `https://karnaliorganics.com/php/ProductDetails.php?name=${encodeURIComponent(
            productName
          )}`
        );
        const data = await response.json();
        if (data.error) {
          setError(data.error);
        } else {
          setProduct(data);
        }
      } catch (err) {
        setError("Failed to fetch product details.");
      } finally {
        setLoading(false);
      }
    };

    fetchProductDetails();
  }, [productName]);

  document.title = `Organic Karnali - ${productName}`;

  const { setNav2Props } = useContext(Nav2Context);
  setNavStatus(true);
  useEffect(() => {
    setNav2Props({
      heading: "",
      subHeading: "",
      signup: cookieValue ? "hide" : "hide",
      shop: cookieValue ? "hide" : "hide",
    });
  }, [setNavStatus, setNav2Props, cookieValue]);

  const handleAddToCart = async () => {
    if (!product) {
      console.error("No product data available");
      return;
    }
    if (cookieValue > 0) {
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
            product_name: productName,
            quantity: productQuantity,
          }),
        }
      );

      if (!response.ok) {
        alert("Error adding product to cart:", error);
        throw new Error(`HTTP error! status: ${response.status}`);
      }

      const data = await response.json();

      if (data.success) {
        alert(data.message);
      } else {
        alert(`Error from server: ${data.message}`);
      }
    } catch (error) {
      console.error("Error adding product to cart:", error);
      alert(
        `An error occurred while adding the product to the cart: ${error.message}`
      );
    }
  };

  const handleSubtractQuantity = () => {
    if (productQuantity > 1) {
      setProductQuantity(productQuantity - 1);
    }
  };

  const handleAddQuantity = () => {
    if (productQuantity < product.stock) {
      setProductQuantity(productQuantity + 1);
    }
  };

  if (loading)
    return (
      <video
        src="https://miro.medium.com/v2/resize:fit:1400/format:webp/1*e_Loq49BI4WmN7o9ItTADg.gif"
        loop
        autoplay
      ></video>
    );
  if (error) return <p>{error}</p>;
  return (
    <div className="productShow">
      <section className="madHoney">
        <div className="productDetail">
          <div className="head">
            <h2>{productName}</h2>
            <p>From the hearts of karnali.</p>
          </div>
          <p>{product ? product.subHeading : "Product description here"}</p>
          <div className="quantity">
            <h4>Quantity</h4>
            <span className="input">
              <img
                src={subIcon}
                alt="Subtract"
                onClick={handleSubtractQuantity}
                style={{ cursor: "pointer" }}
              />
              <input
                type="number"
                id="productQuantity"
                min="1"
                max={product.stock}
                ref={quantityRef} // Attach ref to input
                value={productQuantity}
                readOnly // Make input read-only
              />
              <img
                src={addIcon}
                alt="Add"
                onClick={handleAddQuantity}
                style={{ cursor: "pointer" }}
              />
            </span>
          </div>
          <h3>Rs. {product ? product.price : "0"}</h3>
          <button id="addToCart" onClick={handleAddToCart}>
            Add to Cart
          </button>
        </div>
        <div
          className="productImage"
          style={{
            backgroundImage: `url(${
              product
                ? `https://panel.karnaliorganics.com/${product.thumbnail}`
                : "img/default_image.png"
            })`,
          }}
        >
          {/* Optional: You can put content inside the div if needed */}
        </div>
      </section>
      <Testimonial></Testimonial>
      <Comment></Comment>
    </div>
  );
}

export default ProductDetail;
