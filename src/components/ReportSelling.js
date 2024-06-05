/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";
import ReactPaginate from "react-paginate";

const ReportSelling = () => {
    const [name, setName] = useState('');
    const [token, setToken] = useState('');
    const [expire, setExpire] = useState('');
    const [users, setUsers] = useState([]);
    const navigate = useNavigate();
    const [selling, setSelling] = useState([]);
    const [products, setProduct] = useState([]);

    useEffect(() => {
        refreshToken();
        getUsers();
        getSelling();
    }, []);
    const getSelling = async () => {
        const response = await axios.get('https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/penjualan');
        const response2 = await axios.get('https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/produk');
        setSelling(response.data);
        setProduct(response2.data);
        
    }
    const deleteSelling = async (id_penjualan) => {
        await axios.delete(`https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/penjualan/${id_penjualan}`);
        getSelling();
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


    return (
        <div className="container mt-5">
            <div className="buttons">
                <div id="page-wrapper">
                    <div class="row col-lg-12 w-full">
                            <div class="panel panel-primary my-12">
                                <div class="panel-heading text-center flex align-middle justify-center px-4">
                                    <p class="text-2xl font-bold">Data Penjualan</p>
                                </div>
                                <div class="panel-body w-full my-8">
                                    <table class="table table-striped table-bordered table-hover w-full" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Nomor Penjualan </th>
                                                <th>ID Produk</th>
                                                <th>Nama Produk</th>
                                                <th>Januari</th>
                                                <th>Februari</th>
                                                <th>Maret</th>
                                                <th>April</th>
                                                <th>Mei</th>
                                                <th>Juni</th>
                                                <th>Juli</th>
                                                <th>Agustus</th>
                                                <th>September</th>
                                                <th>Oktober</th>
                                                <th>November</th>
                                                <th>Desember</th>
                                                <th>Total</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                          
                                            {selling.map((penjualan) => {
                                                const namaproduk = products.filter(produk => produk.id_produk === penjualan.id_produk);
                                                return(
                                                    <tr key={penjualan.id_penjualan}>
                                                    <td>{penjualan.id_penjualan}</td>
                                                    <td>{penjualan.id_produk}</td>
                                                    {namaproduk.map((produk, i)=> (
                                                         <td>{produk.nama}</td>
                                                    ))}
                                                    <td>{penjualan.JAN}</td>
                                                    <td>{penjualan.FEB}</td>
                                                    <td>{penjualan.MAR}</td>
                                                    <td>{penjualan.APR}</td>
                                                    <td>{penjualan.MEI}</td>
                                                    <td>{penjualan.JUN}</td>
                                                    <td>{penjualan.JUL}</td>
                                                    <td>{penjualan.AGUST}</td>
                                                    <td>{penjualan.SEPT}</td>
                                                    <td>{penjualan.OKT}</td>
                                                    <td>{penjualan.NOV}</td>
                                                    <td>{penjualan.DES}</td>
                                                    <td>{penjualan.total}</td>
                                                    {namaproduk.map((produk, i)=> (
                                                         <td><Link to={`/EditDataPenjualan/${produk.id_produk}`} className="button is-small is-info">Edit</Link></td>
                                                    ))}
                                                   
                                                </tr>
                                                )
                                            })}
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    )
}

export default ReportSelling