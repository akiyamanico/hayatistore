/* eslint-disable react-hooks/exhaustive-deps */
import React, { useState, useEffect } from 'react'
import axios from 'axios';
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";


const KmeansJS = () => {
    const [name, setName] = useState('');
    const [token, setToken] = useState('');
    const [expire, setExpire] = useState('');
    const [users, setUsers] = useState([]);
    const navigate = useNavigate();
    const [distances, setDistances] = useState([]);
    const [centroidHistory, setCentroidHistory] = useState([]);


    useEffect(() => {
        refreshToken();
        getUsers();
        getSelling();
    }, []);


    const getSelling = async () => {
        try {
            const response = await axios.get('https://hayati.fly.dev/kmeans_test');
            const { distances, centroidHistory } = response.data;
            setDistances(distances);
            setCentroidHistory(centroidHistory);
        } catch (error) {
            console.error(error);
        }
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
    const Logout = async () => {
        try {
            await axios.delete('https://sequelizehayati.fly.dev/logout');
            navigate('/');
        } catch (error) {
            console.log(error);
        }
    }
    return (
        <div className="container mt-2">
          <div className="buttons">
            <div className="row col-lg-12">
              <div className="panel panel-primary my-12">
                <div className="panel-body">
                  <table classname="responsive striped bordered hover" id="dataTables-example">
                    <thead>
                      <tr>
                        <th>Iteration Count</th>
                        <th>Cluster</th>
                        <th>Name</th>
                        <th>Cluster</th>
                        <th>Distance</th>
                        <th>Label</th>
                      </tr>
                    </thead>
                    <tbody>
                      {distances.map((iterationDistances, index) => (
                        <React.Fragment key={index}>
                          <tr>
                            <td colSpan="6">
                              <b><h3>Iteration {index + 1}</h3></b>
                            </td>
                          </tr>
                          {iterationDistances.map((clusterDistances, clusterIndex) => (
                            <React.Fragment key={clusterIndex}>
                              <tr>
                                <td colSpan="6">
                                  <b><i><h4>Cluster {clusterIndex + 1}</h4></i></b>
                                </td>
                              </tr>
                              {clusterDistances.map((distance, distanceIndex) => (
                                <tr key={distanceIndex}>
                                  <td>{index + 1}</td>
                                  <td>{clusterIndex + 1}</td>
                                  <td>{distance.nama}</td>
                                  <td>{distance.cluster}</td>
                                  <td>{distance.distance}</td>
                                  <td>{distance.label}</td>
                                </tr>
                              ))}
                            </React.Fragment>
                          ))}
                        </React.Fragment>
                      ))}
                    </tbody>
                  </table>
                  <div className="flex align-middle justify-center space-x-4 my-8">
                    <h2>Centroid History</h2>
                  </div>
                  <div className="flex align-middle justify-center space-x-4 my-8">
                    {centroidHistory.map((iterationCentroids, index) => (
                      <div key={index}>
                        <h3>Iteration {index + 1}</h3>
                        <ul>
                          {iterationCentroids.map((centroid, centroidIndex) => (
                            <li key={centroidIndex}>
                              C1: {centroid.total}, C2: {centroid.stok}
                            </li>
                          ))}
                        </ul>
                      </div>
                    ))}
                  </div>
                  <thead>
                      <tr>
                        <th>Iteration Count</th>
                        <th>Cluster</th>
                        <th>Name</th>
                        <th>Cluster</th>
                        <th>Distance</th>
                        <th>Label</th>
                      </tr>
                    </thead>
                    <tbody>
                        
                        </tbody>
                  {/* //TODO : Pagination */}
                </div>
              </div>
            </div>
          </div>
        </div>
      );
    }
export default KmeansJS