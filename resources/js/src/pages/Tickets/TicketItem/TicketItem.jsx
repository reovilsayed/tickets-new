import React from "react";
import "./TicketItem.css";
import { formatDateRange, formatPrice, verifyImage } from "../../../lib/utils";
import { useDispatch } from "react-redux";
import { open } from "../../../lib/features/itemInfoModalSlice";
import { useCart } from "react-use-cart";

const TicketItem = ({ ticket }) => {
    const dispatch = useDispatch();
    const openInfoModal = (event) => {
        event.stopPropagation();
        dispatch(open(ticket));
    };
    const { addItem, removeItem, inCart } = useCart();
    const active = inCart(ticket?.id);

    return (
        <div
            className={`ticket-item-container col-lg-2 col-md-3 col-sm-3 col-6 my-hover-effect g-3 ${
                active ? "active" : ""
            }`}
            onClick={() => addItem({ ...ticket, isTicket: true })}
        >
            <div className="ticket-item-card">
                {active ? (
                    <button
                        className="delete-btn"
                        onClick={() => {
                            removeItem(ticket.id);
                        }}
                    >
                        <i className="fa fa-times"></i>
                    </button>
                ) : (
                    ""
                )}
                <div className="custom-card">
                    <span className="ticket-item-badge">
                        {formatPrice(
                            ticket?.sale_price
                                ? ticket?.sale_price
                                : ticket?.price
                        )}
                    </span>

                    <div className="card-header position-relative">
                        <img
                            className="ticket-item-img"
                            src={verifyImage(ticket?.event_thumbnail)}
                        />
                        {ticket?.event?.name && (
                            <span className="ticket-item-unit">
                                {ticket?.event?.name.length > 15
                                    ? `${ticket.event.name.substring(0, 15)}...`
                                    : ticket?.event?.name}
                            </span>
                        )}
                    </div>

                    <div className="card-body ticket-item-body">
                        <p title={ticket.name} className="ticket-item-name">
                            {ticket?.name.length > 15
                                ? `${ticket.name.substring(0, 15)}...`
                                : ticket.name}
                        </p>

                        <small className="ticket-item-generic">
                            {ticket?.event?.organizer?.length > 25
                                ? `${ticket.event.organizer.substring(
                                      0,
                                      25
                                  )}...`
                                : ticket?.event.organizer}
                        </small>
                        {ticket?.start_date && ticket?.end_date && (
                            <small>
                                (
                                {formatDateRange(
                                    ticket.start_date,
                                    ticket.end_date
                                )}
                                )
                            </small>
                        )}
                        <button
                            onClick={openInfoModal}
                            className="btn btn-primary btn-sm position-absolute rounded-circle ticket-item-info-btn"
                        >
                            <i className="fa fa-info"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default TicketItem;
