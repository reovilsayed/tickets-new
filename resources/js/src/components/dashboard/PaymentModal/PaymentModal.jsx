import React, { useEffect, useMemo, useState } from "react";
import "./PaymentModal.css";
import { useDispatch, useSelector } from "react-redux";
import { close } from "../../../lib/features/paymentModalSlice";
import { useCart } from "react-use-cart";
import axios from "axios";
import CartInfo from "./CartInfo/CartInfo";
import { Dropdown, DropdownButton, InputGroup } from "react-bootstrap";
import { useNavigate } from "react-router-dom";
import PhoneNumberInput from "./PhoneNumberInput";
import { useFetch } from "../../../lib/hooks/useFetch";
import { toast } from "react-toastify";
import { calculateExtrasFeesForTotalCart } from "../../../lib/utils";

const PaymentModal = ({ open }) => {
    const { items, cartTotal, isEmpty: cartIsEmpty, emptyCart } = useCart();

    const [formData, setFormData] = useState({
        name: "",
        email: "",
        vatNumber: "",
        discount: 0.0,
        paymentMethod: "Cash",
    });
    const handleFormData = (event) => {
        const { name, value } = event.target;
        setFormData((prev) => {
            return { ...prev, [name]: value };
        });
    };

    const [sendToPhone, setSendToPhone] = useState(true);
    const [sendToMail, setSendToMail] = useState(false);
    const [withdraw, setWithdraw] = useState(false);
    const [physicalQr, setPhysicalQr] = useState(false);
    const [sendInvoiceToMail, setSendInvoiceToMail] = useState(false);
    const [printInvoice, setPrintInvoice] = useState(false);

    const totalExtrasFees = useMemo(
        () => calculateExtrasFeesForTotalCart(items),
        [items]
    );
    const grandTotal = useMemo(
        () => cartTotal + totalExtrasFees - parseFloat(formData["discount"]),
        [cartTotal, totalExtrasFees, formData]
    );
    const [paidTotal, setPaidTotal] = useState(0.0);
    const returnAmount = useMemo(
        () =>
            paidTotal > grandTotal ? parseFloat(paidTotal - grandTotal) : 0.0,
        [grandTotal, paidTotal]
    );

    const [orderRequestProcessing, setOrderRequestProcessing] = useState(false);

    const { data: withdrawData } = useFetch(
        ["withdraw_checked"],
        `${import.meta.env.VITE_APP_URL}/api/withdraw_checked`
    );

    useEffect(() => {
        setWithdraw(withdrawData?.checked);
    }, [withdrawData]);
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

    const navigate = useNavigate();
    const filterEvent = useSelector((state) => state.filter.event);

    const submitOrder = async () => {
        if (!filterEvent?.id) {
            toast("No event was selected!");
            return;
        }
        setOrderRequestProcessing(true);
        const orderData = {
            event_id: filterEvent.id,
            biling: formData,
            tickets: items.filter((item) => item.isTicket),
            extras: items.filter((item) => !item.isTicket),
            discount: formData["discount"],
            paymentMethod: formData["paymentMethod"],
            subTotal: cartTotal,
            total: cartTotal,
            sendToMail,
            sendToPhone,
            withdraw,
            physicalQr,
            printInvoice,
            sendInvoiceToMail,
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
                phone: "",
                vatNumber: "",
                discount: 0.0,
                paymentMethod: "Cash",
            });
            if (printInvoice && response?.data?.invoice_url) {
                window.open(response?.data?.invoice_url, "_blank");
                setPrintInvoice(false);
            }
            if (physicalQr) {
                navigate(
                    `/pos/physical-qr?tickets=${response?.data?.tickets
                        ?.map((item) => item?.id)
                        ?.join(",")}`
                );
                setPhysicalQr(false);
            }
            setSendToMail(true);
            setSendToPhone(false);
            setSendInvoiceToMail(false);
            emptyCart("");
            handleClose();
        }
        setOrderRequestProcessing(false);
    };

    const handleSendToMail = () => {
        setSendToMail((prev) => {
            if (prev) return false;

            setPhysicalQr(false);
            return true;
        });
    };
    const handleSendToPhone = () => {
        setSendToPhone((prev) => {
            if (prev) return false;

            setPhysicalQr(false);
            return true;
        });
    };

    const handlePhysicalQr = () => {
        setPhysicalQr((prev) => {
            if (prev) return false;
            setSendToMail(false);
            return true;
        });
    };
    const handleSetWithdraw = () => {
        setWithdraw(!withdraw);
    };

    const handleSendInvoice = () => {
        setSendInvoiceToMail((prev) => {
            if (prev) return false;
            setPrintInvoice(false);
            return true;
        });
    };

    const handlePrintInvoice = () => {
        setPrintInvoice((prev) => {
            if (prev) return false;
            setSendInvoiceToMail(false);
            return true;
        });
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
                                    <label htmlFor="emailInput">
                                        Email{" "}
                                        {formData["vatNumber"] ||
                                        sendToMail ||
                                        sendInvoiceToMail
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
                                    <div className="col-md-3">
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
                                    {formData["paymentMethod"] === "Cash" ? (
                                        <>
                                            <div className="col-md-3">
                                                <label htmlFor="amountToPay">
                                                    Amount to Pay
                                                </label>
                                                <input
                                                    id="atp"
                                                    className="form-control"
                                                    name="atp"
                                                    value={parseFloat(
                                                        grandTotal
                                                    ).toFixed(2)}
                                                    readOnly
                                                    disabled
                                                />
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
                                                                event.target
                                                                    .value
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
                                        </>
                                    ) : (
                                        ""
                                    )}
                                    {/* <div className="col-md-8">
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
                                            placeholder="Enter discount"
                                        />
                                    </div> */}
                                </div>
                                <div className="row">
                                    <div className="col-md-6">
                                        <label
                                            class="form-check-label"
                                            htmlFor="ticket-check"
                                        >
                                            Ticket
                                        </label>
                                        <div class="form-check">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                value={withdraw}
                                                checked={withdraw}
                                                onChange={handleSetWithdraw}
                                                id="Withdraw"
                                            />
                                            <label
                                                class="form-check-label"
                                                htmlFor="Withdraw"
                                            >
                                                Withdraw
                                            </label>
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

                                        {items.filter((item) => item.isTicket)
                                            .length > 0 && (
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    value={physicalQr}
                                                    checked={physicalQr}
                                                    onChange={handlePhysicalQr}
                                                    id="printTicketCheck"
                                                />
                                                <label
                                                    class="form-check-label"
                                                    htmlFor="printTicketCheck"
                                                >
                                                    Physical QR Code
                                                </label>
                                            </div>
                                        )}
                                    </div>
                                    {physicalQr && (
                                        <div className="col-md-6">
                                            <label
                                                class="form-check-label"
                                                htmlFor="invoice-check"
                                            >
                                                Invoice
                                            </label>
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    value={sendInvoiceToMail}
                                                    checked={sendInvoiceToMail}
                                                    onChange={handleSendInvoice}
                                                    id="sendInvoiceToMailCheck"
                                                />
                                                <label
                                                    class="form-check-label"
                                                    htmlFor="sendInvoiceToMailCheck"
                                                >
                                                    Send to mail
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    value={printInvoice}
                                                    checked={printInvoice}
                                                    onChange={
                                                        handlePrintInvoice
                                                    }
                                                    id="printInvoiceCheck"
                                                />
                                                <label
                                                    class="form-check-label"
                                                    htmlFor="printInvoiceCheck"
                                                >
                                                    Print Invoice
                                                </label>
                                            </div>
                                        </div>
                                    )}
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
                                    (formData["vatNumber"] ||
                                    sendToMail ||
                                    sendToPhone ||
                                    sendInvoiceToMail
                                        ? formData["email"] || formData["phone"]
                                            ? false
                                            : true
                                        : false) ||
                                    orderRequestProcessing ||
                                    cartIsEmpty
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
