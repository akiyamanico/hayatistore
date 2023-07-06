import React, { useState, useEffect } from 'react';
import axios from 'axios';
import jwt_decode from 'jwt-decode';
import { useNavigate } from 'react-router-dom';

const DiskonCust = () => {
  const [name, setName] = useState('');
  const [token, setToken] = useState('');
  const [expire, setExpire] = useState('');
  const [users, setUsers] = useState([]);
  const [diskon, setDisc] = useState([]);
  const navigate = useNavigate();

  useEffect(() => {
    refreshToken();
    getUsers();
    getCustDisc();
  }, []);

  const getCustDisc = async () => {
    try {
      const response = await axios.get('https://hayati.fly.dev/get-discount-cust');
        setDisc(response.data);
    } catch (error) {
      console.error(error);
    }
  };

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
  };

  const axiosJWT = axios.create();

  axiosJWT.interceptors.request.use(async (config) => {
    const currentDate = new Date();
    if (expire * 1000 < currentDate.getTime()) {
      try {
        const response = await axios.get('https://sequelizehayati.fly.dev/token');
        config.headers.Authorization = `Bearer ${response.data.accessToken}`;
        setToken(response.data.accessToken);
        const decoded = jwt_decode(response.data.accessToken);
        setName(decoded.name);
        setExpire(decoded.exp);
      } catch (error) {
        console.error(error);
      }
    }
    return config;
  }, (error) => {
    return Promise.reject(error);
  });

  const getUsers = async () => {
    try {
      const response = await axiosJWT.get('https://sequelizehayati.fly.dev/users', {
        headers: {
          Authorization: `Bearer ${token}`,
        },
      });
      setUsers(response.data);
    } catch (error) {
      console.error(error);
    }
  };



  return (
    <div className="container mt-5">
      <div className="buttons">
        <div id="page-wrapper">
          <div className="row col-lg-12 w-full">
            <div className="panel panel-primary my-12">
              <div className="panel-heading flex align-middle justify-between px-4">
                <p className="text-xl font-bold">Data Produk Diskon</p>
            </div>
            <div className="panel-body w-full my-8">
              <form>
                <table className="table table-bordered table-hover" id="dataTables-example">
                  <thead>
                    <tr>
                      <th>ID Cust</th>
                      <th>Nama Customer</th>
                    </tr>
                  </thead>
                  <tbody>
                    {diskon.map((customerwithdiscount) => (
                      <tr key={customerwithdiscount.id}>
                        <td>{customerwithdiscount.id}</td>
                        <td>{customerwithdiscount.nama}</td>

                      </tr>
                    ))}
                  </tbody>
                </table>
              </form>
              {/* TODO: Pagination */}
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
  );
};

export default DiskonCust;
