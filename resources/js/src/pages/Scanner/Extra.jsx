import React, { useState } from "react";

const Extra = ({ extra, index, handleExtraChange }) => {
    const [withdrawQty, setWithdrawQty] = useState(0);

    const quantity = parseInt(extra?.newQty ?? 0) || parseInt(extra?.qty ?? 0);
    const price = parseFloat(extra?.price ?? 0).toFixed(2);

    const handleInputChange = (e) => {
        const value = parseInt(e.target.value) || 0;
        setWithdrawQty(value);
    };

    const handleWithdraw = () => {

        if (withdrawQty > 0 && withdrawQty <= extra.qty - extra.used) {

            handleExtraChange(extra, withdrawQty);
            setWithdrawQty(0); // Reset input after withdrawal
        }
    };

    return (
        <div className="card" key={index}>
            <div className="card-body text-start">
                <div className="d-flex justify-content-between align-items-center">
                    <p className="h6">
                        {extra?.display_name ?? extra?.name} X { extra?.qty - extra?.used}
                    </p>
                    <h6>
                        €{" "}
                        {(price *
                            parseInt(extra?.newQty ? extra?.newQty - extra?.qty : 0)).toFixed(2)}
                    </h6>
                </div>
                <div className="mt-3">
                    <label htmlFor="">
                        Withdraw (Available: {extra?.qty  - extra?.used })
                    </label>
                    <div className="form-inline d-flex gap-2">
                        <input
                            type="number"
                            min={1}
                            max={extra?.qty - extra?.used}
                            value={withdrawQty}
                            onChange={handleInputChange}
                            className="form-control"
                        />
                        <button className="btn btn-sm btn-dark" onClick={handleWithdraw}>
                            <i className="fa fa-check"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Extra;
