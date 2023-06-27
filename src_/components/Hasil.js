/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect, Component } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";
import { Progress } from "@material-tailwind/react";

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
        getProgress();
        getResultLaku();
        getResultKurangLaku();
    }, []);
    const getProducts = async () => {
        const response = await axios.get('http://localhost:5100/produk');
        setProduct(response.data);
    }
    const deleteProduct = async (id_produk) => {
        await axios.delete(`http://localhost:5000/produk/${id_produk}`);
        getProducts();
    }
    //create componentdidmout for apijson.php
    const [progressData, setProgress] = useState([]);
    const getProgress = async () => {
        const response = await axios.get('http://localhost/api/apijson.php');
        setProgress(response.data);
    }
    const [resultDataLaku, setResultLaku] = useState([]);
    const getResultLaku = async () => {
        const response = await axios.get('http://localhost/api/apijsonhasil.php');
        setResultLaku(response.data);
    }
    const [resultDataKurangLaku, setResultKurangLaku] = useState([]);
    const getResultKurangLaku = async () => {
        const response = await axios.get('http://localhost/api/apijsonhasilkurang.php');
        setResultKurangLaku(response.data);
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

    //     <div class = "place-self-center">
    //     <div class="flex justify-center relative ">
            
    //     <table class="rounded-md content-center">
    //     <thead>
    //       <tr>
    //         <th class = "border border-slate-600">Perbedaan Produk Yang Diminati Dalam Bentuk Persen</th>
    //       </tr>
    //     </thead>
    //     <tbody>
    //         <td class = "border border-slate-700"><Progress value={progressData.c1} /> Yang Diminati</td>
    //         <td class = "border border-slate-700"><Progress value={progressData.c2} /> Yang Kurang Diminati</td>
    //     </tbody>
    //     <thead>
    //         <tr>
    //             <th>Yang Diminati</th>
    //             <th>Harga</th>
    //         </tr>
    //     </thead>
    //     <tbody>
    //     {resultDataLaku.map((produk, index) => (
    //             <tr key={produk.id}>
    //          <td>{produk.nama}</td>
    //          <td>{produk.harga}</td>
    //          </tr>
    //         ))}
    //     </tbody>
    //     <thead>
    //         <tr>
    //             <th>Yang Kurang Diminati</th>
    //             <th>Harga</th>
    //             </tr>
    //     </thead>
    //     <tbody>
    //     {resultDataKurangLaku.map((produkKurang, index) => (
    //         <tr key={produkKurang.id}>
    //         <td>{produkKurang.nama}</td>
    //         <td>{produkKurang.harga}</td>
    //         </tr>
    //         ))}
    //     </tbody>
    //   </table>
    //   </div>
    //   </div>

    <div className="container mt-5 place-content-center">
            
            <div className="buttons">
                <div id="page-wrapper">
                    <p>&nbsp;</p>
                    <div class="row">
                        <div class="panel-heading text-center">Perbedaan Produk Terlaris Dalam Bentuk Angka <p>

                        </p>
                        <br></br>
                        <td class = "border border-slate-700 text-center"><Progress value={progressData.c1} /> Yang Diminati {progressData.c1} %</td><br></br>
                    <td class = "border border-slate-700 text-center"><Progress value={progressData.c2} /> Yang Kurang Diminati {progressData.c2} %</td>
                        </div>
                        <div class="col-lg-12">
                            <div class="panel panel-primary text-center">
                                <div class="panel-heading text-center">
                                   Data Produk Yang Paling Diminati
                                </div>

                                <div class="panel-body">
                                    {/* <p><a class="btn btn-sm btn-success" href="produk-tambah.php">
                                        <i class="fa fa-plus-square"> Tambah Produk</i></a></p> */}
                                    <table width="100%" class="table table-striped table-bordered table-hover text-center" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <tr>
                                                    <th>Nama Produk</th>
                                                    <th>Harga</th>
                                                </tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {resultDataLaku.map((produk, index) => (
                                                <tr key={produk.id}>
                                                    <td>{produk.nama}</td>
                                                    <td>{produk.harga}</td>
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading text-center">
                                   Data Produk Yang Kurang Diminati
                                </div>

                                <div class="panel-body">
                                    {/* <p><a class="btn btn-sm btn-success" href="produk-tambah.php">
                                        <i class="fa fa-plus-square"> Tambah Produk</i></a></p> */}
                                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <tr>
                                                    <th>Nama Produk</th>
                                                    <th>Harga</th>
                                                </tr>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        {resultDataKurangLaku.map((produkKurang, index) => (
                                                <tr key={produkKurang.id}>
                                                    <td>{produkKurang.nama}</td>
                                                    <td>{produkKurang.harga}</td>
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

export default Dashboard