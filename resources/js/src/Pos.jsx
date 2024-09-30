import { StrictMode } from "react";
import ReactDOM from "react-dom/client";
import "./index.css";
import { RouterProvider } from "react-router-dom";
import { router } from "./router.jsx";
import { QueryClient, QueryClientProvider } from "react-query";
import { Provider } from "react-redux";
import { store } from "./store.jsx";
import { CartProvider } from "react-use-cart";
import { ToastContainer } from "react-toastify";
import "react-toastify/dist/ReactToastify.css";

const queryClient = new QueryClient();

const Pos = () => {
    return (
        <StrictMode>
            <QueryClientProvider client={queryClient}>
                <Provider store={store}>
                    <CartProvider>
                        <RouterProvider router={router} />
                        <ToastContainer
                            position="top-right"
                            autoClose={5000}
                            hideProgressBar={false}
                            newestOnTop
                            closeOnClick
                            rtl={false}
                            pauseOnFocusLoss
                            draggable
                            pauseOnHover
                            theme="colored"
                            toastStyle={{
                                backgroundColor: "#e25925",
                                border: "2px solid black",
                                color: "black",
                            }}
                        />
                    </CartProvider>
                </Provider>
            </QueryClientProvider>
        </StrictMode>
    );
};

export default Pos;

if (document.getElementById("root")) {
    ReactDOM.createRoot(document.getElementById("root")).render(<Pos />);
}
