import React, { useEffect, useState } from 'react';
import './Header.sass';

interface HeaderProps {

}

const Header = (props: HeaderProps) => {
  const [state, setState] = useState(true);

  useEffect(() => {
    console.log('[Header WORKS!!!]', null);
  }, [state]);

  return (
    <div className='header'>
      <button onClick={ () => setState(!state) }>Header WORKS!!!</button>
    </div>
  );
};

export default Header;
