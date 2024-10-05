import React, { useEffect, useContext } from "react";
import Product from "../components/karnaliProduct";
import { Nav2Context } from "../components//Nav2context"; // Adjust the import path as needed
import { NavStatusContext } from "../components/NavStatusContext";
export default function Products(props) {
  const { setNavStatus } = useContext(NavStatusContext);
  const cookieValue = props.sessionId;
  document.title = "Organic Karnali - Products";
  const { setNav2Props } = useContext(Nav2Context);

  useEffect(() => {
    setNavStatus(true);
    setNav2Props({
      heading: "Products",
      subHeading: "Organic products from the hearts of karnali.",
      signup: cookieValue ? "hide" : "visible",
      shop: cookieValue ? "visible" : "visible",
    });
  }, [setNavStatus, setNav2Props, cookieValue]);

  return (
    <div>
      <Product
        status="hide"
        title="Products List"
        showAll="True"
        cookie={cookieValue}
      />
    </div>
  );
}
