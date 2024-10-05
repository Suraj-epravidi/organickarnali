import React, { useRef, useEffect, useState } from "react";
import "./css/Scrollbar.css";
const CustomScrollbar = ({ children }) => {
  const [scrollbarHeight, setScrollbarHeight] = useState(0);
  const contentRef = useRef(null);
  const thumbRef = useRef(null);

  useEffect(() => {
    const updateScrollbar = () => {
      if (contentRef.current && thumbRef.current) {
        const contentHeight = contentRef.current.scrollHeight;
        const containerHeight = contentRef.current.clientHeight;
        const thumbHeight = Math.max(
          containerHeight * (containerHeight / contentHeight),
          30
        );
        setScrollbarHeight(thumbHeight);

        const onScroll = () => {
          const scrollTop = contentRef.current.scrollTop;
          thumbRef.current.style.top = `${
            (scrollTop / contentHeight) * containerHeight
          }px`;
        };

        contentRef.current.addEventListener("scroll", onScroll);
        return () => contentRef.current.removeEventListener("scroll", onScroll);
      }
    };

    updateScrollbar();
  }, [children]);

  return (
    <div className="scrollbar-container">
      <div className="scrollbar-content" ref={contentRef}>
        {children}
      </div>
      <div className="scrollbar-track">
        <div
          className="scrollbar-thumb"
          ref={thumbRef}
          style={{ height: scrollbarHeight }}
        />
      </div>
    </div>
  );
};

export default CustomScrollbar;
