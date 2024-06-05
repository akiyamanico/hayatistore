/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate, Navigate } from 'react-router-dom';


const EditData = () => {
    const [nama, setNama] = useState('');
    const [id_kategori, setIdKategori] = useState('');
    const [stok, setStok] = useState('');
    const [harga, setHarga] = useState('');
    const { id_produk } = useParams();
   useEffect(() => {
  getProductById();
}, []);
    const getProductById = async () => {
          const response = await fetch(`https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/produk/${id_produk}`);
          const data = await response.json();
          setNama(data.nama);
          setHarga(data.harga); 
        };
const API_URL = 'https://kmeans-crm-backend-sequelize-c5xdhud6vq-et.a.run.app/';
const navigate = useNavigate();
const updateData = async (id_produk, nama, id_kategori, stok, harga) => {
  try {
    const response = await axios.post(`${API_URL}/update-data`, {
      id_produk: id_produk,
      nama: nama,
      id_kategori: id_kategori,
      stok: stok,
      harga: harga
    });
    console.log(response.data);
        navigate('/ReportSelling');
  } catch (error) {
    console.error(error);
  }
};
    const handleSubmit = (event) => {
        event.preventDefault();
        updateData(id_produk, nama, id_kategori, stok, harga);
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
        <input value={id_produk} onChange={(e) => getProductById(e.target.value)} type="text" placeholder="Title" />
      </label>
      <label>
        Nama:
        <input type="text" value={nama} onChange={(event) => setNama(event.target.value)} />
      </label>
      <label>
        ID Kategori:
        <input type="text" value={id_kategori} onChange={(event) => setIdKategori(event.target.value)} />
      </label>
      <label>
        Stok:
        <input type="text" value={stok} onChange={(event) => setStok(event.target.value)} />
      </label>
      <label>
        Harga:
        <input type="text" value={harga} onChange={(event) => setHarga(event.target.value)} />
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

export default EditData