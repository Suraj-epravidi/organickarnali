import React, { useRef, useEffect, useState } from "react";
import "../css/Scrollbar.css";

const CustomScrollbar = ({ children }) => {
  const contentRef = useRef(null);
  const [thumbHeight, setThumbHeight] = useState(0);
  const [thumbTop, setThumbTop] = useState(0);

  useEffect(() => {
    const content = contentRef.current;

    const updateThumbSizeAndPosition = () => {
      const scrollHeight = content.scrollHeight;
      const clientHeight = content.clientHeight;
      const scrollTop = content.scrollTop;

      const thumbHeight = Math.max(
        (clientHeight / scrollHeight) * clientHeight,
        20
      ); // Minimum thumb height
      const thumbTop = (scrollTop / scrollHeight) * clientHeight;

      setThumbHeight(thumbHeight);
      setThumbTop(thumbTop);
    };

    updateThumbSizeAndPosition();

    content.addEventListener("scroll", updateThumbSizeAndPosition);
    window.addEventListener("resize", updateThumbSizeAndPosition);

    return () => {
      content.removeEventListener("scroll", updateThumbSizeAndPosition);
      window.removeEventListener("resize", updateThumbSizeAndPosition);
    };
  }, []);

  return (
    <div className="custom-scrollbar">
      <div className="custom-scrollbar-content" ref={contentRef}>
        {children}
      </div>
      <div className="custom-scrollbar-track-vertical">
        <div
          className="custom-scrollbar-thumb-vertical"
          style={{ height: `${thumbHeight}px`, top: `${thumbTop}px` }}
        ></div>
      </div>
    </div>
  );
};

export default CustomScrollbar;
