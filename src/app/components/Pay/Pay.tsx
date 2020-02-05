import React, { useState } from 'react';
import './Pay.sass';

interface PayProps {
  onSubmit: () => void
}

const Pay = (props: PayProps) => {
  const [number, setNumber] = useState();
  const [count, setCount] = useState('1');

  return (
    <div className='pay-container'>
      <input className='pay-container__number'
             type="text"
             inputMode='numeric'
             placeholder='Маршрут'
             value={ number }
             onChange={ e => setNumber(e.target.value) } />
      <input className='pay-container__count'
             type="text"
             inputMode='numeric'
             placeholder='Кол-во билетов'
             value={ count }
             onChange={ e => setCount(e.target.value) } />
      <button className='pay-container__submit'>Купить</button>
    </div>
  );
};

export default (Pay);
