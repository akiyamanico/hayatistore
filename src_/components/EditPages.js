/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";
import { Combobox } from '@headlessui/react'

const EditPages = () => {
    const [id_produk, setIdProduct] = useState('');
    const [nama, setName] = useState('');
    const [id_kategori, setIdCat] = useState('');
    const [stok, setStock] = useState('');
    const [harga, setPrice] = useState('');
    const [token, setToken] = useState('');
    const [expire, setExpire] = useState('');
    const [users, setUsers] = useState([]);
    const navigate = useNavigate();
    const [msg, setMsg] = useState('');
    const [id, setId] = useState(useParams());

    useEffect(() => {
        refreshToken();
        getUsers();
        getProductById();

    }, []);

    const UpdateProduct = async (e) => {
      e.preventDefault();
      try {
          await axios.patch('http://localhost:5000/patch', {
              id_produk: id_produk,
              nama: nama,
              id_kategori: id_kategori,
              stok: stok,
              harga: harga
          });
          await axios.post('http://localhost:5100/mining_insert', {
              id_produk: id_produk
          });
          await axios.post('http://localhost:5100/penjualan_insert', {
              id_produk: id_produk
          });
          navigate('/Dashboard');
      } catch (error) {
          if (error.response) {
              setMsg(error.response.data.msg);
          }
      }
  }
  const getProductById = async () => {
    const response = await axios.get(`http://localhost:5000/produk/${id_produk}`);
    setId(response.data);
    setName(response.data);
    setPrice(response.data);
    setStock(response.data);
}

    const refreshToken = async () => {
        try {
            const response = await axios.get('http://localhost:5000/token');
            setToken(response.data.accessToken);
            const decoded = jwt_decode(response.data.accessToken);
            setName(decoded.name);
            setExpire(decoded.exp);
        } catch (error) {
            if (error.response) {
                navigate('/');
            }
        }
    }
    const axiosJWT = axios.create();

    axiosJWT.interceptors.request.use(async (config) => {
        const currentDate = new Date();
        if (expire * 1000 < currentDate.getTime()) {
            const response = await axios.get('http://localhost:5000/token');
            config.headers.Authorization = `Bearer ${response.data.accessToken}`;
            setToken(response.data.accessToken);
            const decoded = jwt_decode(response.data.accessToken);
            setName(decoded.name);
            setExpire(decoded.exp);
        }
        return config;
    }, (error) => {
        return Promise.reject(error);
    });

    const getUsers = async () => {
        const response = await axiosJWT.get('http://localhost:5000/users', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        });
        setUsers(response.data);
    }
    const Logout = async () => {
        try {
            await axios.delete('http://localhost:5000/logout');
            navigate('/');
        } catch (error) {
            console.log(error);
        }
    }

      
    return (

      <section className="hero has-background-grey-light is-fullheight is-fullwidth">
            <div className="hero-body">
                <div className="container">
                    <div className="columns is-centered">
                        <div className="column is-4-desktop">
                            <form onSubmit={UpdateProduct} className="box">
                                <p className="has-text-centered">{msg}</p>
                                <div className="field mt-5">
                                    <label className="label">ID Produk</label>
                                    <div className="controls">
                                        <input type="text" className="input" placeholder="ID Produk"
                                            value={id_produk} onChange={(e) => setIdProduct(e.target.value)} />
                                    </div>
                                </div>
                                <div className="field mt-5">
                                    <label className="label">Nama Produk</label>
                                    <div className="controls">
                                        <input type="text" className="input" placeholder="Nama"
                                           value={nama} onChange={(e) => setName(e.target.value)} />
                                    </div>
                                </div>
                                <div className="field mt-5">
                                    <label className="label">Kategori</label>
                                    <div className="controls">
                                        <input type="text" className="input" placeholder="Kategori"
                                            value={id_kategori} onChange={(e) => setIdCat(e.target.value)} />
                                    </div>
                                </div>
                                <div className="field mt-5">
                                    <label className="label">Stok</label>
                                    <div className="controls">
                                        <input type="text" className="input" placeholder="Stok"
                                            value={stok} onChange={(e) => setStock(e.target.value)} />
                                    </div>
                                </div>
                                <div className="field mt-5">
                                    <label className="label">Harga</label>
                                    <div className="controls">
                                        <input type="text" className="input" placeholder="Harga Barang"
                                            value={harga} onChange={(e) => setPrice(e.target.value)} />
                                    </div>
                                </div>
                                <div className="field mt-5">
                                    <button className="button is-success is-fullwidth">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    )
}

export default EditPages