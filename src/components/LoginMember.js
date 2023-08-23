import React, { useState, useEffect } from 'react'
import axios from 'axios';
import { useNavigate } from 'react-router-dom';

const LoginMember = () => {
    const [email, setUsername] = useState('');
    const [password, setPassword] = useState('');
    const navigate = useNavigate();
    const [showModal, setShowModal] = useState(false);
    const handleSubmit = event => {
        event.preventDefault();
        axios.post('https://hayati.fly.dev/loginmember', { email, password }).then(response => {
            document.cookie = `token=${response.data.token}; expires=Sun, 31 Dec 2023 23:59:59 GMT; path=/`;
            navigate('/');
        }).catch(error => {
            setShowModal(true);
        });
    };
    const getCookieValue = name => {
        const cookies = document.cookie.split(';');

        for (let i = 0; i < cookies.length; i++) {
            const cookie = cookies[i].trim();
            if (cookie.startsWith(`${name}=`)) {
                return cookie.substring(name.length + 1);
            }
        }

        return undefined;
    };

    // Example usage to get the token from the cookie
    const token = getCookieValue('token');
    console.log('Token:', token);

    return (

        <section className="flex grow h-128 justify-center py-16 px-4 sm:px-8 lg:px-8">
            <div className="rounded-md appearance-none relative block px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm">
                <div className="max-w-md w-full space-y-8">
                    <div className="columns is-centered">
                        <div className={`modal ${showModal ? 'visible' : 'hidden'}`}>
                            <div className="modal-content">
                                <p>Password Salah! Silahkan Cek Password</p>
                                <button onClick={() => setShowModal(false)}>Close</button>
                            </div>
                        </div>
                        <div className="column is-4-desktop">
                            <form onSubmit={handleSubmit} className="mt-8 space-y-6">
                                <p className="has-text-centered"></p>
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
                                    <button type="submit" className="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 mt-10">Login</button>
                                </div>
                            </form>
                            <a href='/RegisterMember'><button className="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 mt-10">Tidak Punya Akun? Yuk Bergabung</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    )
}

export default LoginMember