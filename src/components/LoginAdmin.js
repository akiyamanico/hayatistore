import React, { useState } from 'react'
import axios from 'axios';
import { useNavigate } from 'react-router-dom';
import Header from "./LoginHeader"
 
const LoginAdmin = () => {
    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [msg, setMsg] = useState('');
    const navigate = useNavigate();

 
    const Auth = async (e) => {
        e.preventDefault();
        try {
            await axios.post('http://localhost:5000/login', {
                email: email,
                password: password
            });
            navigate("/Dashboard");
        } catch (error) {
            if (error.response) {
                setMsg(error.response.data.msg);
            }
        }
    }
 
    return (
        <section className="min-h-full h-[50%] flex  justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div className="min-h-full h-[50%] rounded-md appearance-none relative block px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm">
            
            <Header></Header><div className="max-w-md w-full space-y-8">
                    <div className="columns is-centered">
                        <div className="column is-4-desktop">
                            <form onSubmit={Auth} className="mt-8 space-y-6">
                                <p className="has-text-centered">{msg}</p>
                                <div className="-space-y-px">
                                    <label className="label">Email</label>
                                    <div className="controls">
                                        <input type="text" className="input" placeholder="Username" value={email} onChange={(e) => setEmail(e.target.value)} />
                                    </div>
                                </div>
                                <div className="-space-y-px">
                                    <label className="label">Password</label>
                                    <div className="controls">
                                        <input type="password" className="input" placeholder="******" value={password} onChange={(e) => setPassword(e.target.value)} />
                                    </div>
                                </div>
                                <div className="field mt-5">
                                    <button className="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-pink-300 hover:bg-pink-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 mt-10">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
            </div>
            </div>
        </section>
    )
}
 
export default LoginAdmin