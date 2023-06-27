import axios from "axios";
import React from "react";
export const addProduct = async (product) => {
    try {
      const res = await axios.post("http://localhost:5100/produk_insert/", produk);
     
      
      return res.data;

    } catch (err) {
      console.log(err);
      return { error: err };
    }
  }; 
  export const addSelling = async (product) => {
    try {
      const res = await axios.post("http://localhost:5100/penjualan_insert/", produk);
     
      
      return res.data;

    } catch (err) {
      console.log(err);
      return { error: err };
    }
  }; 

 export const addMining = async (product) => {
    try {
     
    const res = await axios.get("http://localhost:5100/mining_insert/", mining);
      
        return res.data;

    } catch (err) {
      console.log(err);
      return { error: err };
    }
  };


