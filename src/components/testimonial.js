import React, { useState, useEffect } from "react";
import LeftIcon from "./img/leftarrow.png";
import RightIcon from "./img/rightarrow.png";
import "./css/testimonial.css"; // Ensure you include this CSS file

// Assume Testimonybox is imported from your existing code
import Testimonybox from "./testimonybox";
import AnimatedComponent from "./AnimatedComponent";

const testimonies = [
  {
    star: 1,
    text: `One of the best mad honey, the health benifit of
the honey is way too much to pass on. Even if the
honey makes you have vomit.`,
    author: "Author 1",
  },
  {
    star: 2,
    text: `One of the best mad honey, the health benifit of
    the honey is way too much to pass on. Even if the
    honey makes you have vomit.`,
    author: "Author 2",
  },
  {
    star: 3,
    text: `One of the best mad honey, the health benifit of
    the honey is way too much to pass on. Even if the
    honey makes you have vomit.`,
    author: "Author 3",
  },
  {
    star: 4,
    text: `One of the best mad honey, the health benifit of
    the honey is way too much to pass on. Even if the
    honey makes you have vomit.`,
    author: "Author 4",
  },
  {
    star: 5,
    text: `One of the best mad honey, the health benifit of
    the honey is way too much to pass on. Even if the
    honey makes you have vomit.`,
    author: "Author 5",
  },
  {
    star: 5,
    text: `One of the best mad honey, the health benifit of
    the honey is way too much to pass on. Even if the
    honey makes you have vomit.`,
    author: "Author 6",
  },
  {
    star: 4,
    text: `The quality of the mad honey is amazing, and
    the taste is unique. I appreciate the fast delivery
    and great customer service.`,
    author: "Author 7",
  },
  {
    star: 3,
    text: `The honey is good, but the shipping took
    longer than expected. The taste is decent, but
    not exactly what I was looking for.`,
    author: "Author 8",
  },
  {
    star: 5,
    text: `Absolutely wonderful honey! The health benefits
    are noticeable, and I love the unique flavor. Will
    definitely buy again.`,
    author: "Author 9",
  },
  {
    star: 2,
    text: `The honey didn’t meet my expectations. The flavor
    was not as described, and I had some issues with
    the packaging.`,
    author: "Author 10",
  },
  {
    star: 5,
    text: `Incredible product! The honey is pure and has
    a distinct taste that sets it apart from others.
    Highly recommend it!`,
    author: "Author 11",
  },
  {
    star: 4,
    text: `Good quality honey, but the price is a bit
    high. The taste is great, and the health benefits
    are noticeable.`,
    author: "Author 12",
  },
  {
    star: 3,
    text: `The honey is okay, but I found it to be a bit
    too sweet for my liking. The benefits are there,
    but the flavor needs improvement.`,
    author: "Author 13",
  },
  {
    star: 5,
    text: `This honey is a game-changer! I’ve felt
    improvements in my health and love the natural
    taste. Fantastic product!`,
    author: "Author 14",
  },
  {
    star: 4,
    text: `Great honey with a unique flavor. It’s worth
    trying if you’re into natural products. The only
    downside was the delivery time.`,
    author: "Author 15",
  },
];

export default function Testimonial() {
  const [currentSlide, setCurrentSlide] = useState(0);
  const [fadeClass, setFadeClass] = useState("fade-in");
  const [windowWidth, setWindowWidth] = useState(window.innerWidth);

  const testimoniesPerSlide = windowWidth < 701 ? 1 : 3; // Display 1 testimony if width < 551px
  const numSlides = Math.ceil(testimonies.length / testimoniesPerSlide);

  useEffect(() => {
    const handleResize = () => {
      setWindowWidth(window.innerWidth);
    };

    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, []);

  const handlePrev = () => {
    setFadeClass("Tfade-out");
    setTimeout(() => {
      setCurrentSlide((prev) => (prev > 0 ? prev - 1 : numSlides - 1));
      setFadeClass("fade-in");
    }, 500); // Match this duration with the fade-out duration
  };

  const handleNext = () => {
    setFadeClass("Tfade-out");
    setTimeout(() => {
      setCurrentSlide((prev) => (prev < numSlides - 1 ? prev + 1 : 0));
      setFadeClass("fade-in");
    }, 500); // Match this duration with the fade-out duration
  };

  useEffect(() => {
    // Trigger initial fade-in effect
    const timer = setTimeout(() => {
      setFadeClass("Tfade-in");
    }, 100); // Small delay to ensure initial mount
    return () => clearTimeout(timer);
  }, []);

  const renderDots = () => {
    return Array.from({ length: numSlides }, (_, idx) => (
      <span
        key={idx}
        className={`dot ${idx === currentSlide ? "active" : ""}`}
        onClick={() => setCurrentSlide(idx)}
      />
    ));
  };

  return (
    <AnimatedComponent
      animationType="fade-in"
      animationDelay="0s"
      animationDuration="1s"
      exemptFromBubble={true} // Change to true if this component should be exempt from bubble animation
      exemptFromReset={true}
    >
      <section className="testimony">
        <span className="head">
          <h3>Happy Customers</h3>
          <p>Read what our customers have to say about us.</p>
        </span>
        <div className="testimonies">
          <span className="arrows">
            <img
              src={LeftIcon}
              alt="Left Arrow"
              onClick={handlePrev}
              className="arrow left"
            />
            <img
              src={RightIcon}
              alt="Right Arrow"
              onClick={handleNext}
              className="arrow right"
            />
          </span>

          <div className={`slides ${fadeClass}`}>
            {testimonies
              .slice(
                currentSlide * testimoniesPerSlide,
                currentSlide * testimoniesPerSlide + testimoniesPerSlide
              )
              .map((testimony, index) => (
                <Testimonybox
                  key={index}
                  text={testimony.text}
                  author={testimony.author}
                />
              ))}
          </div>
        </div>
        <div className="scroll">{renderDots()}</div>
      </section>
    </AnimatedComponent>
  );
}
