/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";
import ReactPaginate from "react-paginate";

const CustomerKmeans = () => {
    const [name, setName] = useState('');
    const [token, setToken] = useState('');
    const [expire, setExpire] = useState('');
    const [users, setUsers] = useState([]);
    const navigate = useNavigate();
    const [selling, setSelling] = useState([]);
    const [customer_cluster, setcustomerCluster] = useState([]);
    const [customer_cluster_percentage, setcustomerClusterPercentage] = useState([]);

    useEffect(() => {
        refreshToken();
        getUsers();
        getCluster();
        getClusterPercentage();
        handleClick();
    }, []);
    const getCluster = async () => {
        const response = await axios.get('https://hayati.fly.dev/customerkmeans');
        setcustomerCluster(response.data);
    }
    const getClusterPercentage = async () => {
        const response = await axios.get('https://hayati.fly.dev/customerkmeanspercentage');
        setcustomerClusterPercentage(response.data);
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
    const handleClick = async () => {
        fetch('https://hayati.fly.dev/clusters_new')
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Failed to load data');
                }
                return response.json();
            })
            .catch((error) => {
                console.error(error);
                // Handle error if needed
            });
    };
    return (
        <div className="container mt-5">
            <div className="buttons">
                <div id="page-wrapper">
                    <div class="row col-lg-12 w-full">
                        <div class="panel panel-primary my-12">
                            <div class="panel-heading text-center flex justify-center px-4">
                                <p class="text-2xl font-bold">Data Customer</p>
                            </div>
                            <div class="panel-body w-full my-8">
                                <table class="table table-striped table-bordered table-hover w-full" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>Nama Customer</th>
                                            <th>Total</th>
                                            <th>percentage Kmeans</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {customer_cluster.map((customer_cluster, index) => (
                                            <tr key={index}>
                                                <td>{customer_cluster.customer_nama}</td>
                                                <td>{customer_cluster.total}</td>
                                                {customer_cluster_percentage.map((percentage, i) => (
                                                    i === index && <td key={i}>{percentage.percentage}</td>
                                                ))}
                                            </tr>
                                        ))}
                                    </tbody>
                                    <table class="table table-striped table-bordered table-hover w-full" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Nama Customer</th>
                                                <th>Distance</th>
                                                <th>Aksi</th>
                                                </tr>
                                        </thead>
                                        <tbody>
  {customer_cluster.map((customer_cluster, index) => (
    <tr key={index}>
      <td>{customer_cluster.customer_nama}</td>
      <td>{customer_cluster.distance}</td>
      {customer_cluster_percentage.map((percentage, i) => {
        if (i === index && percentage.percentage > 70) {
            console.log(customer_cluster);
          return (
            <React.Fragment key={i}>
              <td>{percentage.percentage}</td>
              <td>
                <button onClick={() => addDiscount(customer_cluster.id)} className="button is-small is-danger">
                  Masukan Ke Cust Diskon
                </button>
              </td>
            </React.Fragment>
          );
        } else {
          return null;
        }
      })}
    </tr>
  ))}
</tbody>

                                        
                                    </table>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}

export default CustomerKmeans