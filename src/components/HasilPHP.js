/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect, Component } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";
import { Progress } from "@material-tailwind/react";


const HasilPHP = () => {
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
        const response = await axios.get('https://hayati.fly.dev/produk');
        setProduct(response.data);
    }
    const deleteProduct = async (id_produk) => {
        await axios.delete(`https://sequelizehayati.fly.dev/produk/${id_produk}`);
        getProducts();
    }
    //create componentdidmout for apijson.php
    const [progressData, setProgress] = useState([]);
    const getProgress = async () => {
        const response = await axios.get('http://localhost:8000/apijson.php', {
            withCredentials: false
        });
        setProgress(response.data);
    }
    const [resultDataLaku, setResultLaku] = useState([]);
    const getResultLaku = async () => {
        const response = await axios.get('http://localhost:8000/apijsonhasil.php', {
            withCredentials: false
        });
        setResultLaku(response.data);
    }
    const [resultDataKurangLaku, setResultKurangLaku] = useState([]);
    const getResultKurangLaku = async () => {
        const response = await axios.get('http://localhost:8000/apijsonhasilkurang.php', {
            withCredentials: false
        });
        setResultKurangLaku(response.data);
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
    const Logout = async () => {
        try {
            await axios.delete('https://sequelizehayati.fly.dev/logout');
            navigate('/');
        } catch (error) {
            console.log(error);
        }
    }


    return (
        <div className="container mt-5 ">
            <div className="buttons">
                <div id="page-wrapper">
                    <p>&nbsp;</p>
                    <div class="row">
                        <div class="panel-heading my-4">
                            <p class="flex align-middle justify-center font-bold text-2xl">Perbedaan Produk Diminati Dalam Bentuk Angka</p>
                            <div class="my-16 px-8 flex align-middle justify-evenly">
                                <td class="border border-slate-700 text-center"><Progress value={progressData.c1} /> Yang Diminati {progressData.c1} %</td>
                                <td class="border border-slate-700 text-center"><Progress value={progressData.c2} /> Yang Kurang Diminati {progressData.c2} %</td>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="panel panel-primary my-8">
                                <div class="panel-heading">
                                    <p class="flex justify-evenly font-bold text-2xl">Data Produk Yang Paling Diminati</p>
                                </div>
                                <div class="panel-body my-8">
                                    <table width="65%" class="table align-middle justify-evenly table-striped table-bordered table-hover">
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
                                                </tr>
                                            ))}
                                        </tbody>
                                    </table>

                                </div>
                            </div>
                            <div class="panel panel-primary">
                                <div class="panel-heading text-center">
                                    <p class="flex align-middle justify-center font-bold text-2xl">Data Produk Yang Kurang Diminati</p>
                                </div>

                                <div class="panel-body my-8 mx-auto w-full flex align-middle justify-center">
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

export default HasilPHP