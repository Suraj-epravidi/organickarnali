import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import ProductRows from "./ProductRows.js";
import Item from "./items.js";
import AnimatedComponent from "./AnimatedComponent"; // Import the animated component

export default function Product(props) {
  const [products, setProducts] = useState([]);
  const [windowWidth, setWindowWidth] = useState(window.innerWidth);
  const navigate = useNavigate();

  useEffect(() => {
    fetch("https://karnaliorganics.com/php/fetch_products.php")
      .then((response) => response.json())
      .then((data) => setProducts(data))
      .catch((error) => console.error("Error fetching products:", error));
  }, []);

  useEffect(() => {
    const handleResize = () => {
      setWindowWidth(window.innerWidth);
    };

    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, []);

  function sendToCart() {
    navigate("/product");
  }

  const renderProductRows = () => {
    const rows = [];
    const numProductsPerRow = windowWidth >= 701 ? 4 : 2; // Number of products per row
    const numRowsToShow = props.showAll
      ? Math.ceil(products.length / numProductsPerRow)
      : 3;
    const productsToShow = products.slice(0, numRowsToShow * numProductsPerRow);

    for (let i = 0; i < productsToShow.length; i += numProductsPerRow) {
      const rowProducts = productsToShow.slice(i, i + numProductsPerRow);
      rows.push(
        <ProductRows key={i}>
          {rowProducts.map((product, index) => (
            <AnimatedComponent
              key={index}
              animationType="slide-in"
              animationDelay={`${index * 0.1}s`} // Example delay
              animationDuration="1s" // Example duration
              exemptFromBubble={true} // Change to true if this component should be exempt from bubble animation
              exemptFromReset={true} // Change to true if this component should be exempt
            >
              <Item
                status={props.status}
                name={product.name}
                price={product.price}
                image={`https://panel.karnaliorganics.com/${product.thumbnail}`}
                alt={product.name}
                cookieValue={props.cookie}
              />
              <div className="bgcolor"></div>
            </AnimatedComponent>
          ))}
          {/* Add empty placeholders if needed */}
          {windowWidth >= 701 &&
            rowProducts.length < 4 &&
            Array.from({ length: 4 - rowProducts.length }).map((_, index) => (
              <AnimatedComponent
                key={`empty-${i}-${index}`}
                animationType="fade-in"
                animationDelay={`${index * 0.2}s`} // Example delay
                animationDuration="1s" // Example duration
                exemptFromBubble={true} // Change to true if this component should be exempt from bubble animation
                exemptFromReset={true} // Change to true if this component should be exempt
              >
                <div className="items"></div>
              </AnimatedComponent>
            ))}
          {windowWidth < 701 &&
            rowProducts.length < 2 &&
            Array.from({ length: 2 - rowProducts.length }).map((_, index) => (
              <AnimatedComponent
                key={`empty-${i}-${index}`}
                animationType="fade-in"
                animationDelay={`${index * 0.2}s`} // Example delay
                animationDuration="1s" // Example duration
                exemptFromBubble={true} // Change to true if this component should be exempt from bubble animation
                exemptFromReset={true} // Change to true if this component should be exempt
              >
                <div className="bgcolor"></div>
              </AnimatedComponent>
            ))}
        </ProductRows>
      );
    }
    return rows;
  };

  return (
    <section className="product">
      <AnimatedComponent
        animationType="fade-in"
        animationDelay="0s"
        animationDuration="1s"
        exemptFromBubble={true} // Change to true if this component should be exempt from bubble animation
        exemptFromReset={true} // Change to true if this component should be exempt
      >
        <div className="head">
          <span>
            <h3>Featured Products:</h3>
            <p>Discover our hand-picked selection of top-quality products.</p>
          </span>
          <button id="exploreAll" onClick={sendToCart}>
            Explore All
          </button>
        </div>
      </AnimatedComponent>
      <div className="products">{renderProductRows()}</div>
    </section>
  );
}
