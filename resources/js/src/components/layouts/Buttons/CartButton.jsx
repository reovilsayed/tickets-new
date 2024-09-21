import React from "react";
import { useCart } from "react-use-cart";

function CartButton({ onClick }) {
    const { totalUniqueItems } = useCart();
    return (
        <div onClick={onClick}>
            <button
                type="button"
                className="btn btn-dark btn-lg position-fixed"
                style={{ bottom: "20px", right: "20px", zIndex: 100 }}
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasExample"
                aria-controls="offcanvasExample"
            >
                <i className="fa fa-shopping-bag"></i>
                <sup> {totalUniqueItems || 0}</sup>
            </button>
        </div>
    );
}

export default CartButton;
