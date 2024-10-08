import React, { useMemo } from "react";
import "./CartModal.css";
import { useCart } from "react-use-cart";
import CartItem from "./CartItem/CartItem";
import { useDispatch } from "react-redux";
import { open as paymentModalOpen } from "../../../lib/features/paymentModalSlice";
import { calculateExtrasFeesForTotalCart } from "../../../lib/utils";

function CartModal({ open, onClose }) {
    const { items, cartTotal, emptyCart } = useCart();
    const resetCart = () => {
        emptyCart();
        onClose();
    };

    const dispatch = useDispatch();
    const openPaymentModal = () => dispatch(paymentModalOpen());

    const cartExtrasFees = useMemo(
        () => calculateExtrasFeesForTotalCart(items),
        [items]
    );

    const grandTotal = useMemo(
        () => cartTotal + cartExtrasFees,
        [cartTotal, cartExtrasFees]
    );

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
                                    <td>
                                        {cartTotal}
                                        {" €"}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Extras:</th>
                                    <td>
                                        {cartExtrasFees}
                                        {" €"}
                                    </td>
                                </tr>
                                <tr>
                                    <th>Total:</th>
                                    <td>
                                        {grandTotal}
                                        {" €"}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div className="d-flex gap-1 justify-content-end">
                            <button
                                className="btn btn-danger"
                                onClick={resetCart}
                            >
                                <i class="fas fa-redo me-2"></i>Reset
                            </button>
                            <button
                                className="btn btn-success"
                                onClick={openPaymentModal}
                            >
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
