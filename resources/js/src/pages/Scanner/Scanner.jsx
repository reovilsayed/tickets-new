import React from "react";
import "./Scanner.css";

const Scanner = () => {
    return (
        <section className="scanner-page">
            {false && (
                <div className="scanner-header">
                    <h4 className="event-name">{"event.name"}</h4>
                    <h4 className="door-name">{"zone.name"}</h4>
                    <button className="add-new-session" onClick={() => {}}>
                        Add new session
                    </button>
                    <div className="form-group">
                        <select
                            className="form-control text-center"
                            name="mode"
                            id="mode"
                        >
                            <option>{"option.label"}</option>
                        </select>
                    </div>
                </div>
            )}
            <div className="scanner-inner">
                <div className="qr-box">
                    <img
                        className="qr-image"
                        src="/assets/qr-code.png"
                        alt="QR Code"
                    />
                    <h3>Tap to read code</h3>
                </div>

                <div id="viewfinder" className="qr-box">
                    <div id="video-container">
                        <video id="qr-video"></video>
                    </div>
                </div>
            </div>
        </section>
    );
};

export default Scanner;
