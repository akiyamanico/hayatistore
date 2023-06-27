/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";
import { Combobox } from '@headlessui/react'

const TambahData = () => {
    const [id_produk, setIdProduct] = useState('');
    const [nama, setName] = useState('');
    const [desc, setDesc] = useState('');
    const [id_kategori, setIdCat] = useState('');
    const [stok, setStock] = useState('');
    const [harga, setPrice] = useState('');
    const [token, setToken] = useState('');
    const [expire, setExpire] = useState('');
    const [users, setUsers] = useState([]);
    const navigate = useNavigate();
    const [msg, setMsg] = useState('');
    const [picture, setPicture] = useState(null);

    useEffect(() => {
        refreshToken();
        getUsers();

    }, []);

    const InsertProduct = async (e) => {
        e.preventDefault();
        try {
            const formData = new FormData();
            formData.append('id_produk', id_produk);
            formData.append('nama', nama);
            formData.append('id_kategori', id_kategori);
            formData.append('stok', stok);
            formData.append('harga', harga);
            formData.append('picture', picture);
            formData.append('desc', desc);
            await axios.post('http://localhost:5100/produk_insert_picture', formData);
            await axios.post('http://localhost:5100/mining_insert', {
                id_produk: id_produk
            });
            await axios.post('http://localhost:5100/penjualan_insert', {
                id_produk: id_produk
            });
            await axios.post('http://localhost:5100/desc_insert', {
                id_produk: id_produk,
                desc: desc
            });
            navigate('/Dashboard');
        } catch (error) {
            if (error.response) {
                setMsg(error.response.data.msg);
            }
        }
    }

    const refreshToken = async () => {
        try {
            const response = await axios.get('https://sequelizehayati.fly.dev/token');
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
            const response = await axios.get('https://sequelizehayati.fly.dev/token');
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
        const response = await axiosJWT.get('https://sequelizehayati.fly.dev/users', {
            headers: {
                Authorization: `Bearer ${token}`
            }
        });
        setUsers(response.data);
    }
    const Logout = async () => {
        try {
            await axios.delete('https://sequelizehayati.fly.dev/logout');
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
                            <form onSubmit={InsertProduct} className="box">
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
                                    <label className="label">Deskripsi Barang</label>
                                    <div className="controls">
                                        <input type="text" className="input" placeholder="Deskripsi barang"
                                            value={desc} onChange={(e) => setDesc(e.target.value)} />
                                    </div>
                                </div>
                                <div className="field mt-5">
                                    <label className="label">Gambar</label>
                                    <div className="controls">
                                        <input type="file"
                                           class="form-control-file" name="picture" onChange={(e) => setPicture(e.target.files[0])} />
                                    </div>
                                </div>
                                <div className="field mt-5">
                                    <button className="button is-success is-fullwidth">Tambah Data</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    )
}

export default TambahData