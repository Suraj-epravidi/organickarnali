import React, { useContext, useEffect } from "react";
import { Nav2Context } from "../components/Nav2context";
import About from "../components/about";
import Contact from "../components/contact";
import Testimonial from "../components/testimonial";
import { NavStatusContext } from "../components/NavStatusContext";

export default function AboutUs(props) {
  const { setNavStatus } = useContext(NavStatusContext);
  const cookieValue = props.sessionId;
  document.title = "Organic Karnali - About Us";
  const { setNav2Props } = useContext(Nav2Context);

  useEffect(() => {
    setNavStatus(true);
    setNav2Props({
      heading: "About Us",
      subHeading: "Organic products from the hearts of karnali.",
      signup: cookieValue ? "hide" : "hide",
      shop: cookieValue ? "hide" : "hide",
    });
  }, [setNavStatus, setNav2Props, cookieValue]);

  return (
    <div className="pages">
      <About />
      <Testimonial />
      <Contact />
    </div>
  );
}
