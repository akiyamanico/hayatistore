import {BrowserRouter, Routes, Route} from "react-router-dom";
import Dashboard from "./components/Dashboard";
import Login from "./components/Login";
import Register from "./components/Register";
import NavigationBar from "./components/Header";
import HomePage from "./components/HomePage";
import ReportSelling from "./components/ReportSelling";
import TambahData from "./components/TambahData";
import Kmeans from "./components/Kmeans";
import Kmeans30 from "./components/Kmeans30";
import Kmeans50 from "./components/Kmeans50";
import Kmeans100 from "./components/Kmeans100";
import KmeansAll from "./components/KmeansAll";
import Hasil from "./components/Hasil";
import Centroid from "./components/Centroid";
import EditProduk from "./components/EditProduk";
import EditPages from "./components/EditPages";
 
function App() {
  return (
    <BrowserRouter>
      <Routes>
      <Route exact path="/edit" element={<><NavigationBar/><EditProduk /></>} >
        </Route>
        <Route exact path="/admin" element={<Login />} >
        </Route>
        <Route path="/register" element={<Register />}>
        </Route>
        <Route path="/dashboard" element={<><NavigationBar/><Dashboard/></>}>
        </Route>
        <Route path="/homepage" element={<><NavigationBar/><HomePage/></>}>
        </Route>
        <Route path="/reportselling" element={<><NavigationBar/><ReportSelling/></>}>
        </Route>
        <Route path="/tambahdata" element={<><NavigationBar/><TambahData/></>}>
        </Route>
        <Route path="/EditPage/:id_produk" element={<><NavigationBar/><EditPages/></>}>
        </Route>
        <Route path="/kmeans" element={<><NavigationBar/><Kmeans/></>}>
        </Route>
        <Route path="/kmeans30" element={<><NavigationBar/><Kmeans30/></>}>
        </Route>
        <Route path="/kmeans50" element={<><NavigationBar/><Kmeans50/></>}>
        </Route>
        <Route path="/kmeans100" element={<><NavigationBar/><Kmeans100/></>}>
        </Route>
        <Route path="/kmeansall" element={<><NavigationBar/><KmeansAll/></>}>
        </Route>
        <Route path="/hasil" element={<><NavigationBar/><Hasil/></>}>
        </Route>
        <Route path="/centroid" element={<><NavigationBar/><Centroid/></>}>
        </Route>
      </Routes>
    </BrowserRouter>
  );
}
 
export default App;