import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { useParams, useNavigate } from 'react-router-dom';

const ProductView = () => {
  const [name, setUsername] = useState('');
  const [desc, setDesc] = useState([]);
  const [products, setProducts] = useState([]);
  const { id_produk } = useParams();
  const navigate = useNavigate();

  useEffect(() => {
    fetchUsername();
    axios
      .get(`http://localhost:5100/produkpictureid/${id_produk}`)
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
getDesc();
  }, []);
  const urljpg = 'http://localhost:5100/uploads/';
  const convertToJPEG = (url) => {
    const extension = url.slice(-3); // Get the file extension
    if (extension === 'jpg' || extension === 'jpeg') {
      return url; // Already a JPEG, return the same URL
    } else {
      // Convert to JPEG by replacing the file extension
      return url.replace(/\.[^.]+$/, '.jpeg');
    }
  };
  const getDesc = async () => {
    axios
    .get(`http://localhost:5100/productdesc/${id_produk}`)
    .then((response) => {
      // Convert the picture filenames to JPEG URLs
      const updatedProducts = response.data.map((productdesc) => {
const pictureUrl = `/uploads/${productdesc.picture}`;
const pictureUrlJPEG = convertToJPEG(pictureUrl);
console.log('pictureUrl:', pictureUrl);
console.log('pictureUrlJPEG:', pictureUrlJPEG);
return { ...productdesc, pictureUrlJPEG };
});
      setDesc(updatedProducts);
    })
    .catch((error) => {
      console.error(error);
    });
  };

  const fetchUsername = async () => {
    try {
      const response = await axios.get('http://localhost:5100/statustoken', {
        withCredentials: true, // Send cookies along with the request
      });

      const { id } = response.data;
      const userResponse = await axios.get(`http://localhost:5100/usermember/${id}`);
      const { name } = userResponse.data;
      setUsername(name);
    } catch (error) {
      console.error(error);
      navigate('/Login');
    }
  };

  const submitCart = async () => {
    try {
      const response = await axios.get('http://localhost:5100/statustoken', {
        withCredentials: true, // Send cookies along with the request
      });
      const { id } = response.data;
      await axios.post('http://localhost:5100/insertDataCart', {
        idcust: id,
        idproduct: id_produk,
      });
  
      navigate('/CartView');
      setUsername('');
    } catch (error) {
      console.error(error);
    }
  };

  return (
    <section className="text-gray-700 body-font overflow-hidden bg-white">
      <div className="container px-5 py-24 mx-auto">
        <div className="lg:w-4/5 mx-auto flex flex-wrap">
        {products.map((product) => (
          <img
            alt="ecommerce"
            className="lg:w-1/2 w-full object-cover object-center rounded border border-gray-200"
            src={`${urljpg}${product.picture}`}
          />
          ))}
          <div className="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
          {products.map((product) => (
            <h1 className="text-gray-900 text-3xl font-westbourne mb-1">{product.nama}</h1>
            ))}
                      {desc.map((productdesc) => (
            <p className="leading-relaxed font-creato">{productdesc.description}</p>
            ))}
            <div className="flex">
            {products.map((product) => (
              <span className="title-font font-creato text-2xl text-gray-900">Rp.{product.harga}</span>
              ))}
                {console.log('Nama:', name)}
      
  <button onClick={submitCart} className="flex ml-auto text-white bg-red-500 border-0 py-2 px-6 focus:outline-none hover:bg-red-600 rounded">
  Masukan Ke Kantong Belanja!
              </button>
            </div>
          </div>
        </div>
      </div>
    </section>
  );
};

export default ProductView;