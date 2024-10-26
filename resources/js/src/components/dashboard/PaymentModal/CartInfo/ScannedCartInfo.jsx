import React, { useMemo } from "react";
import { useCart } from "react-use-cart";
import { calculateExtrasFeesForTotalCart } from "../../../../lib/utils";
import CartInfoItem from "./CartInfoItem";
import "./CartInfo.css";
import ScannedCartInfoItem from "./ScannedCartInfoItem";

function ScannedCartInfo({ items = [], cartTotal = 0.0, discount = 0.0 }) {
    const grandTotal = useMemo(
        () => cartTotal - discount,
        [cartTotal, discount]
    );
    return (
        <div className="h-100 d-flex flex-column justify-content-start">
            <h5 className="modal-title text-start mb-2" id="paymentModalLabel">
                Cart Information
            </h5>
            <div className="cart-info-items-container">
                <div className="card">
                    <table className="table mb-0 rounded">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            {items?.map((item, index) => (
                                <ScannedCartInfoItem key={index} item={item} />
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
            <div className="card mt-auto">
                <table className="table mb-0">
                    <tbody>
                        <tr>
                            <td>Subtotal</td>
                            <td>
                                {cartTotal}
                                {" €"}
                            </td>
                        </tr>
                        <tr>
                            <td>Discount</td>
                            <td>
                                {discount}
                                {" €"}
                            </td>
                        </tr>
                        <tr>
                            <td>Total</td>
                            <td>
                                {grandTotal}
                                {" €"}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    );
}

export default ScannedCartInfo;
