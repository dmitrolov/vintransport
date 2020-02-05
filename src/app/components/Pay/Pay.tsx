import React, { useEffect, useState } from 'react';
import './Pay.sass';

interface PayProps {
  onSubmit: () => void
}

const Pay = (props: PayProps) => {
  const [state, setState] = useState(true);

  useEffect(() => {
    console.log('[Pay WORKS!!!]', null);
  }, [state]);

  return (
    <div className='pay'>
      <button onClick={ props.onSubmit }>Pay</button>
    </div>
  );
};

export default (Pay);
