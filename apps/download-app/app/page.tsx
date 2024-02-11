import React from 'react';
import HeroSection from './components/HeroSection';
import FeatCardsSection from './components/FeatCardsSection';

const HomePage = () => {
  return (
    <main className='p-4 md:p-16'>
      <HeroSection />
      <FeatCardsSection />
    </main>
  );
};

export default HomePage;
