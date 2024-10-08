import React from "react";
import "./ExtraItem.css";
import { formatDateRange, formatPrice } from "../../../lib/utils";
import { useDispatch } from "react-redux";
import { open } from "../../../lib/features/itemInfoModalSlice";
import { useCart } from "react-use-cart";

const ExtraItem = ({ extra }) => {
    const dispatch = useDispatch();
    const openInfoModal = () => {
        dispatch(open(extra));
    };

    const { addItem, removeItem, inCart } = useCart();
    const active = inCart(extra?.id);

    return (
        <div
            className={`ticket-item-container col-lg-2 col-md-3 col-sm-3 col-6 my-hover-effect g-3 ${
                active ? "active" : ""
            }`}
            onClick={() => addItem(extra)}
        >
            <div className="extra-item-card">
                {active ? (
                    <button
                        className="delete-btn"
                        onClick={() => {
                            removeItem(extra.id);
                        }}
                    >
                        <i className="fa fa-times"></i>
                    </button>
                ) : (
                    ""
                )}
                <div className="custom-card">
                    <span className="extra-item-badge">
                        {formatPrice(
                            extra?.sale_price ? extra?.sale_price : extra?.price
                        )}
                        €
                    </span>

                    <div className="card-header position-relative">
                        <img
                            className="extra-item-img"
                            src={
                                extra?.image
                                    ? extra?.image
                                    : "/images/no-image.jpg"
                            }
                            alt={extra.display_name}
                        />
                        {extra?.event?.name && (
                            <span className="extra-item-unit">
                                {extra?.event?.name.length > 15
                                    ? `${extra.event.name.substring(0, 15)}...`
                                    : extra?.event?.name}
                            </span>
                        )}
                    </div>

                    <div className="card-body extra-item-body">
                        <p
                            title={extra.display_name}
                            className="extra-item-name"
                        >
                            {extra?.display_name.length > 15
                                ? `${extra.display_name.substring(0, 15)}...`
                                : extra.display_name}
                        </p>
                        <button
                            onClick={openInfoModal}
                            className="btn btn-primary btn-sm position-absolute rounded-circle extra-item-info-btn"
                        >
                            <i className="fa fa-info"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default ExtraItem;
