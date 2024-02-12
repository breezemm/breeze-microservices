import React, { createContext, useContext, useState } from 'react';

interface IntersectorState {
  isIntersecting: boolean;
}

const initialIntersectorState: IntersectorState = {
  isIntersecting: false,
};

const IntersectorContext = createContext<{
  state: IntersectorState;
  observeElement: (isIntersecting: boolean) => void;
}>({
  state: initialIntersectorState,
  observeElement: () => {},
});


export const IntersectorProvider= ({ children }:{children:React.ReactNode}) => {
  const [state, setState] = useState<IntersectorState>(initialIntersectorState);

 
  const observeElement = (isIntersecting: boolean) => {
    setState((prev) => ({ ...prev, isIntersecting }));
  };


  const contextValue = {
    state,
    observeElement,
  };

  return (
    <IntersectorContext.Provider value={contextValue}>
      {children}
    </IntersectorContext.Provider>
  );
};


export const useIntersector = () => {
  const context = useContext(IntersectorContext);
  if (!context) {
    throw new Error('useIntersector must be used within an IntersectorProvider');
  }
  return context;
};
