// ImageSlider.js

import React, { useState } from "react";
import "./ImageSlider.css"; // Import the CSS for the slider

const ImageSlider = ({ images }) => {
  const [currentSlide, setCurrentSlide] = useState(0);

  const nextSlide = () => {
    setCurrentSlide((prev) => (prev === images.length - 1 ? 0 : prev + 1));
  };

  const prevSlide = () => {
    setCurrentSlide((prev) => (prev === 0 ? images.length - 1 : prev - 1));
  };

  const goToSlide = (index) => {
    setCurrentSlide(index);
  };

  return (
    <div className="slider">
      <button className="prev" onClick={prevSlide}>
        &#10094;
      </button>
      <div className="slide-container">
        {images.map((image, index) => (
          <div
            key={index}
            className={`slide ${index === currentSlide ? "active" : ""}`}
          >
            {index === currentSlide && (
              <img src={image} alt={`Slide ${index}`} />
            )}
          </div>
        ))}
      </div>
      <button className="next" onClick={nextSlide}>
        &#10095;
      </button>
      <div className="dots">
        {images.map((_, index) => (
          <span
            key={index}
            className={`dot ${index === currentSlide ? "active" : ""}`}
            onClick={() => goToSlide(index)}
          ></span>
        ))}
      </div>
    </div>
  );
};

export default ImageSlider;
