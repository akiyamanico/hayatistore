import React, { useState, useEffect } from 'react'
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import Cookies from 'js-cookie';
import jwt_decode from 'jwt-decode';

const StatusPayment = () => {
    const [nama, setUsername] = useState([]);
  const [token, setToken] = useState('');
  const [cartMember, setCart] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    fetchUsername();
    getCartMember();
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
      const userResponse = await axios.get(`https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/usermember/${id}`);
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

const getCartMember = async () => {
  try {
    const token = Cookies.get('token');

    if (!token) {
      console.log('Token not found');
      return;
    }

    // Decode the token to extract the user ID
    const decodedToken = jwt_decode(token);
    const { id } = decodedToken;
    const cartMemberConst = await axios.get(`https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/getcartmember/${id}`);
    const updatedProducts = cartMemberConst.data.map((cartMemberProof) => ({
      ...cartMemberProof,
      pictureUrlJPEG: convertToJPEG(`/uploads/${cartMemberProof.buktipembayaran}`),
    }));
    setCart(updatedProducts);
  } catch (error) {
    console.error(error);
    console.log('Token does not exist');
  }
};

const convertToJPEG = (url) => {
  const extension = url.slice(-3);
  if (extension === 'jpg' || extension === 'jpeg') {
    return url;
  } else {
    return url.replace(/\.[^.]+$/, '.jpeg');
  }
};

const urljpg = 'https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/uploads/';
    return (
      <div class="h-100 w-full flex flex-grow items-center justify-center bg-teal-lightest font-creato">
      <div class="rounded shadow p-6 bg-gray-50">
            <div class="mb-4">
                <h1 class="text-grey-darkest">Status Pembayaran</h1>      
            </div>
            <div>
              {cartMember.map((cartcustomer) => 
                <div class="flex flex-grow mb-4 justify-items-start">
                    <p class="w-full text-grey-darkest">List Barang : {cartcustomer.produk}</p>
                    <p class="w-full text-grey-darkest">Total Bayar : {cartcustomer.totalbayar}</p>
                    <p class="w-full text-grey-darkest">Bukti Pembayaran : <img
                src={`${urljpg}${cartcustomer.buktipembayaran}`}
                alt="product-image"
                className="w-full rounded-lg sm:w-40"
              /></p>
                    <p class="flex-no-shrink p-2 ml-4 mr-2">{cartcustomer.status}</p>
                </div>
              )}
            </div>
        </div>
    </div>
    )
}

export default StatusPayment;