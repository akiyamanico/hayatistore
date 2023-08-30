import React, { useState, useEffect } from 'react';
import axios from 'axios';
import jwt_decode from 'jwt-decode';
import { useNavigate } from 'react-router-dom';

const DiskonProduk = () => {
  const [name, setName] = useState('');
  const [token, setToken] = useState('');
  const [expire, setExpire] = useState('');
  const [users, setUsers] = useState([]);
  const [products, setProducts] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    refreshToken();
    getUsers();
    getProducts();
  }, []);

  const getProducts = async () => {
    try {
      const response = await axios.get('https://hayati.fly.dev/get-discount-produk');
      setProducts(response.data);
    } catch (error) {
      console.error(error);
    }
  };

  const refreshToken = async () => {
    try {
      const response = await axios.get('https://sequelizehayati.fly.dev/token');
      setToken(response.data.accessToken);
      const decoded = jwt_decode(response.data.accessToken);
      setName(decoded.name);
      setExpire(decoded.exp);
    } catch (error) {
      if (error.response) {
      }
    }
  };

  const axiosJWT = axios.create();

  axiosJWT.interceptors.request.use(async (config) => {
    const currentDate = new Date();
    if (expire * 1000 < currentDate.getTime()) {
      try {
        const response = await axios.get('https://sequelizehayati.fly.dev/token');
        config.headers.Authorization = `Bearer ${response.data.accessToken}`;
        setToken(response.data.accessToken);
        const decoded = jwt_decode(response.data.accessToken);
        setName(decoded.name);
        setExpire(decoded.exp);
      } catch (error) {
        console.error(error);
      }
    }
    return config;
  }, (error) => {
    return Promise.reject(error);
  });

  const getUsers = async () => {
    try {
      const response = await axiosJWT.get('https://sequelizehayati.fly.dev/users', {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      setUsers(response.data);
    } catch (error) {
      console.error(error);
    }
  };

  const updateDiscount = async (idProduk, totalDiskon) => {
    try {
      const response = await axios.post('https://hayati.fly.dev/update-discount', {
        id_produk: idProduk,
        totaldiscount: totalDiskon,
      });
      console.log(response.data);
    } catch (error) {
      console.error(error);
    }
  };

  const handleDiscountChange = async (id_produk, newTotalDiskon) => {
    const updatedProduct = products.map((product) => 
        product.id_produk === id_produk
        ? { ...product, totaldiskon: newTotalDiskon }
        : product
    );
    setProducts(updatedProduct);
    updateDiscount(id_produk, newTotalDiskon);
};

  const handleFormSubmit = (event, idProduk, diskon) => {
    event.preventDefault();
    updateDiscount(idProduk, diskon);
    navigate('/DiskonProduk')
  };
  const calculatePriceWithDiscount = (price, discount) => {
    const discountedPrice = price - (price * discount / 100);
    return discountedPrice.toFixed(2); // Adjust the number of decimal places as needed
  };
  return (
    <div className="container mt-5">
      <div className="buttons">
        <div id="page-wrapper">
          <div className="row col-lg-12 w-full">
            <div className="panel panel-primary my-12">
              <div className="panel-heading flex align-middle justify-between px-4">
                <p className="text-xl font-bold">Data Produk Diskon</p>
            </div>
            <div className="panel-body w-full my-8">
              <form onSubmit={handleFormSubmit}>
                <table className="table table-bordered table-hover" id="dataTables-example">
                  <thead>
                    <tr>
                      <th>ID Produk</th>
                      <th>Nama</th>
                      <th>Harga Sekarang</th>
                      <th>Diskon</th>
                      <th>Harga Setelah Diskon</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                    {products.map((product) => (
                      <tr key={product.id_produk}>
                        <td>{product.id_produk}</td>
                        <td>{product.nama}</td>
                        <td>{product.harga}</td>
                        <td>
                          <input
                            type="text"
                            value={product.totaldiskon}
                            onChange={(event) =>
                              handleDiscountChange(product.id_produk, event.target.value)
                            }
                          />
                        </td>
                        <td>{calculatePriceWithDiscount(product.harga, product.totaldiskon)}</td>
                        <td>
                          <button type="submit">Update Diskon</button>
                        </td>
                      </tr>
                    ))}
                  </tbody>
                </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  );
};

export default DiskonProduk;
