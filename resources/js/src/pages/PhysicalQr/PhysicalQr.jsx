import React, { useEffect, useState, useRef } from "react";
import "../Scanner/Scanner.css";
import axios from "axios";
import { toast } from "react-toastify";
import QrScanner from "qr-scanner";
import { useSearchParams } from "react-router-dom";

const PhysicalQr = () => {
    const [searchParams] = useSearchParams();
    const tickets = searchParams.get("tickets");

    const [unscannedTickets, setUnscannedTickets] = useState(
        tickets?.split(",") ?? []
    );
    const ticketsToScan = tickets?.split(",")?.length;

    const videoRef = useRef(null);
    const [scanner, setScanner] = useState(null);
    const [startScan, setStartScan] = useState(false);
    const [scanViaQr, setscanViaQr] = useState(false);
    const [enterManual, setEnterManual] = useState(false);
    const [scannedTicket, setScannedTicket] = useState(0);
    const [isProcessing, setIsProcessing] = useState(false); 
    const [manualCode, setManualCode] = useState(""); 

    useEffect(() => {
        if (videoRef.current && !scanner) {
            const qrScanner = new QrScanner(
                videoRef.current,
                (result) => {
                    if (!isProcessing) {
                        handleScan(result);
                    }
                },
                { highlightScanRegion: true, highlightCodeOutline: true }
            );
            setScanner(qrScanner);
        }

        return () => {
            if (scanner) {
                scanner.stop();
                scanner.destroy();
                setScanner(null);
            }
        };
    }, [videoRef, scanner, isProcessing]); // Ensure isProcessing is included as a dependency

    const handleStartScan = () => {
        if (scanner) {
            setStartScan(true); // Start scan
            setscanViaQr(true); // Start scan
            scanner.start();
        } else {
            console.error("Scanner is not initialized yet");
        }
    };

    const handleStartManual = () => {
        setStartScan(true); // Start scan
        setEnterManual(true); // Start scan
    };

    const handleScan = async (data) => {
        const ticketToUpdate = unscannedTickets[unscannedTickets.length - 1];

        if (!data?.data || !ticketToUpdate) return;

        // Stop scanner immediately and block further requests
        setStartScan(false);
        setscanViaQr(false);
        setIsProcessing(true); // Block further scans

        if (scanner) {
            scanner.stop(); // Stop the scanner after scanning a ticket
        }

        try {
            await axios.post(
                `${import.meta.env.VITE_APP_URL}/api/tickets/update-code`,
                { ticket: ticketToUpdate, code: data?.data }
            );

            setUnscannedTickets((prev) => {
                const updatedTickets = [...prev];
                updatedTickets.pop();
                return updatedTickets;
            });

            setScannedTicket((prev) => prev + 1);
        } catch (error) {
            toast.error("Error scanning ticket");
        } finally {
            setIsProcessing(false); // Allow next scan after processing
        }
    };

    const handleManualSubmit = async () => {
        const ticketToUpdate = unscannedTickets[unscannedTickets.length - 1];
        if (!manualCode || !ticketToUpdate) return;
        setEnterManual(false)
        setStartScan(false)
        setIsProcessing(true); // Block further submissions

        try {
            await axios.post(
                `${import.meta.env.VITE_APP_URL}/api/tickets/update-code`,
                { ticket: ticketToUpdate, code: manualCode }
            );

            setUnscannedTickets((prev) => {
                const updatedTickets = [...prev];
                updatedTickets.pop();
                return updatedTickets;
            });

            setScannedTicket((prev) => prev + 1);
            setManualCode(""); // Reset the manual input
        } catch (error) {
            toast.error("Error updating ticket manually");
        } finally {
            setIsProcessing(false); // Allow next manual submission after processing
        }
    };

    const handleManualKeyPress = (e) => {
        if (e.key === "Enter") {
            handleManualSubmit();
        }
    };

    return (
        <section
            className="scanner-page"
            style={{ display: "flex", flexDirection: "column" }}
        >
            <h3>
                {scannedTicket} / {ticketsToScan} tickets processed
            </h3>
            {!startScan ? (
                unscannedTickets?.length ? (
                    <div className="d-flex gap-3">
                        <div
                            className="qr-box flex-column"
                            onClick={handleStartScan}
                        >
                            <img
                                className="qr-image"
                                src="/assets/qr-code.png"
                                alt="QR Code"
                            />
                            <h3>
                                start scanning
                                {scannedTicket > 0 ? " next" : ""}
                            </h3>
                        </div>
                        <div
                            className="qr-box flex-column"
                            onClick={handleStartManual}
                        >
                            <img
                                className="qr-image"
                                src="/assets/keyboard.svg"
                                alt="keyboard"
                            />
                            <h3>
                                Enter manually
                                {scannedTicket > 0 ? " next" : ""}
                            </h3>
                        </div>
                    </div>

                ) : (
                    <a href="/pos/tickets" className="qr-box flex-column">
                        <h3
                            style={{
                                textTransform: "capitalize",
                                textAlign: "center",
                            }}
                        >
                            All tickets are done scanning
                            <br />
                            <br />
                            Go back to tickets
                        </h3>
                    </a>
                )
            ) : (
                ""
            )}
            <div
                id="viewfinder"
                className="qr-box"
                style={!scanViaQr ? { display: "none" } : {}}
            >
                <video ref={videoRef}>
                    Your browser does not support video playback.
                </video>
            </div>
            <div
                id="manual-input"
                className="form-group"
                style={!enterManual ? { display: "none" } : {}}
            >
                <input
                    type="text"
                    name="manual"
                    className="form-control"
                    id="manual"
                    value={manualCode}
                    onChange={(e) => setManualCode(e.target.value)}
                    onKeyDown={handleManualKeyPress}
                    placeholder="Enter ticket code manually"
                />
            </div>
        </section>
    );
};

export default PhysicalQr;
