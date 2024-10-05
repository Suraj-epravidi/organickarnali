import React from "react";
import Icon from "./img/testUser_icon.png";
export default function comment() {
  return (
    <div className="question">
      <div className="head">
        <h3>Frequently Asked Questions:</h3>
        <p>These are some questions that our costumers ask to us frequently.</p>
      </div>
      <div className="body">
        <div className="questions">
          <div class="customer qusBox">
            <div className="left">
              <img src={Icon} alt="" />
              <div className="details">
                <p>User</p>
                <p>Customer</p>
              </div>
            </div>
            <div className="right">
              <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem
                repudiandae, mollitia ad, voluptates ducimus repellat atque
                harum quidem tempore vitae quo vero aliquam laudantium
                exercitationem?
              </p>
            </div>
          </div>

          <div class="seller qusBox">
            {" "}
            <div className="left">
              <img src={Icon} alt="" />
              <div className="details">
                <p>User</p>
                <p>Customer</p>
              </div>
            </div>
            <div className="right">
              <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem
                repudiandae, mollitia ad, voluptates ducimus repellat atque
                harum quidem tempore vitae quo vero aliquam laudantium
                exercitationem?
              </p>
            </div>
          </div>
        </div>
        <div className="questions">
          <div class="customer qusBox">
            <div className="left">
              <img src={Icon} alt="" />
              <div className="details">
                <p>User</p>
                <p>Customer</p>
              </div>
            </div>
            <div className="right">
              <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem
                repudiandae, mollitia ad, voluptates ducimus repellat atque
                harum quidem tempore vitae quo vero aliquam laudantium
                exercitationem?
              </p>
            </div>
          </div>

          <div class="seller qusBox">
            {" "}
            <div className="left">
              <img src={Icon} alt="" />
              <div className="details">
                <p>User</p>
                <p>Customer</p>
              </div>
            </div>
            <div className="right">
              <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem
                repudiandae, mollitia ad, voluptates ducimus repellat atque
                harum quidem tempore vitae quo vero aliquam laudantium
                exercitationem?
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  );
}