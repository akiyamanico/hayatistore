import React, { useState, useEffect } from 'react'
import axios from 'axios';
import { Navigate } from 'react-router-dom';

const Register = () => {
    const [nama, setNama] = useState('');
    const [email, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const [showPopup, setShowPopup] = useState(false);
    const [showSuccessPopup, setShowSuccessPopup] = useState(false);
    const handleSubmit = (e) => {
        e.preventDefault();
        const data = {
          nama: nama,
          email: email,
          password: password
        };
        axios.post('https://kmeans-crm-backend-node-c5xdhud6vq-et.a.run.app/registerusers', data)
          .then(response => {
            setShowSuccessPopup(true);
            console.log(response);
            
          })
          .catch(error => {
            console.log(error);
            Navigate('/RegisterMember');
          });
      };
    return (
        
        <section className="flex grow h-128 justify-center py-16 px-4 sm:px-8 lg:px-8">
            <div className="rounded-md appearance-none relative block px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm">
            <div className="max-w-md w-full space-y-8">
            {showSuccessPopup && (
    <div className="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-75">
      <div className="bg-white rounded-md p-8">
        <h2 className="text-xl font-bold mb-4">Registrasi Sukses!!</h2>
        <div className='items-center justify-center'>
        <p>Selamat Datang Di Hayati Store!</p>
        <a href='/login'><p>Tekan Disini Untuk Login</p></a>
        </div>
      </div>
    </div>
            )}
                    <div className="columns is-centered">
                        <div className="column is-4-desktop">
                            <form onSubmit={handleSubmit} className="mt-8 space-y-6">
                                <p className="has-text-centered"></p>
                                <div className="-space-y-px">
                                    <label className="label">Nama</label>
                                    <div className="controls">
                                        <input type="text" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Nama" value={nama} onChange={event => setNama(event.target.value)} />
                                    </div>
                                </div>
                                <div className="-space-y-px">
                                    <label className="label">Email</label>
                                    <div className="controls">
                                        <input type="text" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Email" value={email} onChange={event => setUsername(event.target.value)} />
                                    </div>
                                </div>
                                <div className="-space-y-px">
                                    <label className="label">Password</label>
                                    <div className="controls">
                                        <input type="password" className="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="******" value={password} onChange={event => setPassword(event.target.value)} />
                                    </div>
                                </div>
                                <div className="field mt-5">
                                    <button type="submit" className="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 mt-10">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
            </div>
        </section>
    )
}
 
export default Register