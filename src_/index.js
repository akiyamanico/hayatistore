import React from 'react';
import ReactDOM from 'react-dom';
import App from './App';
import "bulma/css/bulma.css";
import axios from "axios";

import { ThemeProvider } from "@material-tailwind/react";
 
axios.defaults.withCredentials = true;
 
ReactDOM.render(
  <React.StrictMode>
    <ThemeProvider>
    <App />
    </ThemeProvider>
  </React.StrictMode>,
  document.getElementById('root')
);