import React, { useState, useEffect } from 'react'
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import Cookies from 'js-cookie';
import jwt_decode from 'jwt-decode';

const HayatiHome = () => {
    const [nama, setUsername] = useState([]);
  const [token, setToken] = useState('');
  const navigate = useNavigate();

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
    return (
        <div className='container'>
            <div className='grid grid-cols-2 gap-5'>
                <div className='flex flex-col space-y-12'>
                    <h1 className='body-font font-westbourne text-8xl py-2'>Where Beauty Embraces Elegance, Naturally.</h1>
                    <p className='body-font font-creato text-xl'>Discover our online beauty shop, where elegance meets convenience. Explore a curated collection of skincare and makeup essentials that enhance your natural radiance. Indulge in luxurious formulations that nourish and rejuvenate your skin. Embrace your unique beauty with our expertly chosen range of beauty treasures.</p>
                </div>
                <div className='flex justify-center items-center'>
                    <img className='rounded-t-[12rem] w-[200%] h-[100%]]' src='hero.jpeg' />
                </div>
            </div>
            {/* <div className='bg-almostwhite w-full h-[40rem] my-32 mx-0 rounded-xl'>
                <div className='flex items-start'>
                    <h1 className='font-westbourne text-7xl py-24 px-8'>We Recommend This.</h1>
                </div>
                <div className='overflow-x-auto whitespace-nowrap no-scrollbar h-auto'>
                    <div className='flex flex-row'>
                    <div className='w-25% h-[25rem] scale-25 hover:drop-shadow-md px-4'>
            <div className='bg-white flex flex-col justify-start space-y-4 p-4'>
                <img className='relative rounded-xl object-cover h-48' src='https://images.unsplash.com/photo-1600595289052-bcab428c5b82?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80' />
                <div className='relative'>
                    <div className='text-creato'>
                        <h1>Scarlett Whitening</h1>
                        <p>Rp.150,000</p>
                    </div>
                </div>   
            </div>
        </div>
                    </div>
                </div>
            </div> */}
            <div className='grid grid-row-4 gap-8 my-auto'>
                <div className='font-creato text-xl text-center'>
                    About Us
                </div>
                <div className='font-westbourne text-6xl text-center'>
                    Melayani Sepenuh Hati
                </div>
                <div className='font-creato text-xl text-center'>
                Welcome to our online beauty shop, where elegance meets convenience. Discover a world of beauty essentials and transformative products that will enhance your natural radiance. From skincare to makeup, our carefully curated collection is designed to empower you to look and feel your best. Indulge in luxurious formulations that nourish, rejuvenate, and pamper your skin. With our expertly chosen range of beauty treasures, we strive to bring you the latest trends, timeless classics, and innovative solutions. Experience the joy of self-care and embrace your unique beauty with our online beauty shop, your go-to destination for all things glamorous.</div>
                <div className='flex space-x-4 justify-center items-center'>
                    <img className='h-auto w-auto' src='hero.jpeg'/>
                </div>
            </div>
        </div>
    )
}

export default HayatiHome;