import React, { useEffect, useContext } from "react";
import Product from "../components/karnaliProduct";
import { Nav2Context } from "../components//Nav2context";
import MostSoldProducts from "../components/MostSoldProduct";
import { NavStatusContext } from "../components/NavStatusContext";
export default function Shop(props) {
  const { setNavStatus } = useContext(NavStatusContext);
  const cookieValue = props.sessionId;
  document.title = "Organic Karnali - Shops";
  const { setNav2Props } = useContext(Nav2Context);
  useEffect(() => {
    setNavStatus(true);
    setNav2Props({
      heading: "Shops",
      subHeading: "Organic products from the hearts of karnali.",
      signup: cookieValue ? "hide" : "visible",
      shop: cookieValue ? "hide" : "hide",
    });
  }, [setNavStatus, setNav2Props, cookieValue]);

  return (
    <div>
      <Product />
      <MostSoldProducts />
    </div>
  );
}
