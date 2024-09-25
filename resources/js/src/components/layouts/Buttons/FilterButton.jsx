import React from "react";

function FilterButton({ onClick }) {
    return (
        <div onClick={onClick}>
            <button
                type="button"
                className="btn btn-info text-light btn-lg position-fixed"
                style={{ bottom: "20px", right: "100px", zIndex: 100 }}
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasExample"
                aria-controls="offcanvasExample"
            >
                <i className="fa fa-filter"></i>
            </button>
        </div>
    );
}

export default FilterButton;
