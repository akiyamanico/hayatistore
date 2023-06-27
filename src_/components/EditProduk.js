/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";
import ReactPaginate from "react-paginate";

const EditProduk = () => {
    const [name, setName] = useState('');
    const [token, setToken] = useState('');
    const [expire, setExpire] = useState('');
    const [users, setUsers] = useState([]);
    const navigate = useNavigate();
    const [selling, setSelling] = useState([]);
    const [products, setProduct] = useState([]);
    const [deleteproduct, setDelete] = useState([]);

    useEffect(() => {
        refreshToken();
        getUsers();
        getSelling();
        getProducts();
    }, []);
    const getSelling = async () => {
        const response = await axios.get('http://localhost:5100/penjualan');
        const response2 = await axios.get('http://localhost:5100/produk');
        setSelling(response.data);
        setProduct(response2.data);
        
    }
    const getProducts = async () => {
        const response = await axios.get('http://localhost:5100/produk');
        setProduct(response.data);
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

    const deleteProduct = async (id_produk) => {
        const response = await axios.delete(`http://localhost:5100/deleteproduct/${id_produk}`);
        setDelete(response.data);
    }


    return (
        <div className="container mt-5">
            <div className="buttons">
                <div id="page-wrapper">
                    <p>&nbsp;</p>
                    <div class="row">
                        <div class="col-lg-24">
                            <div class="panel panel-primary">
                                <div class="panel-heading text-center">
                                    Data Penjualan
                                </div>
        
                                <div class="panel-body">
                                    <table width="85%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>ID Produk</th>
                                                <th>Nama Produk</th>
                                                <th>Kategori Produk</th>
                                                <th>Harga Produk</th>
                                                <th>Stok Produk</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        {products.map((produk, index) => (
                                            
  
                                                <tr key={produk.id_produk}>
                                                    <td>{produk.id_produk}</td>
                                                    <td>{produk.nama}</td>
                                                    <td>{produk.id_kategori}</td>
                                                    <td>{produk.harga}</td>
                                                    <td>{produk.stok}</td>
                                                    <td><Link to={`/EditPage/${produk.id_produk}`} className="button is-small is-info">Edit</Link> / <button onClick={ () => deleteProduct(produk.id_produk) } className="button is-small is-danger">Delete</button></td>  {/*  Edit Soon */}
                                                </tr>
                                                
                                            ))}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    )
}

export default EditProduk