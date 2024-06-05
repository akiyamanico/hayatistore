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
        const response = await axios.get('https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/clusters_new');
        setcustomer(response.data.labeledClusters);
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
    const handleClick = async () => {
        fetch('https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/clusters_new')
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
            await axios.get(`https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/adddiscountcust/${id}`);    
        }
        catch (error) {
            console.error(error);
        }
    }
    return (
        <div className="container mx-auto p-8">
          <h1 className="text-2xl font-semibold mb-4">Cluster Data Pelanggan</h1>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            {cluster.map(cluster => (
              <div key={cluster.label} className="border p-4 mb-4">
                <h2 className="text-xl font-semibold mb-2">Cluster {cluster.label}</h2>
                <table className="table-auto w-full">
                  <thead>
                    <tr>
                      <th className="px-4 py-2">Nama</th>
                      <th className="px-4 py-2">Total Belanja</th>
                      <th className="px-4 py-2">Total Pembayaran</th>
                      {cluster.label === 1 && <th className="px-4 py-2">Aksi</th>}
                    </tr>
                  </thead>
                  <tbody>
                    {cluster.customers.map(customer => (
                      <tr key={customer.nama}>
                        <td className="border px-4 py-2">{customer.nama}</td>
                        <td className="border px-4 py-2">{customer.total}</td>
                        <td className="border px-4 py-2">Rp.{customer.totalpembayaran}</td>
                        {cluster.label === 1 && (
                          <td className="border px-4 py-2">
                            <button onClick={() => addDiscount(customer.id)} className="button is-small is-danger">Masukan Ke Diskon</button>
                          </td>
                        )}
                      </tr>
                    ))}
                  </tbody>
                </table>
              </div>
            ))}
          </div>
          <div className="mt-8">
      <h2 className="text-xl font-semibold mb-2">Centroids</h2>
      <table className="table-auto">
        <thead>
          <tr>
            <th className="px-4 py-2">Centroid Values</th>
          </tr>
        </thead>
        <tbody>
          {cluster.map(cluster => (
            <tr>
              <td className="border px-4 py-2">{cluster.centroids.join(', ')}</td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
        </div>
      );      
}

export default CustomerKmeans