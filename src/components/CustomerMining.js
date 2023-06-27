import React, { useEffect, useState } from 'react';
import axios from 'axios';
function CustomerMining({ customerName }) {
    const [clusters, setCustomerData] = useState([]);
    const [loading, setLoading] = useState(true);
    useEffect(() => {
      getCust();
    }, []);
    const getCust = async () => {
        const response = await axios.get('http://localhost:5100/clusters');
        setCustomerData(response.data);
        console.log(response.data)
    }
   
    return (
      <div className="container mt-5">
        <div className="buttons">
          <div id="page-wrapper">
            <div class="row col-lg-12 w-full">
              <div class="panel panel-primary my-12">
                <div class="panel-heading text-center flex align-middle justify-center px-4">
                  <p class="text-2xl font-bold">Data Customer</p>
                </div>
                <div class="panel-body w-full my-8">
                  <table
                    class="table table-striped table-bordered table-hover w-full"
                    id="dataTables-example"
                  >
                    <thead>
                      <tr>
                        <th>Nama Customer</th>
                        <th>Cluster</th>
                        <th>Cluster Ind</th>
                        <th>Centroid</th>
                        <th>Distance</th>
                      </tr>
                    </thead>
                    <tbody>
                      {clusters.length ? (
                        clusters.map((cluster, index) => (
                          <tr key={index}>
                            <td>{customerName}</td>
                            <td>{cluster.cluster}</td>
                            <td>{cluster.cluster_ind}</td>
                            <td>{cluster.centroid}</td>
                            <td>{cluster.distances}</td>
                          </tr>
                        ))
                      ) : (
                        <tr>
                          <td colSpan="5">No data available.</td>
                        </tr>
                      )}
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
export default CustomerMining;