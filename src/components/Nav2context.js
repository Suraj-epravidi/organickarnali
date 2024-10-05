import React, { createContext, useState } from "react";

export const Nav2Context = createContext();

export const Nav2Provider = ({ children }) => {
  const [nav2Props, setNav2Props] = useState({
    heading: "",
    subHeading: "",
    signup: "",
  });

  return (
    <Nav2Context.Provider value={{ nav2Props, setNav2Props }}>
      {children}
    </Nav2Context.Provider>
  );
};
