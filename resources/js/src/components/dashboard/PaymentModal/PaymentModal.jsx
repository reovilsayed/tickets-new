import React, { useEffect, useState } from "react";
import "./PaymentModal.css";
import { useDispatch } from "react-redux";
import { close } from "../../../lib/features/paymentModalSlice";
import { useCart } from "react-use-cart";
import axios from "axios";
import CartInfo from "./CartInfo/CartInfo";

const PaymentModal = ({ open }) => {
    const [formData, setFormData] = useState({
        name: "",
        email: "",
        vatNumber: "",
        address: "",
        discount: 0.0,
    });
    const handleFormData = (event) => {
        const { name, value } = event.target;
        setFormData((prev) => {
            return { ...prev, [name]: value };
        });
    };

    const [sendToMail, setSendToMail] = useState(true);
    const [printTicket, setPrintTicket] = useState(false);

    const [orderRequestProcessing, setOrderRequestProcessing] = useState(false);

    useEffect(() => {
        const modalElement = document.getElementById("paymentModal");

        if (open) {
            modalElement.classList.add("show", "fade-in");
            modalElement.style.display = "block";
        } else {
            modalElement.classList.remove("fade-in");
            modalElement.classList.add("fade-out");
            setTimeout(() => {
                modalElement.style.display = "none";
                modalElement.classList.remove("show", "fade-out");
            }, 300);
        }
    }, [open]);

    const dispatch = useDispatch();
    const handleClose = () => dispatch(close());

    const { items, cartTotal, emptyCart } = useCart();

    const submitOrder = async () => {
        setOrderRequestProcessing(true);
        const orderData = {
            biling: formData,
            tickets: items.filter((item) => item.isTicket),
            extras: items.filter((item) => !item.isTicket),
            discount: formData["discount"],
            subTotal: cartTotal,
            total: cartTotal,
            sendToMail,
        };
        const response = await axios.post(
            `${import.meta.env.VITE_APP_URL}/api/create-order`,
            orderData,
            {
                headers: {
                    "Content-Type": "application/json",
                    "X-Secret-Key": "pos_password",
                },
            }
        );
        if (response.status == 200) {
            setFormData({
                name: "",
                email: "",
                vatNumber: "",
                address: "",
                discount: 0.0,
            });
            if (printTicket) {
                if (response?.data?.security_key)
                    window.open(
                        `${import.meta.env.VITE_APP_URL}/t/${
                            response?.data?.security_key
                        }`,
                        "_blank"
                    );
                setPrintTicket(false);
            }
            setSendToMail(true);
            emptyCart("");
            handleClose();
        }
        setOrderRequestProcessing(false);
    };

    return (
        <>
            {open && (
                <div className="payment-modal-backdrop payment-modal-fade-in"></div>
            )}
            <div
                className={`modal payment-modal ${
                    open ? "payment-modal-fade-in" : "payment-modal-fade-out"
                }`}
                id="paymentModal"
                tabIndex="-1"
                aria-labelledby="paymentModalLabel"
                aria-hidden={!open}
                onClick={handleClose}
            >
                <div
                    className="modal-dialog modal-center modal-lg"
                    onClick={(e) => e.stopPropagation()}
                >
                    <div className="modal-content p-0">
                        <div className="modal-header">
                            <h5
                                className="modal-title text-center"
                                id="paymentModalLabel"
                            >
                                Place Order
                            </h5>
                            <button
                                type="button"
                                className="btn-close"
                                aria-label="Close"
                                onClick={handleClose}
                            ></button>
                        </div>
                        <div className="modal-body row">
                            <div className="col-md-6">
                                <h5
                                    className="modal-title text-start mb-2"
                                    id="paymentModalLabel"
                                >
                                    Payment Information
                                </h5>
                                <div className="form-group mb-2">
                                    <label htmlFor="nameInput">Name</label>
                                    <input
                                        id="nameInput"
                                        name="name"
                                        className="form-control"
                                        value={formData["name"]}
                                        onChange={handleFormData}
                                        placeholder="Enter name"
                                    />
                                </div>
                                <div className="form-group mb-2">
                                    <label htmlFor="emailInput">Email</label>
                                    <input
                                        id="emailInput"
                                        className="form-control"
                                        name="email"
                                        value={formData["email"]}
                                        onChange={handleFormData}
                                        placeholder="Enter email"
                                    />
                                </div>
                                <div className="form-group mb-2">
                                    <label htmlFor="vatInput">VAT Number</label>
                                    <input
                                        id="vatInput"
                                        className="form-control"
                                        name="vatNumber"
                                        value={formData["vatNumber"]}
                                        onChange={handleFormData}
                                        placeholder="Enter VAT number"
                                    />
                                </div>
                                <div className="form-group mb-2">
                                    <label htmlFor="addressInput">
                                        Address
                                    </label>
                                    <textarea
                                        id="addressInput"
                                        className="form-control"
                                        name="address"
                                        value={formData["address"]}
                                        onChange={handleFormData}
                                        placeholder="Enter address"
                                    />
                                </div>
                                <div className="form-group mb-4">
                                    <label htmlFor="discountInput">
                                        Discount
                                    </label>
                                    <input
                                        id="discountInput"
                                        type="number"
                                        className="form-control"
                                        name="discount"
                                        value={
                                            formData["discount"] > 0.0
                                                ? formData["discount"]
                                                : ""
                                        }
                                        onChange={handleFormData}
                                        placeholder="Enter discount (%)"
                                    />
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value={sendToMail}
                                        checked={sendToMail}
                                        onChange={() =>
                                            setSendToMail((prev) => !prev)
                                        }
                                        id="sendToMailCheck"
                                    />
                                    <label
                                        class="form-check-label"
                                        for="sendToMailCheck"
                                    >
                                        Send to mail
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value={printTicket}
                                        checked={printTicket}
                                        onChange={() =>
                                            setPrintTicket((prev) => !prev)
                                        }
                                        id="printTicketCheck"
                                    />
                                    <label
                                        class="form-check-label"
                                        for="printTicketCheck"
                                    >
                                        Print Ticket
                                    </label>
                                </div>
                            </div>
                            <div className="col-md-6">
                                <CartInfo discount={formData["discount"]} />
                            </div>
                        </div>
                        <div className="modal-footer">
                            <button
                                type="button"
                                className="btn btn-secondary"
                                onClick={handleClose}
                            >
                                Close
                            </button>
                            <button
                                type="button"
                                className="btn btn-primary"
                                onClick={submitOrder}
                                disabled={
                                    !formData["name"] ||
                                    !formData["email"] ||
                                    !formData["vatNumber"] ||
                                    !formData["address"] ||
                                    orderRequestProcessing
                                }
                            >
                                {orderRequestProcessing
                                    ? "Processing..."
                                    : "Proceed"}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
};

export default PaymentModal;
