import React, { useState } from 'react';
import './App.sass';
import Header from './components/Header/Header';
import Pay from './components/Pay/Pay';
import Ticket from './components/Ticket/Ticket';

const App = () => {
  const [isTicketBought, setIsTicketBought] = useState(false);

  return (
    <div className="app">
      <Header/>
      {isTicketBought ? <Ticket/> : <Pay onSubmit={() => setIsTicketBought(true)}/>}
    </div>
  );
}

export default App;
