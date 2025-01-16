import React, { useEffect, useMemo, useState } from "react";
import "./PaymentModal.css";
import { useCart } from "react-use-cart";
import axios from "axios";
import { useNavigate } from "react-router-dom";
import ScannedCartInfo from "./CartInfo/ScannedCartInfo";
import PhoneNumberInput from "./PhoneNumberInput";
import { useFetch } from "../../../lib/hooks/useFetch";

const ScannerPaidInviteModal = ({ open, onClose, ticket, onSubmit }) => {
    const [sendToPhone, setSendToPhone] = useState(true);
    const [sendToMail, setSendToMail] = useState(false);
    const grandTotal = useMemo(() => ticket?.price, [ticket]);
    const [paidTotal, setPaidTotal] = useState(0.0);
    const returnAmount = useMemo(
        () =>
            paidTotal > grandTotal ? parseFloat(paidTotal - grandTotal) : 0.0,
        [grandTotal, paidTotal]
    );

    const handleSendToMail = () => {
        setSendToMail((prev) => {
            if (prev) return false;
            return true;
        });
    };
    const handleSendToPhone = () => {
        setSendToPhone((prev) => {
            if (prev) return false;
            return true;
        });
    };
    const [formData, setFormData] = useState({
        name: "",
        email: "",
        phone: "",
        vatNumber: "",
        discount: 0.0,
        paymentMethod: "Cash",
    });

    useEffect(() => {
        if (ticket?.order_id?.billing) {
            setFormData({
                name: ticket.order_id.billing.name || "",
                email: ticket.order_id.billing.email || "",
                phone: ticket.order_id.billing.phone || "",
                vatNumber: ticket.order_id.billing.vatNumber || "",
                discount: 0.0,
                paymentMethod: "Cash",
            });
        }
    }, [ticket]);

    const handleFormData = (event) => {
        const { name, value } = event.target;
        setFormData((prev) => {
            return { ...prev, [name]: value };
        });
    };

    const [orderRequestProcessing, setOrderRequestProcessing] = useState(false);

    useEffect(() => {
        const modalElement = document.getElementById("scannerPaidInviteModal");

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

    const handleClose = () => onClose();

    const submitOrder = async () => {
        setOrderRequestProcessing(true);
        const orderData = {
            biling: formData,
            ticket: ticket.id,
            paymentMethod: formData["paymentMethod"],
            sendToMail,
            sendToPhone,
        };
        const response = await axios.post(
            `${import.meta.env.VITE_APP_URL}/api/paid-ticket/update`,
            orderData,
            {
                headers: {
                    "Content-Type": "application/json",
                    "X-Secret-Key": "pos_password",
                },
            }
        );
        if (response.status == 200) {
            setSendToMail(false);
            setSendToPhone(false);
            onSubmit(response.ticket);
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
                id="scannerPaidInviteModal"
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
                                Activate TIcket
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
                                    <label htmlFor="emailInput">
                                        Email{" "}
                                        {formData["vatNumber"] || sendToMail
                                            ? ""
                                            : "(optional)"}
                                    </label>
                                    <input
                                        id="emailInput"
                                        className="form-control"
                                        name="email"
                                        value={formData["email"]}
                                        onChange={handleFormData}
                                        placeholder="Enter email"
                                    />
                                </div>
                                {sendToPhone ? (
                                    <PhoneNumberInput
                                        value={formData["phone"]}
                                        onChange={(value) =>
                                            setFormData((prev) => {
                                                return {
                                                    ...prev,
                                                    phone: "+" + value,
                                                };
                                            })
                                        }
                                    />
                                ) : (
                                    ""
                                )}

                                <div className="form-group mb-2">
                                    <label htmlFor="vatInput">
                                        VAT Number (optional)
                                    </label>
                                    <input
                                        id="vatInput"
                                        className="form-control"
                                        name="vatNumber"
                                        value={formData["vatNumber"]}
                                        onChange={handleFormData}
                                        placeholder="Enter VAT number"
                                    />
                                </div>
                                <div className="form-group row mb-4">
                                    <div className="col-md-4">
                                        <label htmlFor="discountInput">
                                            Payment Method
                                        </label>
                                        <select
                                            class="form-select"
                                            aria-label="Default select example"
                                            onChange={(event) =>
                                                setFormData((prev) => {
                                                    return {
                                                        ...prev,
                                                        paymentMethod:
                                                            event.target.value,
                                                    };
                                                })
                                            }
                                        >
                                            <option value="Cash" selected>
                                                Cash
                                            </option>
                                            <option value="Card">Card</option>
                                        </select>
                                    </div>
                                    <div className="col-md-3">
                                        <label htmlFor="amountPaid">
                                            Amount Paid
                                        </label>
                                        <input
                                            id="ap"
                                            className="form-control"
                                            name="ap"
                                            type="number"
                                            value={paidTotal}
                                            onChange={(event) =>
                                                setPaidTotal(
                                                    parseFloat(
                                                        event.target.value
                                                    )
                                                )
                                            }
                                        />
                                    </div>
                                    <div className="col-md-3">
                                        <label htmlFor="amountPaid">
                                            Amount to Return
                                        </label>
                                        <input
                                            id="atr"
                                            className="form-control"
                                            name="atr"
                                            value={parseFloat(
                                                returnAmount
                                            ).toFixed(2)}
                                            readOnly
                                            disabled
                                        />
                                    </div>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value={sendToPhone}
                                        checked={sendToPhone}
                                        onChange={handleSendToPhone}
                                        id="sendToPhoneCheck"
                                    />
                                    <label
                                        class="form-check-label"
                                        htmlFor="sendToPhoneCheck"
                                    >
                                        Send to phone
                                    </label>
                                </div>

                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        value={sendToMail}
                                        checked={sendToMail}
                                        onChange={handleSendToMail}
                                        id="sendToMailCheck"
                                    />
                                    <label
                                        class="form-check-label"
                                        htmlFor="sendToMailCheck"
                                    >
                                        Send to mail
                                    </label>
                                </div>
                            </div>
                            <div className="col-md-6">
                                <div className="h-100 d-flex flex-column justify-content-start">
                                    <h5
                                        className="modal-title text-start mb-2"
                                        id="paymentModalLabel"
                                    >
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
                                                    <tr className="table-info">
                                                        <td>
                                                            {
                                                                ticket?.product_name
                                                            }
                                                        </td>
                                                        <td>
                                                            {ticket?.price}
                                                            {" €"}
                                                        </td>
                                                        <td>1</td>
                                                        <td>
                                                            {grandTotal}
                                                            {" €"}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div className="card mt-auto">
                                        <table className="table mb-0">
                                            <tbody>
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
                                    (formData["vatNumber"]
                                        ? /* sendToMail ||
                                    sendToPhone ||
                                    sendInvoiceToMail */
                                          formData["email"] || formData["phone"]
                                            ? false
                                            : true
                                        : false) ||
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

export default ScannerPaidInviteModal;
