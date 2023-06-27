/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";

const Kmeans = () => {
    const [name, setName] = useState('');
    const [token, setToken] = useState('');
    const [expire, setExpire] = useState('');
    const [users, setUsers] = useState([]);
    const navigate = useNavigate();
    const [dataResult, setData] = useState([]);
    const [selling, setSelling] = useState([]);
    const [products, setProduct] = useState([]);

    useEffect(() => {
        refreshToken();
        getUsers();
        getDataResult();
        getSelling();
    }, []);
    const getDataResult = async () => {
        const response = await axios.get('http://localhost:5100/proses_mining_15');
        setData(response.data);
    }
    const getSelling = async () => {
        const response = await axios.get('http://localhost:5100/penjualan');
        const response2 = await axios.get('http://localhost:5100/produk');
        setSelling(response.data);
        setProduct(response2.data);
        
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
        <div className="container mt-5">
            
            <div className="buttons">
                <div id="page-wrapper">
                    <p>&nbsp;</p>
                    <div class="row">
                        <div class="panel-heading">Lihat Data Dengan Total <a href="/Kmeans">15</a> <a href="/Kmeans30">30 </a><a href="/Kmeans50">50</a> <a href="/Kmeans100">100 </a> <a href="/KmeansAll">Semua</a></div>
                        <div class="col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading">
                                    Data Produk
                                </div>

                                <div class="panel-body">
                                    {/* <p><a class="btn btn-sm btn-success" href="produk-tambah.php">
                                        <i class="fa fa-plus-square"> Tambah Produk</i></a></p> */}
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                            <th>ID Produk</th>
                                                <th>Nama Produk</th>
                                                <th>Distance 1</th>
                                                <th>Distance 2</th>
                                                <th>Distance 3</th>
                                                <th>Distance 4</th>
                                                <th>Distance 5</th>
                                                <th>Distance 6</th>
                                                {/* <th>Harga</th> */}
                                            </tr>
                                        </thead>
                                        <tbody>
                                        {dataResult.map((proses_mining) => {
                                             const namaproduk = products.filter(produk => produk.id_produk === proses_mining.id_produk);
                                             const sells  = selling.filter(penjualan => penjualan.id_produk === proses_mining.id_produk);
                                             return( <tr key={proses_mining.id_proses}>
                                                <td>{proses_mining.id_produk}</td>
                                                    <td>{proses_mining.nama}</td>
                                                    {namaproduk.map((produk, i) => (
                                                    <td>{produk.stok} ; {sells.map ((penjualan, i)=>( penjualan.total))}</td>))}
                                                
                                                    <td>{proses_mining.Distance1}</td>
                                                    <td>{proses_mining.Distance2}</td>
                                                    <td>{proses_mining.Distance3}</td>
                                                    <td>{proses_mining.Distance4}</td>
                                                    <td>{proses_mining.Distance5}</td>
                                                    <td>{proses_mining.Distance6}</td>
                                                </tr>
                                             )
                                            })}
                                        </tbody>
                                    </table>
                                    {/* //TODO : Pagination */}

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    )
}

export default Kmeans