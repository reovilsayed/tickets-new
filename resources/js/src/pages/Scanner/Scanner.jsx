import React, { useEffect, useState } from "react";
import "./Scanner.css";
import axios from "axios";
import { useFetch } from "../../lib/hooks/useFetch";
import { Button, Form, InputGroup } from "react-bootstrap";
import QrScanner from "qr-scanner";

const Scanner = () => {
    const videoRef = React.useRef(null);
    const [scanner, setScanner] = useState(null);

    useEffect(() => {

        if (videoRef.current && !scanner) {
            const qrScanner = new QrScanner(
                videoRef.current,
                (result) => {
                    // console.log(result);
                    handleScan(result);
                },
                { highlightScanRegion: true, highlightCodeOutline: true }
            );
            setScanner(qrScanner);
        }
        return () => {
            if (scanner) {
                scanner.stop(); // Stop the scanner
                scanner.destroy(); // Destroy scanner instance
                setScanner(null); // Reset scanner to null
            }
        };
    }, [videoRef.current, scanner]);

    const handleStartScan = () => {
        if (scanner) {
            scanner.start();
            setStartScan(true);
        } else {
            console.error("Scanner is not initialized yet");
        }
    };

    const [startScan, setStartScan] = useState(false);
    const [scannedTicket, setScannedTicket] = useState(null);

    const handleScan = async (data) => {
        if (!data?.data) return;

        try {
            const response = await axios.post(
                `${import.meta.env.VITE_APP_URL}/api/tickets/get`,
                { ticket: data?.data }
            );
            setScannedTicket(response.data);
        } catch (error) {
            console.error("Error scanning ticket", error);
        }
    };

    const handleError = (error) => {
        console.error("QR Scan Error", error);
    };

    const handleExtraChange = (targetExtra, quantity) => {
        const targetExtraQuantity = parseInt(targetExtra?.qty) ?? 0;
        quantity = parseInt(quantity);
        if (quantity < targetExtraQuantity) return;
        targetExtra = { ...targetExtra, newQty: quantity };

        var ticketExtras = scannedTicket.extras.map((item) => {
            if (item.id === targetExtra.id) {
                return targetExtra;
            }
            return item;
        });
        setScannedTicket((prev) => {
            return { ...prev, extras: [...ticketExtras] };
        });
    };
    const {
        data: extrasList,
        isError,
        isLoading,
        isSuccess,
        refetch,
    } = useFetch(
        ["scanner-extras", scannedTicket],
        `${import.meta.env.VITE_APP_URL}/api/event-extras/${
            scannedTicket?.event_id
        }`
    );

    const [showNewExtraFields, setShowNewExtraFields] = useState(false);
    const [selectedNewExtra, setSelectedNewExtra] = useState(null);
    const [selectedNewExtraQuantity, setSelectedNewExtraQuantity] = useState(1);

    const handleAddExtra = () => {
        if (!showNewExtraFields) {
            setShowNewExtraFields(true);
            return;
        }
        const targetExtra = {
            ...selectedNewExtra,
            qty: 0,
            newQty: selectedNewExtraQuantity,
        };
        var isUniqueItem = true;

        var ticketExtras = scannedTicket?.extras?.map((item) => {
            if (item.id === targetExtra.id) {
                isUniqueItem = false;
                return {
                    ...item,
                    newQty:
                        targetExtra.newQty + (item?.newQty ?? item?.qty ?? 0),
                };
            }
            return item;
        });
        if (isUniqueItem) {
            ticketExtras = [...ticketExtras, targetExtra];
        }
        setScannedTicket((prev) => {
            return { ...prev, extras: [...ticketExtras] };
        });
        setShowNewExtraFields(false);
        setSelectedNewExtra(null);
        setSelectedNewExtraQuantity(1);
    };

    const [changesProcessing, setChangesProcessing] = useState(false);

    const submitChanges = async () => {
        setChangesProcessing(true);
        const response = await axios.post(
            `${import.meta.env.VITE_APP_URL}/api/update-ticket`,
            { ticket: scannedTicket },
            {
                headers: {
                    "Content-Type": "application/json",
                    "X-Secret-Key": "pos_password",
                },
            }
        );
        if (response.status == 200) {
            setScannedTicket(null);
            setStartScan(false);

            if (scanner) {
                scanner.stop(); // Stop the scanner first
                // scanner.destroy(); // Destroy the existing scanner instance
                const newScanner = new QrScanner(
                    videoRef.current,
                    (result) => {
                        console.log(result);
                        handleScan(result);
                    },
                    { highlightScanRegion: true, highlightCodeOutline: true }
                );
                setScanner(newScanner); // Set the new scanner instance
                newScanner.start(); // Start the new scanner
            }
        }
        setChangesProcessing(false);
    };

    return (
        <section className="scanner-page">
            {scannedTicket ? (
                <div className="ticket-info">
                    <h3>Ticket Information</h3>
                    <div className="ticket-details">
                        <p>
                            <strong>Owner:</strong> {scannedTicket?.owner.name}
                        </p>
                        <p>
                            <strong>Email:</strong> {scannedTicket?.owner.email}
                        </p>
                        <p>
                            <strong>VAT Number:</strong>{" "}
                            {scannedTicket?.owner.vatNumber}
                        </p>
                        <p>
                            <strong>Address:</strong>{" "}
                            {scannedTicket?.owner.address}
                        </p>
                        <p>
                            <strong>Event ID:</strong> {scannedTicket?.event_id}
                        </p>
                        <p>
                            <strong>Ticket ID:</strong> {scannedTicket?.ticket}
                        </p>
                        <p>
                            <strong>Price:</strong> ${scannedTicket?.price}
                        </p>
                        <p>
                            <strong>Status:</strong>{" "}
                            {scannedTicket?.status === 0 ? "Not Used" : "Used"}
                        </p>
                        <p>
                            <strong>Dates:</strong>{" "}
                            {scannedTicket?.dates.join(", ")}
                        </p>
                    </div>

                    {scannedTicket?.hasExtras ? (
                        <div className="extras">
                            <h4>Extras</h4>
                            <ul>
                                {scannedTicket?.extras.map((extra, index) => {
                                    const quantity = parseInt(
                                        extra?.newQty ?? extra?.qty ?? 0
                                    );
                                    const price = parseFloat(
                                        extra?.price ?? 0
                                    ).toFixed(2);
                                    return (
                                        <span
                                            key={index}
                                            className="d-flex justify-content-between align-items-center"
                                        >
                                            <span className="col-md-3 text-start">
                                                {extra?.name}
                                            </span>
                                            <div className="update-quantity d-flex align-items-center justify-content-center col-md-3">
                                                <button
                                                    className="btn btn-outline-danger btn-sm"
                                                    onClick={() =>
                                                        handleExtraChange(
                                                            extra,
                                                            quantity - 1
                                                        )
                                                    }
                                                >
                                                    -
                                                </button>
                                                <input
                                                    type="number"
                                                    value={quantity}
                                                    onChange={(e) =>
                                                        handleExtraChange(
                                                            extra,
                                                            e.target.value
                                                        )
                                                    }
                                                    className="form-control text-center mx-2 border-0"
                                                    style={{ width: "40px" }}
                                                />
                                                <button
                                                    className="btn btn-outline-dark btn-sm"
                                                    onClick={() =>
                                                        handleExtraChange(
                                                            extra,
                                                            quantity + 1
                                                        )
                                                    }
                                                >
                                                    +
                                                </button>
                                            </div>
                                            <span className="col-md-3 text-end">
                                                {"X "}
                                                {price}
                                                {"$ ="}
                                            </span>
                                            <span className="col-md-3 text-end">
                                                {price *
                                                    parseInt(
                                                        extra?.newQty
                                                            ? extra?.newQty -
                                                                  extra?.qty
                                                            : 0
                                                    )}
                                                $
                                            </span>
                                        </span>
                                    );
                                })}
                                {showNewExtraFields && (
                                    <div className="modal-body row">
                                        <div className="col-md-12">
                                            <div className="form-group">
                                                <label htmlFor="extraSelect">
                                                    Select Extra
                                                </label>
                                                <select
                                                    id="extraSelect"
                                                    className="form-control mt-2"
                                                    defaultValue={
                                                        selectedNewExtra?.display_name ??
                                                        "Select an extra"
                                                    }
                                                >
                                                    <option
                                                        onClick={() =>
                                                            setSelectedNewExtra(
                                                                null
                                                            )
                                                        }
                                                    >
                                                        None
                                                    </option>
                                                    {extrasList?.data?.map(
                                                        (extra, index) => (
                                                            <option
                                                                key={index}
                                                                onClick={() =>
                                                                    setSelectedNewExtra(
                                                                        extra
                                                                    )
                                                                }
                                                            >
                                                                {
                                                                    extra?.display_name
                                                                }
                                                            </option>
                                                        )
                                                    )}
                                                </select>
                                            </div>

                                            {selectedNewExtra ? (
                                                <>
                                                    <div className="form-group mt-3 d-flex flex-column justify-content-center align-items-center">
                                                        <label htmlFor="quantity">
                                                            Quantity
                                                        </label>
                                                        <InputGroup className="w-50">
                                                            <Button
                                                                variant="outline-secondary"
                                                                onClick={() =>
                                                                    setSelectedNewExtraQuantity(
                                                                        (
                                                                            prev
                                                                        ) =>
                                                                            prev -
                                                                                1 >
                                                                            0
                                                                                ? prev -
                                                                                  1
                                                                                : prev
                                                                    )
                                                                }
                                                            >
                                                                -
                                                            </Button>
                                                            <Form.Control
                                                                aria-label="Example text with two button addons"
                                                                className="text-center"
                                                                readOnly
                                                                value={
                                                                    selectedNewExtraQuantity
                                                                }
                                                            />
                                                            <Button
                                                                variant="outline-danger"
                                                                onClick={() =>
                                                                    setSelectedNewExtraQuantity(
                                                                        (
                                                                            prev
                                                                        ) =>
                                                                            prev +
                                                                            1
                                                                    )
                                                                }
                                                            >
                                                                +
                                                            </Button>
                                                        </InputGroup>
                                                    </div>
                                                    <label htmlFor="price">
                                                        Price
                                                        <br />
                                                        {selectedNewExtra?.price *
                                                            selectedNewExtraQuantity}
                                                        $
                                                    </label>
                                                </>
                                            ) : (
                                                ""
                                            )}
                                        </div>
                                    </div>
                                )}
                            </ul>
                        </div>
                    ) : null}
                    <span className="d-flex justify-content-center align-items-center mt-2">
                        <button
                            type="button"
                            class="btn btn-info text-light w-100 py-1"
                            onClick={handleAddExtra}
                        >
                            Add extra
                        </button>
                    </span>
                    <span className="d-flex justify-content-center align-items-center mt-2">
                        <button
                            type="button"
                            class="btn btn-success text-light w-100 py-1"
                            onClick={submitChanges}
                        >
                            {changesProcessing
                                ? "Processing..."
                                : "Save Changes"}
                        </button>
                    </span>
                </div>
            ) : !startScan ? (
                <div className="qr-box flex-column" onClick={handleStartScan}>
                    <img
                        className="qr-image"
                        src="/assets/qr-code.png"
                        alt="QR Code"
                    />
                    <h3>Tap to start scanning</h3>
                </div>
            ) : (
                ""
            )}
            {!scannedTicket && (
                <div
                    id="viewfinder"
                    className="qr-box"
                    style={!startScan ? { display: "none" } : {}}
                >
                    <video ref={videoRef}>
                        Your browser does not support video playback.
                    </video>
                </div>
            )}
        </section>
    );
};

export default Scanner;
