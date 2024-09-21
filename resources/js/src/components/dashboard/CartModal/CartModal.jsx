import React, { useEffect, useRef } from "react";
import "./CartModal.css";
import { useCart } from "react-use-cart";
import CartItem from "./CartItem/CartItem";

function CartModal({ open, onClose }) {
    const { items } = useCart();
    return open ? (
        <>
            <div
                className="cart-modal-backdrop cart-fade-in"
                onClick={onClose}
            ></div>
            <div
                className={`cart-modal ${
                    open ? "cart-fade-in" : "cart-fade-out"
                }`}
                tabIndex="-1"
                id="offcanvasExample"
                aria-labelledby="offcanvasExampleLabel"
                aria-hidden={!open}
                onClick={(e) => e.stopPropagation()}
            >
                <div className="offcanvas-header">
                    <h5 className="offcanvas-title" id="offcanvasExampleLabel">
                        Cart
                    </h5>
                    <button
                        type="button"
                        className="btn-close"
                        data-bs-dismiss="offcanvas"
                        aria-label="Close"
                        onClick={onClose}
                    ></button>
                </div>
                <div className="offcanvas-body">
                    <div className="cart-items">
                        {items?.map((item, index) => (
                            <CartItem key={index} item={item} />
                        ))}
                    </div>
                    <div className="footer_body_modal card bg-light">
                        <table className="table table-hover table-bordered">
                            <tbody>
                                <tr>
                                    <th>Sub Total:</th>
                                    <td> Tk</td>
                                </tr>
                                <tr>
                                    <th>Discount:</th>
                                    <td> Tk</td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td> Tk</td>
                                </tr>
                            </tbody>
                        </table>

                        <div className="d-flex gap-1 justify-content-end">
                            <button className="btn btn-danger">
                                <i class="fas fa-redo me-2"></i>Reset
                            </button>
                            <button className="btn btn-success">
                                <i class="fas fa-money-bill-wave me-2"></i>Pay
                                Now
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </>
    ) : (
        ""
    );
}

export default CartModal;
