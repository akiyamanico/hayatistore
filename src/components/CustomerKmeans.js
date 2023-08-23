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
    const [cluster, setcustomer] = useState([]);

    useEffect(() => {
        refreshToken();
        getUsers();
        getCluster();
        handleClick();
    }, []);
    const getCluster = async () => {
        const response = await axios.get('https://hayati.fly.dev/clusters_new');
        setcustomer(response.data.labeledClusters);
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
    const addDiscount = async (id) => {
        try{
            await axios.get(`https://hayati.fly.dev/adddiscountcust/${id}`);    
        }
        catch (error) {
            console.error(error);
        }
    }
    <div className="container mx-auto p-8">
  <h1 className="text-2xl font-semibold mb-4">Cluster Data Pelanggan</h1>
  <table className="table">
    <thead>
      <tr>
        <th>Cluster Label</th>
        <th>Nama Pelanggan</th>
        <th>Total Belanja</th>
        <th>Total Pembayaran</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {cluster.map(cluster => (
        <React.Fragment key={cluster.label}>
          {cluster.customers.map(customer => (
            <tr key={customer.nama}>
              <td>Cluster {cluster.label}</td>
              <td>{customer.nama}</td>
              <td>{customer.total}</td>
              <td>Rp.{customer.totalpembayaran}</td>
              <td>
                <button
                  onClick={() => addDiscount(customer.id)}
                  className="button is-small is-danger"
                >
                  Masukan Ke Diskon
                </button>
              </td>
            </tr>
          ))}
        </React.Fragment>
      ))}
    </tbody>
  </table>
</div>

}

export default CustomerKmeans