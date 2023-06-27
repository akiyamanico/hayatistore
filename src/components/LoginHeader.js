import React, { useState, useEffect } from 'react'
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";

const LoginHeader = () => {
    return (
        <header class="container">
            <div className='flex justify-center py-16 mx-auto'>
                <div className='flex items-center'>
                    <h1 className='font-westbourne text-5xl'>Hayati Store</h1>
                </div>
            </div>
        </header>
    )
}

export default LoginHeader;