import React from 'react';
import arrow from './../../../img/arrow.png';

const Header = () => {
  return (
    <header>
      <div className="head">
        <img src={ arrow } alt='<' />
        <span>Оплата проезда</span>
      </div>
      <nav>
        <div className="tab active">Билет</div>
        <div className="tab">Проездной</div>
      </nav>
    </header>
  );
};

export default Header;
