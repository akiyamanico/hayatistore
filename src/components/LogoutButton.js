import React, { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import Cookies from 'js-cookie';

const LogoutButton = () => {
  const navigate = useNavigate();

  const handleLogout = () => {
    // Clear the authentication token from cookies
    Cookies.remove('token', { path: '/' });
    
    // Perform additional cleanup or state reset if needed

    // Redirect the user to the desired page after logout
    navigate('/');
  };

  useEffect(() => {
    handleLogout();
  }, []);

  return null; // Since this is a functional component, return null or a placeholder component.
};

export default LogoutButton;
