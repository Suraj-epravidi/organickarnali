import React from "react";

import AnimatedComponent from "./AnimatedComponent";
export default function Nav2(props) {
  return (
    <div className={`navBg ${props.nav2State}`}>
      <AnimatedComponent
        animationType="fade-in"
        animationDelay="0s"
        animationDuration="1s"
        exemptFromReset={true} // Change to true if this component should be exempt
        exemptFromBubble={true} // Change to true if this component should be exempt from bubble animation
      >
        <h1>{props.heading}</h1>

        <p>{props.subHeading}</p>
      </AnimatedComponent>
    </div>
  );
}
