import React, { useContext, useState, useEffect } from "react";
import NavTop from "./NavvTop";
import PhoneNav from "./phoneNav";
import bgvideo from "./img/backgroundvideo.mp4";
import Nav2 from "./Nav2";
import { Nav2Context } from "./Nav2context";
import { NavStatusContext } from "../components/NavStatusContext";
import "./css/style.css";

function NavBar() {
  
  const [isSticky, setIsSticky] = useState(false);
  const [isMobile, setIsMobile] = useState(window.innerWidth < 750);

  const handleScroll = () => {
    const videoBackgroundElement = document.getElementById("video-background");
    const scrollThreshold = videoBackgroundElement
      ? videoBackgroundElement.offsetHeight
      : 500;
    setIsSticky(window.scrollY > scrollThreshold);
  };

  useEffect(() => {
    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, []);

  useEffect(() => {
    const handleResize = () => {
      setIsMobile(window.innerWidth < 750);
    };

    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, []);

  const { navStatus } = useContext(NavStatusContext);
  const { nav2Props } = useContext(Nav2Context);

  const key = `${navStatus}`;
  if (navStatus) {
    return <PhoneNav fixed={isSticky ? "sticky" : ""} />;
  }

  return (
    <div key={key}>
      <div className="video-background" id="video-background">
        <video autoPlay muted loop id="background-video">
          <source src={bgvideo} type="video/mp4" />
          Your browser does not support the video tag.
        </video>

        {!navStatus && isMobile ? (
          <PhoneNav color="clear" fixed={isSticky ? "sticky" : ""} />
        ) : (
          <NavTop fixed={isSticky ? "sticky" : ""} />
        )}
        <Nav2 {...nav2Props} />
      </div>
    </div>
  );
}

export default NavBar;
