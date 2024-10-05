import React from "react";

export default function Contact() {
  return (
    <section className="contact" id="contact">
      <span className="head">
        <h3>Get in Touch</h3>
        <p>Get in touch with us for any inquiry of questions you may have.</p>
      </span>
      <div className="body">
        <div className="form">
          <form action="/">
            <input
              type="text"
              placeholder="Full Name"
              className="ContactInput"
            />
            <input
              type="email"
              placeholder="Valid Email Address"
              className="ContactInput"
            />
            <textarea name="" id="" placeholder="Your Query/Message"></textarea>
            <button>Submit</button>
          </form>
        </div>
        <div className="map">
          <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d28276.89673688362!2d85.33106295850968!3d27.63652815651181!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb17627f431c4f%3A0x431cef6d28ec0407!2sUnited%20School!5e0!3m2!1sen!2snp!4v1719015225258!5m2!1sen!2snp"
            width="100%"
            height="100%"
            allowFullScreen=""
            loading="lazy"
            referrerPolicy="no-referrer-when-downgrade"
            title="map"
          ></iframe>
        </div>
      </div>
    </section>
  );
}
