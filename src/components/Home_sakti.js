import React, { useState, useEffect } from 'react'
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";
import Card from './Card';


const HayatiHome = () => {
    return (
        <div className='container'>
            <div className='grid grid-cols-2 gap-5 my-auto'>
                <div className='flex flex-col space-y-12'>
                    <h1 className='font-westbourne text-8xl py-5'>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</h1>
                    <p className='font-opensans text-xl'>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In feugiat, metus quis scelerisque fringilla, quam ante sollicitudin metus, eu mattis sem leo fringilla ex. Donec placerat velit et mauris aliquet, sit amet imperdiet orci vehicula. Vivamus accumsan erat ut leo tincidunt, quis fermentum ipsum molestie. Cras non eros non nisl egestas sodales.</p>
                    <button className='flex items-start font-opensans text-2xl'>Shop Now</button>
                </div>
                <div className='flex justify-center items-end'>
                    <img className='rounded-t-[12rem] w-[200%] h-auto' src='hero.jpeg' />
                </div>
            </div>
            <div className='bg-almostwhite w-full h-[50rem] my-32 mx-0'>
                <div className='flex items-start'>
                    <h1 className='font-westbourne text-7xl py-24 px-8'>We Recommend This.</h1>
                </div>
                <div className='overflow-x-auto whitespace-nowrap no-scrollbar h-auto'>
                    <div className='flex flex-row'>
                        <Card />
                        <Card />
                        <Card />
                        <Card />
                        <Card />
                    </div>
                </div>
            </div>
            <div className='grid grid-row-4 gap-8 my-auto'>
                <div className='font-opensans text-xl text-center'>
                    About Us
                </div>
                <div className='font-westbourne text-6xl text-center'>
                    Melayani Sepenuh Hati
                </div>
                <div className='font-opensans text-xl text-center'>
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. In feugiat, metus quis scelerisque fringilla, quam ante sollicitudin metus, eu mattis sem leo fringilla ex. Donec placerat velit et mauris aliquet, sit amet imperdiet orci vehicula. Vivamus accumsan erat ut leo tincidunt, quis fermentum ipsum molestie. Cras non eros non nisl egestas sodales. Curabitur hendrerit pellentesque nisi eu faucibus. Duis id odio non justo interdum sagittis. Praesent quis faucibus odio, sit amet scelerisque enim.
                </div>
                <div className='flex space-x-4 justify-center items-center'>
                    <img className='h-96 w-96' src='hero.jpeg'/>
                    <img className='h-96 w-96' src='hero.jpeg'/>
                    <img className='h-96 w-96' src='hero.jpeg'/>
                </div>
            </div>
        </div>
    )
}

export default HayatiHome;