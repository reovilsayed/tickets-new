import React, { useEffect } from "react";
import { useSelector, useDispatch } from "react-redux";
import { close } from "../../../lib/features/itemInfoModalSlice";
import "./InfoModal.css";
import { formatDateRange, formatPrice, verifyImage } from "../../../lib/utils";

function InfoModal() {
    const dispatch = useDispatch();
    const item = useSelector((state) => state.itemInfoModal.item);
    const open = useSelector((state) => state.itemInfoModal.open);

    const handleClose = () => {
        dispatch(close());
    };

    useEffect(() => {
        const modalElement = document.getElementById("productDetails");

        if (open) {
            modalElement.classList.add("show", "fade-in");
            modalElement.style.display = "block";
        } else {
            modalElement.classList.remove("fade-in");
            modalElement.classList.add("fade-out");
            setTimeout(() => {
                modalElement.style.display = "none";
                modalElement.classList.remove("show", "fade-out");
            }, 300);
        }
    }, [open]);

    return (
        <>
            {item && open && <div className="modal-backdrop fade-in"></div>}
            <div
                className={`modal ${open ? "fade-in" : "fade-out"}`}
                id="productDetails"
                tabIndex="-1"
                aria-labelledby="productDetailsLabel"
                aria-hidden={!open}
                onClick={handleClose}
            >
                <div
                    className="modal-dialog modal-center modal-lg"
                    onClick={(e) => e.stopPropagation()}
                >
                    <div className="modal-content event-details">
                        <div className="modal-header">
                            <h5
                                className="modal-title text-center"
                                id="productDetailsLabel"
                            >
                                {item?.name}
                            </h5>
                            <button
                                type="button"
                                className="btn-close"
                                aria-label="Close"
                                onClick={handleClose}
                            ></button>
                        </div>
                        <div className="modal-body row">
                            <div className="col-md-6">
                                <div className="event_img text-center mb-3">
                                    <img
                                        src={verifyImage(item?.event_thumbnail)}
                                        alt={item?.name}
                                        className="img-fluid"
                                    />
                                </div>
                                <h4 className="events-title text-secondary text-left mb-2">
                                    {formatPrice(
                                        item?.sale_price
                                            ? item?.sale_price
                                            : item?.price
                                    )}
                                    €
                                </h4>
                            </div>
                            <div className="col-md-6">
                                <h5 className="events-title text-left mb-4">
                                    {item?.event?.name}
                                </h5>

                                <div className="accordins">
                                    <div className="accordin-item d-flex align-items-start mb-3">
                                        <div className="me-3">
                                            <i className="fa fa-calendar fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5>Event time</h5>
                                            <h6>
                                                {formatDateRange(
                                                    item?.start_date,
                                                    item.end_date
                                                )}
                                            </h6>
                                        </div>
                                    </div>

                                    <div className="accordin-item d-flex align-items-start mb-3">
                                        <div className="me-3">
                                            <i class="fas fa-map-marker-alt fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5>Event at</h5>
                                            <h6>{item?.event?.location}</h6>
                                        </div>
                                    </div>

                                    <div className="accordin-item d-flex align-items-start mb-3">
                                        <div className="me-3">
                                            <i className="fa fa-info-circle fa-2x"></i>
                                        </div>
                                        <div>
                                            <h5>Description</h5>

                                            <h6
                                                dangerouslySetInnerHTML={{
                                                    __html:
                                                        item?.description || "",
                                                }}
                                            />
                                        </div>
                                    </div>

                                    <div className="accordin-item d-flex align-items-start mb-3">
                                        <div className="me-3">
                                            <i class="fas fa-cocktail fa-2x"></i>
                                        </div>
                                        <div className="w-100">
                                            <h5>
                                                {item?.extras?.length
                                                    ? "Extras"
                                                    : "No extras"}
                                            </h5>
                                            {item?.extras?.length ? (
                                                <ul className="list-group">
                                                    {item.extras.map(
                                                        (extra, index) => (
                                                            <li
                                                                key={index}
                                                                className="list-group-item d-flex justify-content-between align-items-start"
                                                            >
                                                                {
                                                                    extra.display_name
                                                                }
                                                                <span className="badge badge-primary bg-primary badge-pill">
                                                                    {
                                                                        extra.quantity
                                                                    }
                                                                </span>
                                                            </li>
                                                        )
                                                    )}
                                                </ul>
                                            ) : (
                                                ""
                                            )}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

export default InfoModal;
