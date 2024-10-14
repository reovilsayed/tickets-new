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
    const [scannedTicket, setScannedTicket] = useState(0);
    const [isProcessing, setIsProcessing] = useState(false); // Prevent multiple requests

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
            scanner.start();
        } else {
            console.error("Scanner is not initialized yet");
        }
    };

    const handleScan = async (data) => {
        const ticketToUpdate = unscannedTickets[unscannedTickets.length - 1];

        if (!data?.data || !ticketToUpdate) return;

        // Stop scanner immediately and block further requests
        setStartScan(false);
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

    return (
        <section className="scanner-page">
            <h3>
                {scannedTicket} / {ticketsToScan} tickets scanned
            </h3>
            {!startScan ? (
                unscannedTickets?.length ? (
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
                            Tap to start scanning
                            {scannedTicket > 0 ? " next" : ""}
                        </h3>
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
                style={!startScan ? { display: "none" } : {}}
            >
                <video ref={videoRef}>
                    Your browser does not support video playback.
                </video>
            </div>
        </section>
    );
};

export default PhysicalQr;
