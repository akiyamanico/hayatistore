import React, { useState, useEffect } from 'react';
import axios from 'axios';
import { Navigate, useNavigate, useParams } from 'react-router-dom';
import Cookies from 'js-cookie';
import jwt_decode from 'jwt-decode';

const CartView = () => {
  const [nama, setUsername] = useState('');
  const [namapenerima, setNamaPenerima] = useState('');
  const [alamat, setAlamat] = useState('');
  const [nomortelp, setNomorTelp] = useState('');
  const [quantity, setQuantity] = useState(1);
  const [products, setProducts] = useState([]);
  const [idproduct, setIdProduct] = useState([]);
  const [idUser, setIdUser] = useState([]);
  const navigate = useNavigate();
  const [buktipembayaran, setBukti] = useState(null);
  const {id_kategori} = useParams();
  const [discountProducts, setDiscountProducts] = useState([]);
  useEffect(() => {
    fetchUsername();
    getCartData();
  }, []);

  const decreaseQuantity = async (id_produk) => {
    if (quantity > 1) {
      setQuantity(quantity - 1);
    }
  };

  const increaseQuantity = () => {
    setQuantity(quantity + 1);
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
      const userResponse = await axios.get(`https://hayati.fly.dev/usermember/${id}`);
      const { nama } = userResponse.data;
      setIdUser(id);
      setUsername(nama);
      const customerDiscountResponse = await axios.get(`https://hayati.fly.dev/get-discount-cust/${id}`);
      if (customerDiscountResponse.data.length > 0) {
        const discountResponse = await axios.get(`https://hayati.fly.dev/get-discount-produk`);
        setDiscountProducts(discountResponse.data);
        console.log('discount data', discountResponse);
      }
      console.log('Token exists');
    } catch (error) {
      console.error(error);
      console.log('Token does not exist');
    }
  };

  const getCartData = async () => {
    try {
      const token = Cookies.get('token');
  
      if (!token) {
        console.log('Token not found');
        return;
      }
  
      // Decode the token to extract the user ID
      const decodedToken = jwt_decode(token);
      const { id } = decodedToken;
      const response = await axios.get(`https://hayati.fly.dev/cartlist/${id}`);
      const updatedProducts = response.data.map((product) => ({
        ...product,
        pictureUrlJPEG: convertToJPEG(`/uploads/${product.picture}`),
      }));
      setProducts(updatedProducts);
      const idproduct = response.data.map((product) => product.id_produk)
      setIdProduct(idproduct);
    } catch (error) {
      console.error(error);
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

  const deleteData = async (id_produk) => {
    try {
      await axios.get(`https://hayati.fly.dev/removecart/?idcust=${idUser}&idproduk=${id_produk}`);
      getCartData();
    } catch (error) {
      console.error(error);
    }
  };

  const InsertData = async (event) => {
    event.preventDefault();
    let produkNama;
    const statuspembayaran = 'Belum Dibayar';
    try {
      const token = Cookies.get('token');
      const decodedToken = jwt_decode(token);
      const { id } = decodedToken;
      console.log('id berbelanja', id);
      produkNama = products.map((product) => product.nama).join(', ');
    } catch (error) {
      console.error(error);
      return;
    }
    try {
      const token = Cookies.get('token');
      const decodedToken = jwt_decode(token);
      const { id } = decodedToken;
      const response = await axios.get(`https://hayati.fly.dev/cartlist/${id}`);
      console.log('response.data:', response.data);
      const  idproductres = response.data.map((product) => product.id_produk)
      setIdProduct(idproductres);
      const formData = new FormData();
      formData.append('quantity', quantity);
      await axios.post('https://hayati.fly.dev/updatequantity', { idproductres, quantity, idcustomer: id });
      console.log('Success!');
    } catch (error) {
      console.error('Error :', error);
    }
    try {
      const token = Cookies.get('token');
      const decodedToken = jwt_decode(token);
      const { id } = decodedToken;
      const formData = new FormData();
      formData.append('id', id);
      formData.append('nama', namapenerima);
      formData.append('alamat', alamat);
      formData.append('nomortelp', nomortelp);
      formData.append('produk', produkNama);
      formData.append('quantity', quantity);
      formData.append('totalbayar', calculateSubtotal());
      formData.append('buktipembayaran', buktipembayaran);
      await axios.post('https://hayati.fly.dev/cart_insert', formData);
    } catch (error) {
      if (error.response) {
        console.error(error.response.data.msg);
        console.log('Error!', error.response.data.msg);
      } else {
        console.error(error);
      }
    }
    navigate('/StatusPayment')
    try {
      console.log('Success!');
    } catch (error) {
      console.error('Error :', error);
    }

  };

  const handleChange = (event) => {
    const newQuantity = parseInt(event.target.value);
    if (!isNaN(newQuantity) && newQuantity >= 1) {
      setQuantity(newQuantity);
    }
  };

  const calculateSubtotal = () => {
    let total = 0;
  
    products.forEach((product) => {
      const harga = parseFloat(product.harga);
      // Assuming each product has a quantity property
      console.log('harga', harga)

      if (discountProducts && discountProducts.length > 0) {
        const discountProduct = discountProducts.find((discount) => discount.id_produk === product.id_produk);
  
        if (discountProduct) {
          const discountedPrice = calculateDiscountedPrice(harga, discountProduct.totaldiskon);
          console.log('discountedlog', discountedPrice)
          total += quantity * discountedPrice;
          console.log('total', total)
          console.log('total', quantity)
        } else {
          total += quantity * harga;
        }
      } else {
        total += quantity * harga;
      }
    });
  
    return total;
  };
  
  const calculateDiscountedPrice = (price, totaldiskon) => {
    const discountedPrice = price - (price * totaldiskon / 100);
    return discountedPrice;
  };

  const urljpg = 'https://hayati.fly.dev/uploads/';

  return (
    <div className="h-screen bg-gray-100 pt-20">
      <h1 className="mb-10 text-center text-2xl font-creato">Kantong Belanja</h1>
      <div className="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0">
        <div className="rounded-lg md:w-2/3">
          {products.map((product) => (
            <div
              key={product.id}
              className="justify-between mb-6 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start"
            >
              <img
                src={`${urljpg}${product.picture}`}
                alt="product-image"
                className="w-full rounded-lg sm:w-40"
              />
              <div className="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                <div className="mt-5 sm:mt-0">
                  <h2 className="text-lg font-bold text-gray-900">{product.nama}</h2>
                  <p className="mt-1 text-xs text-gray-700">{product.id_kategori}</p>
                </div>
                <div className="mt-4 flex justify-between sm:space-y-6 sm:mt-0 sm:block sm:space-x-6">
                  <div className="flex items-center border-gray-100">
                    <span
                      className="cursor-pointer rounded-l bg-gray-100 py-1 px-3.5 duration-100 hover:bg-blue-500 hover:text-blue-50"
                      onClick={() => decreaseQuantity(product.id_produk)}
                    >
                      -
                    </span>
                    <input
                      className="h-8 w-8 border bg-white text-center text-xs outline-none"
                      type="number"
                      value={quantity}
                      min="1"
                      onChange={handleChange}
                    />
                    <span
                      className="cursor-pointer rounded-r bg-gray-100 py-1 px-3 duration-100 hover:bg-blue-500 hover:text-blue-50"
                      onClick={increaseQuantity}
                    >
                      +
                    </span>
                  </div>
                  <div className="flex items-center space-x-4">
                  {discountProducts && discountProducts.length > 0 ? (
    <>
      {discountProducts.find((discountProduct) => discountProduct.id_produk === product.id_produk) ? (
        <>
          <p className="text-sm text-red-500 line-through">Rp.{product.harga}</p>
          {discountProducts.map((discountProduct) => {
            console.log('check data 1', discountProducts);
            console.log('check data 2', discountProduct);
            if (discountProduct.id_produk === product.id_produk) {
              const discountedPrice = calculateDiscountedPrice(product.harga, discountProduct.totaldiskon);
              return <p className="text-sm">Rp.{discountedPrice}</p>;
            }
            return null;
          })}
        </>
      ) : (
        <p className="text-sm">Rp.{product.harga}</p>
      )}
    </>
  ) : (
    <p className="text-sm">Rp.{product.harga}</p>
  )}
                    <svg
                      onClick={() => deleteData(product.id_produk)}
                      xmlns="http://www.w3.org/2000/svg"
                      fill="none"
                      viewBox="0 0 24 24"
                      strokeWidth="1.5"
                      stroke="currentColor"
                      className="h-5 w-5 cursor-pointer duration-150 hover:text-red-500"
                    >
                      <path strokeLinecap="round" strokeLinejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </div>
                </div>
              </div>
            </div>
          ))}
        </div>

        <div className="h-full rounded-lg border bg-white shadow-md md:mt-0 md:w-1/3 flex">


 
            <p className="text-gray-700">Subtotal</p>
            <p className="text-gray-700">Rp. {calculateSubtotal()}</p>
       
          <div>
            <form onSubmit={InsertData}>
              <p className="text-gray-700">Produk Yang Akan Dibeli : </p>

              {products.map((product) => (
                <p
                  key={product.id}
                  className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                  {product.nama}
                </p>
              ))}
              <p className="text-gray-700">Total yang akan dibayar : </p>
              <p
                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              >
                Rp. {calculateSubtotal()}
              </p>
              <p className="text-gray-700">Nama Penerima</p>
              <input
                type="text"
                value={namapenerima}
                onChange={(event) => setNamaPenerima(event.target.value)}
                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              />
              <p className="text-gray-700">Alamat</p>
              <input
                type="text"
                value={alamat}
                onChange={(event) => setAlamat(event.target.value)}
                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              />
              <p className="text-gray-700">Nomor Telpon</p>
              <input
                type="text"
                value={nomortelp}
                onChange={(event) => setNomorTelp(event.target.value)}
                className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
              />
              <p className="text-gray-700">Upload Bukti Pembayaran</p>
              <input
                type="file"
                className="form-control-file"
                name="buktipembayaran"
                onChange={(event) => setBukti(event.target.files[0])}
              />
                      <p className="text-gray-700">Sebelum Melakukan Transaksi Harap Melakukan Transfer ke Nomor Data Atau No Rek Yang Tersedia Di Bawah Ini</p>
          <p className="text-gray-700">Dana : 081277467118 A/N Fi Zilalil Huda</p>
          <p className="text-gray-700">Bank Jago : 103687829082 A/N Fi Zilalil Huda</p>
                <button
                  type="submit"
                  className="mt-4 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
                >
                  Bayar
                </button>
            </form>
          </div>
        </div>
      </div>
    </div>
  );
};

export default CartView;