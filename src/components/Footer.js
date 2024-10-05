import React, { useState, useEffect } from "react";
import logo from "./img/logo_1.png";
import locationIcon from "./img/location_icon.png";
import mailIcon from "./img/mail_icon.png";
import phoneIcon from "./img/phone_icon.png";
import fbIcon from "./img/fb_icon.png";
import igIcon from "./img/ig_icon.png";
import PhoneFooter from "./phoneFooter";
import AnimatedComponent from "./AnimatedComponent"; // Import the animated component
export default function Footer() {
  const [isMobile, setIsMobile] = useState(window.innerWidth < 550);
  useEffect(() => {
    const handleResize = () => {
      setIsMobile(window.innerWidth < 701);
    };

    window.addEventListener("resize", handleResize);
    return () => window.removeEventListener("resize", handleResize);
  }, []);
  if (isMobile) {
    return (
      <AnimatedComponent
        animationType="slide-in"
        animationDuration="1s" // Example duration
        exemptFromBubble={true} // Change to true if this component should be exempt from bubble animation
      >
        <PhoneFooter />
      </AnimatedComponent>
    );
  } else {
    return (
      <AnimatedComponent
        animationType="slide-in"
        animationDuration="1s" // Example duration
        exemptFromBubble={true} // Change to true if this component should be exempt from bubble animation
        exemptFromReset={true} // Change to true if this component should be exempt
      >
        <footer>
          <div className="footerContent">
            <div className="footerLogo">
              <img src={logo} alt="Logo not Found." className="ftrLogo" />
              <p id="footerLogotxt">
                Best Organic product in the <br />
                market with quality assurance <br />
                and trust. Try with us today.
              </p>
              <div className="socials">
                <a href="/">
                  <img src={fbIcon} alt="" />
                </a>
                <a href="/">
                  {" "}
                  <img src={igIcon} alt="" />
                </a>
              </div>
            </div>
            <div className="footerInfo">
              <div className="qLinks">
                <h3>Quick Links</h3>

                <a href="about.html">About</a>
                <a href="shop.html">Shop</a>
                <a href="products.html">Product</a>
                <a href="profile.html">Profile</a>
              </div>
              <div className="office">
                <h3>Office</h3>

                <span>
                  <img src={locationIcon} alt="Location Icon" /> Mahalaxmi,
                  Lalitpur
                </span>
                <span>
                  <img src={mailIcon} alt="Mail Icon" /> info@organickarnali.com
                </span>
                <span>
                  <img src={phoneIcon} alt="Phone Icon" />
                  +977 - 9851015348
                </span>
              </div>
              <div className="subscribe">
                <h3>Subscribe</h3>

                <p>Join our mailing list to stay updated.</p>
                <span>
                  <form action="">
                    <input type="email" placeholder="Enter your Email" />
                  </form>
                  <button>Subscribe</button>
                </span>

                <p>
                  By subscribing, you agree to our Privacy Policy and consent
                  <br />
                  to receive updates from us.
                </p>
              </div>
            </div>
          </div>
          <span className="footerEnd">
            <p>
              &copy; 2024 Organic Karnali. All rights reserved | Forged By
              E-pravidi Pvt. Ltd.
            </p>
            <u>
              <p>Privacy Policy</p>
            </u>
            <u>
              <p>Terms & Conditions</p>
            </u>
            <span className="footerSocial">
              <a href="/">
                <img src={fbIcon} alt="" />
              </a>
              <a href="/">
                <img src={igIcon} alt="" />
              </a>
            </span>
          </span>
        </footer>
      </AnimatedComponent>
    );
  }
}
