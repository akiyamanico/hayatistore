/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";
import ReactPaginate from "react-paginate";

const ReportCustomer = () => {
    const [name, setName] = useState('');
    const [token, setToken] = useState('');
    const [expire, setExpire] = useState('');
    const [users, setUsers] = useState([]);
    const navigate = useNavigate();
    const [selling, setSelling] = useState([]);
    const [customerhistory, setCustomerHistory] = useState([]);

    useEffect(() => {
        refreshToken();
        getUsers();
        getCust();
    }, []);
    const getCust = async () => {
        const response = await axios.get('https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/customerhistory');
        setCustomerHistory(response.data);
    }
    const refreshToken = async () => {
        try {
            const response = await axios.get('https://kmeans-crm-backend-sequelize-c5xdhud6vq-et.a.run.app/token');
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
            const response = await axios.get('https://kmeans-crm-backend-sequelize-c5xdhud6vq-et.a.run.app/token');
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
        const response = await axiosJWT.get('https://kmeans-crm-backend-sequelize-c5xdhud6vq-et.a.run.app/users', {
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
                                <p class="text-2xl font-bold">Data Customer</p>
                            </div>
                            <div class="panel-body w-full my-8">
                                <table class="table table-striped table-bordered table-hover w-full" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nama Customer</th>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {customerhistory.map((customerhistory, index) => (
                                            <tr key={index}>
                                                <td>{customerhistory.nama}</td>
                                                <td>{customerhistory.JAN}</td>
                                                <td>{customerhistory.FEB}</td>
                                                <td>{customerhistory.MAR}</td>
                                                <td>{customerhistory.APR}</td>
                                                <td>{customerhistory.MEI}</td>
                                                <td>{customerhistory.JUN}</td>
                                                <td>{customerhistory.JUL}</td>
                                                <td>{customerhistory.AGUST}</td>
                                                <td>{customerhistory.SEPT}</td>
                                                <td>{customerhistory.OKT}</td>
                                                <td>{customerhistory.NOV}</td>
                                                <td>{customerhistory.DES}</td>
                                                <td>{customerhistory.total}</td>
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
    )
}

export default ReportCustomer