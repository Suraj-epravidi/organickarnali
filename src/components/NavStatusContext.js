import React, { createContext, useState } from "react";

// Create context
export const NavStatusContext = createContext();

// Create a provider component
export const NavStatusProvider = ({ children }) => {
  const [navStatus, setNavStatus] = useState(true);

  return (
    <NavStatusContext.Provider value={{ navStatus, setNavStatus }}>
      {children}
    </NavStatusContext.Provider>
  );
};
