const BASE_API_URL = "http://localhost:8081";

const Products = ({
  id_produk,
    nama_produk,
    id_kategori,
    stok,
    harga
}) => {
  return (

        <div className="flex flex-col p-4">
          <h4 className="mb-1 text-xl font-medium mt-5">{id_produk}</h4>
          <h4 className="mb-1 text-xl font-medium mt-5">{nama_produk}</h4>
          <p className="text-lg mb-4">{id_kategori}</p>
          <p className="text-lg mb-4">{harga}</p>
          <div className="flex items-center justify-between">
            <p className="py-1 px-3 bg-slate-200 w-fit text-2xl font-semibold rounded">
              {harga}
            </p>
            <p className="font-bold text-xl">
              {stok > 0
                ? `In Stock: ${stok}`
                : "Out of Stock"}
            </p>
          </div>
        </div>
 
  );
};




export default Products;