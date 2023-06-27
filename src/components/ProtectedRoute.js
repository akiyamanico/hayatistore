import React from 'react';
import { Route, Navigate } from 'react-router-dom';

const ProtectedRoute = ({ component: Component, ...rest }) => {
  const isAuthenticated = !!document.cookie.split(';').find((item) => item.trim().startsWith('token='));

  return (
    <Route
      {...rest}
      element={isAuthenticated ? <Component /> : <Navigate to="/login" />}
    />
  );
};

export default ProtectedRoute;


