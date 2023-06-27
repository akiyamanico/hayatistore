import React, { useState, useEffect } from 'react'
import jwt_decode from "jwt-decode";
import { useParams, useNavigate } from 'react-router-dom';
import { Link } from "react-router-dom";

const FooterHome = () => {
    return (
        <footer class="bg-white dark:bg-gray-900 m-4">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between"> 
            <h1 className="font-westbourne text-2xl">Hayati Store</h1>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li>
                    <a href="https://www.instagram.com/newhayatistore/" class="mr-4 hover:underline md:mr-6 ">Instagram</a>
                </li>
                <li>
                    <a href="https://web.whatsapp.com/send?phone=6281298764851" class="mr-4 hover:underline md:mr-6">Contact us</a>
                </li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2023 <a href="#" class="hover:underline">Fi Zilalil Huda</a>. All Rights Reserved.</span>
    </div>
</footer>
    )
}

export default FooterHome;