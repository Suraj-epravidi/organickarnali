import React, { useState, useEffect } from "react";
import useOnScreen from "./useOnScreen";
import "./css/style.css"; // Ensure to import the CSS file

const AnimatedComponent = ({
  animationType,
  children,
  animationDelay = "0s",
  animationDuration = "1s",
  exemptFromReset = false,
  exemptFromBubble = false, // New prop for exemption from bubble animation
}) => {
  const [ref, isIntersecting] = useOnScreen({ threshold: 0.1 });
  const [isVisible, setIsVisible] = useState(false);
  const [isHovered, setIsHovered] = useState(false);

  useEffect(() => {
    if (isIntersecting) {
      const timer = setTimeout(() => {
        setIsVisible(true);
      }, parseFloat(animationDelay) * 1000);
      return () => clearTimeout(timer);
    }
  }, [isIntersecting, animationDelay]);

  useEffect(() => {
    const handleScroll = () => {
      if (window.scrollY === 0 && !exemptFromReset) {
        setIsVisible(false);
      }
    };

    window.addEventListener("scroll", handleScroll);
    return () => window.removeEventListener("scroll", handleScroll);
  }, [exemptFromReset]);

  return (
    <div
      ref={ref}
      className={`${animationType} ${isVisible ? "visible" : ""} ${
        !exemptFromBubble && !isHovered ? "floating-on-hover" : ""
      }`}
      style={{
        animationDuration: animationDuration,
      }}
      onMouseEnter={() => setIsHovered(true)}
      onMouseLeave={() => setIsHovered(false)}
    >
      {children}
    </div>
  );
};

export default AnimatedComponent;
