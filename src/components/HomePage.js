/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";


const HomePage = () => {
    const [name, setName] = useState('');
    const [token, setToken] = useState('');
    const [expire, setExpire] = useState('');
    const [users, setUsers] = useState([]);
    const navigate = useNavigate();
    const [products, setProduct] = useState([]);
    const [result, setResult] = useState("");
       
    useEffect(() => {
        refreshToken();
        getUsers();
    }, []);

  

    
    const refreshToken = async () => {
        try {
            const response = await axios.get('https://sequelizehayati.fly.dev/token');
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
    const [Penjualan, setPenjualan] = useState([]);

  useEffect(() => {
    axios.get("http://localhost:5100/penjualan").then((response) => {
      setPenjualan(response.data);
    });
  }, []);

  const renderTableData = () => {
    return Penjualan?.map((val) => (
    <tr class="">
      <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
        <td>{val.nama}</td>
      </th>
      <td class="py-4 px-6">
                    {val.JAN}
      </td>
      <td class="py-4 px-6">
                    {val.FEB}
      </td>
      <td class="py-4 px-6">
                    {val.MAR}
      </td>
      <td class="py-4 px-6">
                    {val.APR}
      </td>
      <td class="py-4 px-6">
                    {val.MEI}
      </td>
      <td class="py-4 px-6">
                    {val.JUN}
      </td>
      <td class="py-4 px-6">
                    {val.JUL}
      </td>
      <td class="py-4 px-6">
                    {val.AGUST}
      </td>
      <td class="py-4 px-6">
                    {val.SEPT}
      </td>
      <td class="py-4 px-6">
                    {val.OKT}
      </td>
      <td class="py-4 px-6">
                    {val.NOV}
      </td>
      <td class="py-4 px-6">
                    {val.DES}
      </td>
      <td class="py-4 px-6">
                    {val.total}
      </td>
      </tr>
    ));
  };


    return (
        <div class="my-4 w-full mx-auto flex align-middle justify-center overflow-x-auto relative">
    <table class="text-sm text-left text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="py-3 px-6">
                    Nama Barang
                </th>
                <th scope="col" class="py-3 px-6">
                    Jan
                </th>
                <th scope="col" class="py-3 px-6">
                    Feb
                </th>
                <th scope="col" class="py-3 px-6">
                    Mar
                </th>
                <th scope="col" class="py-3 px-6">
                    Apr
                </th>
                <th scope="col" class="py-3 px-6">
                    Mei
                </th>
                <th scope="col" class="py-3 px-6">
                    Jun
                </th>
                <th scope="col" class="py-3 px-6">
                    Jul
                </th>
                <th scope="col" class="py-3 px-6">
                    Aug
                </th>
                <th scope="col" class="py-3 px-6">
                    Sep
                </th>
                <th scope="col" class="py-3 px-6">
                    Okt
                </th>
                <th scope="col" class="py-3 px-6">
                    Nov
                </th>
                <th scope="col" class="py-3 px-6">
                    Des
                </th>
                <th scope="col" class="py-3 px-6">
                    Total
                </th>
                <th scope="col" class="py-3 px-6">
                    Aksi
                </th>
            </tr>
        </thead>
        <tbody>
           {renderTableData()}
        </tbody>
    </table>
</div>
    )
}

export default HomePage