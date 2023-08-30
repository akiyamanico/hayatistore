/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect, Component } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";

const Dashboard = () => {
    const [name, setName] = useState('');
    const [token, setToken] = useState('');
    const [expire, setExpire] = useState('');
    const [users, setUsers] = useState([]);
    const navigate = useNavigate();
    const [products, setProduct] = useState([]);

    useEffect(() => {
        refreshToken();
        getUsers();
        getProducts();
    }, []);
    const getProducts = async () => {
        const response = await axios.get('https://hayati.fly.dev/produk');
        setProduct(response.data);
    }
    const deleteProduct = async (id) => {
        try {
          await Promise.all([
            axios.get(`https://hayati.fly.dev/deleteproduk/${id}`),
            axios.get(`https://hayati.fly.dev/deletemining/${id}`),
            axios.get(`https://hayati.fly.dev/deletedesc/${id}`),
            axios.get(`https://hayati.fly.dev/deletepenjualan/${id}`),
          ]);
          getProducts();
        } catch (error) {
          console.error(error);
        }
        getProducts();
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
        <div className="container mt-5">
            <div className="buttons">
                <div id="page-wrapper">
                    <div class="row col-lg-12 w-full">
                        <div class="panel panel-primary my-12">
                            <div class="panel-heading flex align-middle justify-between px-4">
                                    <p class="text-xl font-bold">Data Produk</p>
                                    <button type="button" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"><a href="https://skeptic-electrician.000webhostapp.com/proses_mining.php">Lakukan Clustering K-Means</a></button>
                                </div>
                                <div class="panel-body w-full my-8">
                                    <table width="100%" class="table table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama</th>
                                                <th>Kategori</th>
                                                <th>Stok</th>
                                                <th>Harga</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {products.map((produk, index) => (
                                                <tr key={produk.id}>
                                                    <td>{index + 1}</td>
                                                    <td>{produk.nama}</td>
                                                    <td>{produk.id_kategori}</td>
                                                    <td>{produk.stok}</td>
                                                    <td>{produk.harga}</td>
                                                    <td><Link to={`/EditData/${produk.id_produk}`} className="button is-small is-info">Edit / </Link>
                                                    <button onClick={() => deleteProduct(produk.id_produk)} className="button is-small is-danger">Delete</button>
                                                    </td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>
                                    {/* //TODO : Pagination */}

                                </div>
                            </div>
                    </div>


                </div>
            </div>
        </div>
    )
}

export default Dashboard