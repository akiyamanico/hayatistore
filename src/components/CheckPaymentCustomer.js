/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect, Component } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";

const CheckPaymentCustomer = () => {
    const [name, setName] = useState('');
    const [token, setToken] = useState('');
    const [expire, setExpire] = useState('');
    const [users, setUsers] = useState([]);
    const navigate = useNavigate();
    const [dataPayment, setDataPayment] = useState([]);

    useEffect(() => {
        refreshToken();
        getUsers();
        getCustData();
    }, []);
    const getCustData = async () => {
        axios
        .get('https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/cartcustomer')
        .then((response) => {
          // Convert the picture filenames to JPEG URLs
          const updatedProducts = response.data.map((cartcustomer) => {
    const pictureUrl = `/uploads/${cartcustomer.buktipembayaran}`;
    const pictureUrlJPEG = convertToJPEG(pictureUrl);
    console.log('pictureUrl:', pictureUrl);
    console.log('pictureUrlJPEG:', pictureUrlJPEG);
    return { ...cartcustomer, pictureUrlJPEG };
  });
          setDataPayment(updatedProducts);
        })
        .catch((error) => {
          console.error(error);
        });
    }
    const urljpg = 'https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/uploads/';
    const convertToJPEG = (url) => {
      const extension = url.slice(-3); // Get the file extension
      if (extension === 'jpg' || extension === 'jpeg') {
        return url; // Already a JPEG, return the same URL
      } else {
        // Convert to JPEG by replacing the file extension
        return url.replace(/\.[^.]+$/, '.jpeg');
      }
    };

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
    const confirmData = async (id) => {
        axios.get(`https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/updatestatuscustomer/${id}`)
        getCustData();
    }


    return (
        <div className="container mt-5">
            <div className="buttons">
                <div id="page-wrapper">
                    <div class="row col-lg-12 w-full">
                        <div class="panel panel-primary my-12">
                            <div class="panel-heading flex align-middle justify-between px-4">
                                    <p class="text-xl font-bold">Data Produk</p>
                                </div>
                                <div class="panel-body w-full my-8">
                                    <table width="100%" class="table table-bordered table-hover" id="dataTables-example">
                                        <thead>
                                            <tr>
                                                <th>Nama</th>
                                                <th>Alamat</th>
                                                <th>Nomor Telpon</th>
                                                <th>List Barang</th>
                                                <th>Jumlah</th>
                                                <th>Total Bayar</th>
                                                <th>Status</th>
                                                <th>Bukti Pembayaran</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {dataPayment.map((cartcustomer) => (
                                                <tr>
                                                    <td>{cartcustomer.nama}</td>
                                                    <td>{cartcustomer.alamat}</td>
                                                    <td>{cartcustomer.nomortelp}</td>
                                                    <td>{cartcustomer.produk}</td>
                                                    <td>{cartcustomer.quantity}</td>
                                                    <td>{cartcustomer.totalbayar}</td>
                                                    <td>{cartcustomer.status}</td>
                                                    <td>
                                                    <img
                src={`${urljpg}${cartcustomer.buktipembayaran}`}
                alt="product-image"
                className="w-full rounded-lg sm:w-40"
              />
                                                    </td>
                                                    <button onClick={() => confirmData(cartcustomer.idcustomer)} className="button is-small is-danger">Konfirmasi</button>
                                                </tr>
                                            ))}
                                            
                                        </tbody>
                                    </table>
                                    {/* //TODO : Pagination */}

                                </div>
                            </div>
                    </div>


                </div>
            </div>
        </div>
    )
}

export default CheckPaymentCustomer