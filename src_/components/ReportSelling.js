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
        const response = await axios.get('http://localhost:5100/penjualan');
        const response2 = await axios.get('http://localhost:5100/produk');
        setSelling(response.data);
        setProduct(response2.data);
        
    }
    const deleteSelling = async (id_penjualan) => {
        await axios.delete(`http://localhost:5100/penjualan/${id_penjualan}`);
        getSelling();
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

    //create row editable after pressing button edit
    const [edit, setEdit] = useState(false);
    const [id_penjualan, setIdPenjualan] = useState('');
    const [id_produk, setIdProduk] = useState('');
    const [JAN, setJan] = useState('');
    const [FEB, setFeb] = useState('');
    const [MAR, setMar] = useState('');
    const [APR, setApr] = useState('');
    const [MEI, setMei] = useState('');
    const [JUN, setJun] = useState('');
    const [JUL, setJul] = useState('');
    const [AGU, setAgu] = useState('');
    const [SEP, setSep] = useState('');
    const [OKT, setOkt] = useState('');
    const [NOV, setNov] = useState('');
    const [DES, setDes] = useState('');
    const [TOTAL, setTotal] = useState('');

    const editSelling = (id_penjualan, id_produk, JAN, FEB, MAR, APR, MEI, JUN, JUL, AGU, SEP, OKT, NOV, DES, TOTAL) => {
        setEdit(true);
        setIdPenjualan(id_penjualan);
        setIdProduk(id_produk);
        setJan(JAN);
        setFeb(FEB);
        setMar(MAR);
        setApr(APR);
        setMei(MEI);
        setJun(JUN);
        setJul(JUL);
        setAgu(AGU);
        setSep(SEP);
        setOkt(OKT);
        setNov(NOV);
        setDes(DES);
        setTotal(TOTAL);
    }

    const [inEditMode, setInEditMode] = useState({
        status: false,
        rowKey: null
    });

    const [unitPrice, setUnitPrice] = useState(null);

    /**
     *
     * @param id - The id of the product
     * @param currentUnitPrice - The current unit price of the product
     */
    const onEdit = ({id, currentUnitPrice}) => {
        setInEditMode({
            status: true,
            rowKey: id
        })
        setUnitPrice(currentUnitPrice);
    }

    /**
     *
     * @param id
     * @param newUnitPrice
     */
    const updateInventory = ({id, newUnitPrice}) => {
        fetch(`/${id}`, {
            method: "PATCH",
            body: JSON.stringify({
                unit_price: newUnitPrice
            }),
            headers: {
                "Content-type": "application/json; charset=UTF-8"
            }
        })
            .then(response => response.json())
            .then(json => {
                // reset inEditMode and unit price state values
                onCancel();

                // fetch the updated data
                // fetchInventory();
            })
    }

    /**
     *
     * @param id -The id of the product
     * @param newUnitPrice - The new unit price of the product
     */
    const onSave = ({id, newUnitPrice}) => {
        updateInventory({id, newUnitPrice});
    }

    const onCancel = () => {
        // reset the inEditMode state value
        setInEditMode({
            status: false,
            rowKey: null
        })
        // reset the unit price state value
        setUnitPrice(null);
    }


    const updateSelling = async (id_penjualan) => {
        await axios.put(`http://localhost:5100/penjualan/${id_penjualan}`, {
            id_produk, JAN, FEB, MAR, APR, MEI, JUN, JUL, AGU, SEP, OKT, NOV, DES, TOTAL
        });
        setEdit(false);
        getSelling();
    }

    return (
        <div className="container mt-5">
            <div className="buttons">
                <div id="page-wrapper">
                    <p>&nbsp;</p>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel panel-primary">
                                <div class="panel-heading text-center">
                                    Data Penjualan
                                </div>
        
                                <div class="panel-body">
                                    <table width="15%" class="table table-striped table-bordered table-hover" id="dataTables-example">
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
                                                    <td>
                                 {
                                    inEditMode.status && inEditMode.rowKey === penjualan.id_penjualan ? (
                                        <React.Fragment>
                                            <button
                                                className={"btn-success"}
                                                onClick={() => 
                                                    ({penjualan_id: penjualan.nama})}
                                            >
                                                Save
                                            </button>

                                            <button
                                                className={"btn-secondary"}
                                                style={{marginLeft: 8}}
                                                onClick={() => onCancel()}
                                            >
                                                Cancel
                                            </button>
                                        </React.Fragment>
                                    ) : (
                                        <button
                                            className={"btn-primary"}
                                            onClick={() => onEdit({})}
                                        >
                                            Edit
                                        </button>
                                    )
                                }
                                </td>
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
        </div>

    )
}

export default ReportSelling