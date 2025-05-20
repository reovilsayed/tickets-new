import React from "react";
import "./BillModal.css";

function BillModal({ handleClose, order }) {
    console.log(order);

    const printDiv = (divId) => {
        const content = document.getElementById(divId).innerHTML;
        const printWindow = window.open("", "_blank");
        printWindow.document.open();
        printWindow.document.write(`
        <html>
            <head>
                <title>Print</title>
                <style>
                    body {
                        margin: 0;
                        padding: 0;
                        font-family: "Courier New", monospace;
                        font-size: 10pt;
                        line-height: 1.3;
                    }

                    .receipt {
                        width: 100%;
                        font-family: monospace;
                    }

                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }

                    th,
                    td {
                        text-align: left;
                        padding: 2px 0;
                        font-size: 10pt;
                        white-space: nowrap;
                    }

                    hr {
                        border: none;
                        border-top: 1px dashed #000;
                        margin: 4px 0;
                    }

                    .center {
                        text-align: center;
                    }

                    .right {
                        text-align: right;
                    }

                    .bold {
                        font-weight: bold;
                    }

                    #printableArea {
                        width: 3in;
                        height: 5in;
                        background-color: red; /* For debugging layout */
                    }

                    @media print {
                        @page {
                            size: 3in 5in;
                            margin: 0;
                        }

                        body {
                            margin: 0;
                            padding: 0.2in;
                        }
                    }
                </style>
            </head>
            <body>
                ${content}
            </body>
        </html>
    `);
        printWindow.document.close();

        // Delay to ensure styles load
        setTimeout(() => {
            printWindow.focus();
            printWindow.print();
        }, 500);
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
                            <div
                                className="receipt"
                                id="printableArea"
                                style={{
                                    width: "80mm",
                                    height: "80mm",
                                    margin: "0 auto",
                                    padding: 0,
                                    fontSize: "10pt",
                                    background: "#fff",
                                    color: "#000",
                                    boxSizing: "border-box",
                                    whiteSpace: "nowrap",
                                }}
                            >
                                {order?.pos_user?.pos?.name && (
                                    <div
                                        style={{ margin: "10px 0", padding: 0 }}
                                    >
                                        POS NAME:{" "}
                                        {order?.pos_user?.pos?.name || ""}
                                    </div>
                                )}
                                {order?.billing?.name && (
                                    <div
                                        style={{ margin: "10px 0", padding: 0 }}
                                    >
                                        USER NAME: {order?.billing?.name || ""}
                                    </div>
                                )}
                                {order?.billing?.phone && (
                                    <div
                                        style={{ margin: "10px 0", padding: 0 }}
                                    >
                                        USER PHONE:{" "}
                                        {order?.billing?.phone || ""}
                                    </div>
                                )}
                                <hr
                                    style={{
                                        border: "none",
                                        borderTop: "1px dashed #000",
                                        margin: "4px 0",
                                    }}
                                />
                                <div
                                    style={{
                                        fontWeight: "bold",
                                        margin: 0,
                                        padding: 0,
                                    }}
                                >
                                    Order details
                                </div>
                                <div style={{ margin: 0, padding: 0 }}>
                                    Order id: {order?.id}
                                </div>
                                <hr
                                    style={{
                                        border: "none",
                                        borderTop: "1px dashed #000",
                                        margin: "4px 0",
                                    }}
                                />
                                <table
                                    style={{
                                        width: "100%",
                                        borderCollapse: "collapse",
                                        margin: 0,
                                        padding: 0,
                                    }}
                                >
                                    <thead>
                                        <tr>
                                            <th
                                                style={{
                                                    textAlign: "center",
                                                    padding: "2px 0",
                                                    fontSize: "10pt",
                                                    whiteSpace: "nowrap",
                                                    fontWeight: "bold",
                                                }}
                                            >
                                                Name
                                            </th>
                                            <th
                                                style={{
                                                    textAlign: "left",
                                                    padding: "2px 0",
                                                    fontSize: "10pt",
                                                    whiteSpace: "nowrap",
                                                    fontWeight: "bold",
                                                }}
                                            >
                                                Qty
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        {order?.items?.map((product, index) => (
                                            <tr key={index}>
                                                <td
                                                    style={{
                                                        textAlign: "left",
                                                        padding: "2px 0",
                                                        fontSize: "10pt",
                                                        whiteSpace: "nowrap",
                                                    }}
                                                >
                                                    {product.name}
                                                </td>
                                                <td
                                                    style={{
                                                        textAlign: "left",
                                                        padding: "2px 0",
                                                        fontSize: "10pt",
                                                        whiteSpace: "nowrap",
                                                    }}
                                                >
                                                    {product.qty}
                                                </td>
                                            </tr>
                                        ))}
                                    </tbody>
                                </table>
                                <hr
                                    style={{
                                        border: "none",
                                        borderTop: "1px dashed #000",
                                        margin: "4px 0",
                                    }}
                                />
                                <div
                                    style={{
                                        textAlign: "right",
                                        fontWeight: "bold",
                                        margin: 0,
                                        padding: 0,
                                    }}
                                >
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
