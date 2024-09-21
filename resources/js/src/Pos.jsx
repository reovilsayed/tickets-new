import { StrictMode } from "react";
import ReactDOM from "react-dom/client";
import "./index.css";
import { RouterProvider } from "react-router-dom";
import { router } from "./router.jsx";
import { QueryClient, QueryClientProvider } from "react-query";
import { Provider } from "react-redux";
import { store } from "./store.jsx";
import { CartProvider } from "react-use-cart";

const queryClient = new QueryClient();

const Pos = () => {
    return (
        <StrictMode>
            <QueryClientProvider client={queryClient}>
                <Provider store={store}>
                    <CartProvider>
                        <RouterProvider router={router} />
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
