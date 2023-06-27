import React, { useEffect } from 'react';
import { useNavigate } from 'react-router-dom';
import Cookies from 'js-cookie';

const LogoutButton = () => {
  const navigate = useNavigate();

  const handleLogout = () => {
    // Clear the authentication token from cookies
    document.cookie = `token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;`;
    Cookies.remove('token');
    
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
