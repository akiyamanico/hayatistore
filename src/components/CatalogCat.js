import React, { useState, useEffect } from 'react'
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";
import axios from 'axios';
import Cookies from 'js-cookie';
import jwt_decode from 'jwt-decode';

const CatalogCat = () => {
  const [nama, setUsername] = useState([]);
  const [token, setToken] = useState('');
  const [products, setProducts] = useState([]);
  const [category, setCat] = useState([]);
  const navigate = useNavigate();
  useEffect(() => {
    fetchCat();
    fetchUsername();
    axios
      .get('https://hayati.fly.dev/produkpicturecat')
      .then((response) => {
        // Convert the picture filenames to JPEG URLs
        const updatedProducts = response.data.map((product) => {
  const pictureUrl = `/uploads/${product.picture}`;
  const pictureUrlJPEG = convertToJPEG(pictureUrl);
  console.log('pictureUrl:', pictureUrl);
  console.log('pictureUrlJPEG:', pictureUrlJPEG);
  return { ...product, pictureUrlJPEG };
});
        setProducts(updatedProducts);
      })
      .catch((error) => {
        console.error(error);
      });
  }, []);

  const urljpg = 'https://hayati.fly.dev/uploads/';
  const convertToJPEG = (url) => {
    const extension = url.slice(-3); // Get the file extension
    if (extension === 'jpg' || extension === 'jpeg') {
      return url; // Already a JPEG, return the same URL
    } else {
      // Convert to JPEG by replacing the file extension
      return url.replace(/\.[^.]+$/, '.jpeg');
    }
  };
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

  const fetchCat = async () => {
    const response = await axios.get('https://hayati.fly.dev/categorylist');
    setCat(response.data);
    console.log('category:', category)
  };
  
      const handleLogout = async () => {
        try {
          // Send a request to the server to perform the logout
          await axios.post('https://hayati.fly.dev/logout');
          
          // Redirect the user to the desired page after logout
          navigate('/');
          setUsername('');
        } catch (error) {
          // Handle error if needed
          console.error(error);
        }
      };

    return (
  <div class="relative flex px-16">
    <div class="relative border-solid border-2 border-sky-500 rounded-md">
      <div class="p-5 bg-white rounded-lg flex items-center justify-between space-x-8">
        <div class="flex-1 flex items-start">
          <div class="h-6 w-48 bg-blue-gray-50 to-almostwhite rounded text-center text-black font-westbourne">
          <p>Kategori</p></div>
        </div>
      </div>
      <div class="p-5 bg-white rounded-lg font-creato flex justify-between space-x-8">
        <div class="flex-1 flex-row">
          {category.map((id_kategori) => (
          <p>{id_kategori.id_kategori}</p>
          ))}
          {/* <p>Kategori 1</p>
          <p>Kategori 1</p>
          <p>Kategori 1</p>
          <p>Kategori 1</p>
          <p>Kategori 1</p> */}
        </div>
      </div>
    </div>
    <div class="min-h-auto flex flex-col ">
  <div class="relative m-3 flex flex-wrap mx-auto justify-between">
  {products.map((product) => (
    <Link to={`/ProductView/${product.id_produk}`}>
    <div class="relative max-w-sm min-w-[340px] bg-white shadow-md rounded-3xl p-2 mx-1 my-3 cursor-pointer">
    <div class="overflow-x-hidden rounded-2xl relative">
      <img class="h-40 rounded-2xl w-full object-cover" src={`${urljpg}${product.picture}`}></img>
        {console.log('Nama:', nama)}
      {nama ? (
      <p class="absolute right-2 top-2 bg-white rounded-full p-2 cursor-pointer group">
      </p>
      )
      : (
        <a href="/Login"><p class="absolute right-2 top-2 bg-white rounded-full p-2 cursor-pointer group">
      </p></a>
      )}
    </div>
    <div class="mt-4 pl-2 mb-2 flex justify-between ">
      <div>
        <p class="text-lg font-creato text-gray-900 mb-0">{product.nama}</p>
        <p class="text-md text-gray-800 mt-0">Rp.{product.harga}</p>
      </div>
      <div class="flex flex-col-reverse mb-1 mr-4 group cursor-pointer">
      </div>
    </div>
  </div>    
  </Link>  
  ))}

  </div>
</div>
</div>

    )
}

export default CatalogCat;