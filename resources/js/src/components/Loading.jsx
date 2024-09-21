import React from "react";
import { HashLoader } from "react-spinners";

function Loading() {
    return (
        <div
            style={{
                height: "100vh",
                width: "100vw",
                display: "flex",
                justifyContent: "center",
                alignItems: "center",
            }}
        >
            <HashLoader color="#36d7b7" />
        </div>
    );
}

export default Loading;
