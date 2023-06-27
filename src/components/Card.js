import React, { useState, useEffect } from 'react'
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";


const Card = () => {
    return (
        <div className='w-auto h-[25rem] scale-95 hover:scale-100 hover:drop-shadow-md px-4'>
            <div className='w-full h-auto bg-white flex flex-col justify-start space-y-4 p-4'>
                <img className='w-full h-auto relative rounded-xl' src='https://images.unsplash.com/photo-1600595289052-bcab428c5b82?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=687&q=80' />
                <div className='relative'>
                    <div className='text-bold'>
                        <h1>Scarlett Whitening</h1>
                        <p>Rp.150,000</p>
                    </div>
                </div>   
            </div>
        </div>
    )
}

export default Card;