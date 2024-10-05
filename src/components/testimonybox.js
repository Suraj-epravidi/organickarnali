import React from "react";
import Star from "./img/star.png";
import Profile from "./img/testUser_icon.png";
export default function testimonybox(props) {
  return (
    <div className="testimony1 Ctestimony">
      <div className="star">
        <img src={Star} alt="" />
        <img src={Star} alt="" />
        <img src={Star} alt="" />
        <img src={Star} alt="" />
        <img src={Star} alt="" />
      </div>

      <p>{props.text}</p>
      <span className="testifoot">
        <span>
          {" "}
          <img src={Profile} alt="" className="testimonyUser" />
        </span>
        <span>
          <h3>{props.author}</h3>
          <p>Customer</p>
        </span>
      </span>
    </div>
  );
}
