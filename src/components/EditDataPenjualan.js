/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate, Navigate } from 'react-router-dom';


const EditDataPenjualan = () => {
    const [JAN, setJAN] = useState('');
    const [FEB, setFEB] = useState('');
    const [MAR, setMAR] = useState('');
    const [APR, setAPR] = useState('');
    const [MEI, setMEI] = useState('');
    const [JUN, setJUN] = useState('');
    const [JUL, setJUL] = useState('');
    const [AGUST, setAGUST] = useState('');
    const [SEPT, setSEPT] = useState('');
    const [OKT, setOKT] = useState('');
    const [NOV, setNOV] = useState('');
    const [DES, setDES] = useState('');
    const { id_produk } = useParams();
   useEffect(() => {
    const getProductById = async () => {
        const response = await fetch(`https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/editpenjualan/${id_produk}`);
        const data = await response.json();
      };
  getProductById();
  
}, []);
    
const API_URL = 'http://localhost:5100';
const navigate = useNavigate();
const updateData = async (id_produk, JAN, FEB, MAR, APR, MEI, JUN, JUL, AGUST, SEPT, OKT, NOV, DES) => {
  try {
    const response = await axios.post(`${API_URL}/update-data-penjualan`, {
        id_produk: id_produk,
        JAN: JAN,
        FEB: FEB,
        MAR: MAR,
        APR: APR,
        MEI: MEI,
        JUN: JUN,
        JUL: JUL,
        AGUST: AGUST,
        SEPT: SEPT,
        OKT: OKT,
        NOV: NOV,
        DES: DES
    });
    console.log(response.data);
        navigate('/ReportSelling');
  } catch (error) {
    console.error(error);
  }
};
    const handleSubmit = (event) => {
        event.preventDefault();
        updateData(id_produk, JAN, FEB, MAR, APR, MEI, JUN, JUL, AGUST, SEPT, OKT, NOV, DES);
      };
    return (
      <section className="hero has-background-grey-light is-fullheight is-fullwidth">
            <div className="hero-body">
                <div className="container">
                <div class=" object-center hover:box-content box-border h-512 w-512 p-4 border-4 ...">
                    <div className="columns is-centered">
                        <div className="column is-4-desktop">
                        <form onSubmit={handleSubmit}>
        <label>
            ID Produk:
            <input value={id_produk} onChange={(e) => setJAN(e.target.value)} type="text" placeholder="Title" />
        </label>
        <label>
            JAN:
            <input type="text" value={JAN} onChange={(event) => setJAN(event.target.value)} />
        </label>
        <label>
            FEB:
            <input type="text" value={FEB} onChange={(event) => setFEB(event.target.value)} />
        </label>
        <label>
            MAR:
            <input type="text" value={MAR} onChange={(event) => setMAR(event.target.value)} />
        </label>
        <label>
            APR:
            <input type="text" value={APR} onChange={(event) => setAPR(event.target.value)} />
        </label>
        <label>
            MEI:
            <input type="text" value={MEI} onChange={(event) => setMEI(event.target.value)} />
        </label>
        <label>
            JUN:
            <input type="text" value={JUN} onChange={(event) => setJUN(event.target.value)} />
        </label>
        <label>
            JUL:
            <input type="text" value={JUL} onChange={(event) => setJUL(event.target.value)} />
        </label>
        <label>
            AGUST:
            <input type="text" value={AGUST} onChange={(event) => setAGUST(event.target.value)} />
        </label>
        <label>
            SEPT:
            <input type="text" value={SEPT} onChange={(event) => setSEPT(event.target.value)} />
        </label>
        <label>
            OKT:
            <input type="text" value={OKT} onChange={(event) => setOKT(event.target.value)} />
        </label>
        <label>
            NOV:
            <input type="text" value={NOV} onChange={(event) => setNOV(event.target.value)} />
        </label>
        <label>
            DES:
            <input type="text" value={DES} onChange={(event) => setDES(event.target.value)} />
        </label>
        
      <button type="submit">Update Data</button>
    </form>
    </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    )
}

export default EditDataPenjualan