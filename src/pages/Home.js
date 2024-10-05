import React, { useEffect, useContext } from "react";
import { Nav2Context } from "../components/Nav2context";
import Product from "../components/karnaliProduct";
import Testimonial from "../components/testimonial";
import Contact from "../components/contact";
import { NavStatusContext } from "../components/NavStatusContext";
import Comment from "../components/comment";
const Home = (props) => {
  const { navStatus, setNavStatus } = useContext(NavStatusContext);

  // Get the sessionId from props, which should be the cookie value
  const cookieValue = props.sessionId;
  document.title = "Organic Karnali - Home";

  const { setNav2Props } = useContext(Nav2Context);
  useEffect(() => {
    setNavStatus(false);
    setNav2Props({
      heading: "Organic Karnali",
      subHeading: "Organic products from the hearts of karnali.",
      signup: cookieValue ? "hide" : "visible",
      shop: cookieValue ? "visible" : "visible",
    });
  }, [setNavStatus, setNav2Props, cookieValue]);

  return (
    <div>
      <Product />
      <Testimonial />
      <Contact />
    </div>
  );
};

export default Home;
