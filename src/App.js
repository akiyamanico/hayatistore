import {BrowserRouter, Routes, Route} from "react-router-dom";
import Dashboard from "./components/Dashboard";
import LoginAdmin from "./components/LoginAdmin";
import Register from "./components/Register";
import NavigationBar from "./components/Header";
import HomePage from "./components/HomePage";
import ReportSelling from "./components/ReportSelling";
import ReportCustomer from "./components/ReportCustomer";
import TambahData from "./components/TambahData";
import Kmeans from "./components/Kmeans";
import KmeansPembeli from "./components/KmeansPembeli";
import Kmeans30 from "./components/Kmeans30";
import Kmeans50 from "./components/Kmeans50";
import Kmeans100 from "./components/Kmeans100";
import KmeansAll from "./components/KmeansAll";
import KmeansJS from "./components/KmeansNew";
import Hasil from "./components/Hasil";
import HasilPHP from "./components/HasilPHP";
import Centroid from "./components/Centroid";
import LoginHeader from "./components/LoginHeader";
import EditData from "./components/EditData";
import EditDataPenjualan from "./components/EditDataPenjualan";
import HayatiHome from "./components/Home";
import HeaderHome from "./components/HeaderHayati";
import FooterHome from "./components/FooterHayati";
import LoginMember from "./components/LoginMember";
import CustomerMining from "./components/CustomerMining";
import CustomerKmeans from "./components/CustomerKmeans";
import RegisterMember from "./components/RegisterMember";
import LogoutButton from "./components/LogoutButton";
import CatalogList from "./components/CatalogList";
import CartView from "./components/CartView";
import ProductView from "./components/ProductView";
import StatusPayment from "./components/StatusPayment";
import CheckPaymentCustomer from "./components/CheckPaymentCustomer";
function App() {
  return (
    <BrowserRouter>
      <Routes>
      <Route exact path="/" element={<><HeaderHome/><HayatiHome/><FooterHome/></>} >
        </Route>
        <Route exact path="/Catalog" element={<><HeaderHome/><CatalogList/><FooterHome/></>} >
        </Route>
        <Route exact path="/admin" element={<LoginAdmin />} >
        </Route>
        <Route exact path="/CartView" element={<><HeaderHome/><CartView/><FooterHome/></>} >
        </Route>
        <Route exact path="/StatusPayment" element={<><HeaderHome/><StatusPayment/><FooterHome/></>} >
        </Route>
        <Route exact path="/ProductView/:id_produk" element={<><HeaderHome/><ProductView/><FooterHome/></>} >
        </Route>
        <Route exact path="/Logout" element={<LogoutButton />} >
        </Route>
        <Route exact path="/RegisterMember" element={<><LoginHeader/><RegisterMember /></>} >
        </Route>
        <Route exact path="/login" element={<><LoginHeader/><LoginMember /></>} >
        </Route>
        <Route path="/register" element={<Register />}>
        </Route>
        <Route path="/dashboard" element={<><NavigationBar/><Dashboard/></>}>
        </Route>
        <Route path="/CustomerMining" element={<><NavigationBar/><CustomerMining/></>}>
        </Route>
        <Route path="/CheckPaymentCustomer" element={<><NavigationBar/><CheckPaymentCustomer/></>}>
        </Route>
        <Route path="/homepage" element={<><NavigationBar/><HomePage/></>}>
        </Route>
        <Route path="/reportselling" element={<><NavigationBar/><ReportSelling/></>}>
        </Route>
        <Route path="/reportcustomer" element={<><NavigationBar/><ReportCustomer/></>}>
        </Route>
        <Route path="/CustomerKmeans" element={<><NavigationBar/><CustomerKmeans/></>}>
        </Route>
        <Route path="/tambahdata" element={<><NavigationBar/><TambahData/></>}>
        </Route>
        <Route path="/kmeans" element={<><NavigationBar/><Kmeans/></>}>
        </Route>
        <Route path="/kmeanspembeli" element={<><NavigationBar/><KmeansPembeli/></>}>
        </Route>
        <Route path="/kmeans30" element={<><NavigationBar/><Kmeans30/></>}>
        </Route>
        <Route path="/kmeans50" element={<><NavigationBar/><Kmeans50/></>}>
        </Route>
        <Route path="/kmeans100" element={<><NavigationBar/><Kmeans100/></>}>
        </Route>
        <Route path="/kmeansall" element={<><NavigationBar/><KmeansAll/></>}>
        </Route>
        <Route path="/kmeansjs" element={<><NavigationBar/><KmeansJS/></>}>
        </Route>
        <Route path="/hasil" element={<><NavigationBar/><Hasil/></>}>
        </Route>
        <Route path="/HasilPHP" element={<><NavigationBar/><HasilPHP/></>}>
        </Route>
        <Route path="/centroid" element={<><NavigationBar/><Centroid/></>}>
        </Route>
        <Route path="/EditData/:id_produk" element={<><NavigationBar/><EditData/></>}>
        </Route>
        <Route path="/EditDataPenjualan/:id_produk" element={<><NavigationBar/><EditDataPenjualan/></>}>
        </Route>
      </Routes>
    </BrowserRouter>
  );
}
 
export default App;