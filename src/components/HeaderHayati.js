import React, { useState, useEffect } from 'react';
import axios from 'axios';
import LogoutButton from './LogoutButton';
import { useNavigate } from 'react-router-dom';

const HeaderHome = () => {
  const [nama, setUsername] = useState('');
  const [token, setToken] = useState('');
  const navigate = useNavigate();
  const setNama = useState([]);

  useEffect(() => {
    fetchUsername();
  }, []);

  const fetchUsername = async () => {
  try {
    const token = Cookies.get('token');

    if (!token) {
      console.log('Token not found');
      return;
    }

    // Decode the token to extract the user ID
    const decodedToken = jwt_decode(token);
    const { id } = decodedToken;
    console.log('log id : ', id)
    // Use the user ID to fetch the username from the server
    const userResponse = await axios.get(`https://hayati.fly.dev/usermember/${id}`);
    const { nama } = userResponse.data;
    console.log('first method', nama)
    setUsername(nama);
    console.log('Token exists');
  } catch (error) {
    // Handle error
    console.error(error);
    console.log('Token does not exist');
  }
};
    const handleLogout = async () => {
      try {
        // Send a request to the server to perform the logout
        await axios.post('https://hayati.fly.dev/logout');
        
        // Redirect the user to the desired page after logout
        navigate('/');
        setUsername();
        setNama([]);
      } catch (error) {
        // Handle error if needed
        console.error(error);
      }
    };

  return (
    <header className="container">
      <div className="flex justify-between py-16 mx-auto">
        <div className="flex items-center">
          <a href="/"><h1 className="font-westbourne text-5xl">Hayati Store</h1></a>
        </div>
        <div className="flex items-center">
          <nav className="flex flex-row space-x-4">
            <ul className="flex font-creato font-thin uppercase">
              <a href="/Catalog"><li>Shop</li></a>
            </ul>
            {nama ? (
 <ul className="flex font-creato font-thin uppercase space-x-4">
 <a href='/CartView'><li>Cart</li></a>
 <a href='/StatusPayment'><li>Cek Status Pembayaran</li></a>
</ul>
            )
            : (
              <ul className="flex font-creato font-thin uppercase">

            </ul>
            )}
           
          </nav>
        </div>
        <div className="flex items-center">
  {console.log('Nama:', nama)}
  {nama ? (
      <button onClick={handleLogout}>  <h5 className="font-creato font-thin uppercase">
      Welcome, {nama}!
    </h5></button>
  ) 
   : (
    <a href="/Login">
      <h5 className="font-creato font-thin uppercase">Login</h5>
    </a>
  )}
</div>
      </div>
    </header>
  );
};

export default HeaderHome;