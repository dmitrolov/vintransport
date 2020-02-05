import React, { useEffect, useState } from 'react';
import './Ticket.sass';

interface TicketProps {

}

const Ticket = (props: TicketProps) => {
  const [state, setState] = useState(true);

  useEffect(() => {
    console.log('[Ticket WORKS!!!]', null);
  }, [state]);

  return (
    <>

    </>
  );
};

export default (Ticket);
