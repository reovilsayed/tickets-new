import React from "react";
import "./BillModal.css";

function BillModal({ handleClose, order }) {
    console.log(order);

    const printDiv = (divId) => {
        const content = document.getElementById(divId).innerHTML;
        const printWindow = window.open("", "_blank");
        printWindow.document.open();
        printWindow.document.close();
        printWindow.document.body.innerHTML = content;
        printWindow.print();
    };

    return (
        <>
            {order && <div className="modal-backdrop fade-in"></div>}
            <div
                className={`modal ${order ? "fade-in show" : "fade-out"}`}
                id="billModal"
                tabIndex="-1"
                aria-labelledby="billModalLabel"
                aria-hidden={!order}
                onClick={handleClose}
            >
                <div
                    className="modal-dialog modal-center modal-lg"
                    onClick={(e) => e.stopPropagation()}
                >
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5
                                className="modal-title text-center"
                                id="billModalLabel"
                            >
                                Bill
                            </h5>
                            <button
                                type="button"
                                className="btn-close"
                                aria-label="Close"
                                onClick={handleClose}
                            ></button>
                        </div>
                        <div className="modal-body row">
                            <button
                                onClick={() => printDiv("printableArea")}
                                className="btn btn-dark me-1 mb-3 no-print"
                            >
                                <i className="fas fa-print me-2"></i>Print
                            </button>

                            <div className="receipt" id="printableArea">
                                {order?.pos_user?.pos?.name && (
                                    <div>
                                        POS NAME:{" "}
                                        {order?.pos_user?.pos?.name || ""}
                                    </div>
                                )}
                                {order?.billing?.name && (
                                    <div>
                                        USER NAME: {order?.billing?.name || ""}
                                    </div>
                                )}
                                {order?.billing?.phone && (
                                    <div>
                                        USER PHONE:{" "}
                                        {order?.billing?.phone || ""}
                                    </div>
                                )}
                                <hr />
                                <div className="bold">Order details</div>
                                <div>Order id: {order?.id}</div>
                                <hr />
                                <table>
                                    <thead>
                                        <tr>
                                            <th className="text-center">
                                                Name
                                            </th>
                                            <th>Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {order?.items?.map((product, index) => (
                                            <tr>
                                                <td>{product.name}</td>
                                                <td>{product.qty}</td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                                <hr />
                                <div className="right bold">
                                    Total: {order?.total}€
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

export default BillModal;
