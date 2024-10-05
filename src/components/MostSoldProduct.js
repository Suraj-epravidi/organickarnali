import React from "react";
import ProductRows from "./ProductRows";
import Items from "./items.js";
export default function FeaturedProduct(props) {
  return (
    <section className="product">
      <span className="head">
        <span>
          <h3>Most Sold Products:</h3>
          <p>Discover our top-quality most sold products.</p>
        </span>
      </span>
      <div className="products">
        <ProductRows>
          <Items status={`${props.status}`} />
          <Items status={`${props.status}`} />
          <Items status={`${props.status}`} />
          <Items status={`${props.status}`} />
        </ProductRows>
        <ProductRows>
          <Items status={`${props.status}`} />
          <Items status={`${props.status}`} />
          <Items status={`${props.status}`} />
          <Items status={`${props.status}`} />
        </ProductRows>
      </div>
    </section>
  );
}
