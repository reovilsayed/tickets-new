import React, { useMemo } from "react";
import "./CartItem.css";
import { useCart } from "react-use-cart";
import { calculateExtrasFees, verifyImage } from "../../../../lib/utils";
import { Accordion } from "react-bootstrap";
import { useDispatch } from "react-redux";
import { open } from "../../../../lib/features/addExtraModalSlice";

function CartItem({ item }) {
    const dispatch = useDispatch();
    const { updateItem, updateItemQuantity, removeItem } = useCart();
    const handleItemQuantity = (quantity) =>
        updateItemQuantity(item?.id, item?.quantity + quantity);
    const handleRemove = () => removeItem(item?.id);
    const handleItemExtras = (targetExtra, quantity) => {
        if (!targetExtra || quantity < targetExtra?.quantity) return;
        var updatedItem = item;
        if (quantity > 0) {
            updatedItem.extras = updatedItem?.extras.map((extra) => {
                if (extra?.id === targetExtra?.id) {
                    return { ...extra, newQuantity: quantity };
                }
                return extra;
            });
        } else {
            updatedItem.extras = updatedItem?.extras.filter(
                (extra) => extra?.id !== targetExtra?.id
            );
        }
        updateItem(item?.id, updatedItem);
    };
    const handleOpenAddExtraModal = () => {
        dispatch(open(item));
    };
    const extrasFees = useMemo(() => {
        return item?.isTicket ? calculateExtrasFees(item?.extras) ?? 0 : 0;
    }, [item]);
    return (
        <div className="cart-item row w-100">
            <div className="col-md-2 col-3">
                <img
                    src={verifyImage(item?.event_thumbnail)}
                    className="cart-item-image"
                />
            </div>
            <div className="col-md-10 col-9">
                <div className="d-flex justify-content-between">
                    <h6 className="cart-item-name m-0">
                        <small>{item?.name || "Product Name"}</small>
                        <br />
                    </h6>
                    <button
                        onClick={handleRemove}
                        className="btn btn-danger btn-sm"
                    >
                        <i className="fa fa-trash"></i>
                    </button>
                </div>
                <p className="cart-item-info">
                    <span>{item?.price || 0}</span>
                    {" X "}
                    <span>{item?.quantity || 1}</span>
                    {" = "}
                    <span>{(item?.quantity || 1) * (item?.price || 0)}</span>
                    {" €"}
                </p>
                {item?.isTicket && (
                    <p className="cart-item-info">
                        <span>Extras</span>
                        {" = "}
                        <span>{extrasFees}</span>
                        {" €"}
                    </p>
                )}
                <div className="cart-item-controls mt-2 d-flex justify-content-between">
                    <div className="control-buttons-group">
                        <button
                            className="btn btn-outline-danger btn-sm"
                            onClick={() => handleItemQuantity(-10)}
                        >
                            -10
                        </button>
                        <button
                            className="btn btn-outline-danger btn-sm"
                            onClick={() => handleItemQuantity(-5)}
                        >
                            -5
                        </button>
                        <button
                            className="btn btn-outline-danger btn-sm"
                            onClick={() => handleItemQuantity(-1)}
                        >
                            -
                        </button>
                    </div>
                    <p className="item-quantity h6 d-flex justify-content-center align-items-center">
                        {item?.quantity || 1}
                    </p>
                    <div className="control-buttons-group">
                        <button
                            className="btn btn-outline-dark btn-sm"
                            onClick={() => handleItemQuantity(1)}
                        >
                            +
                        </button>
                        <button
                            className="btn btn-outline-dark btn-sm"
                            onClick={() => handleItemQuantity(5)}
                        >
                            +5
                        </button>
                        <button
                            className="btn btn-outline-dark btn-sm"
                            onClick={() => handleItemQuantity(10)}
                        >
                            +10
                        </button>
                    </div>
                </div>
                {item?.isTicket && item?.extras?.length ? (
                    <Accordion className="py-1 mt-2">
                        <Accordion.Item eventKey="0">
                            <Accordion.Header>Extras</Accordion.Header>
                            <Accordion.Body>
                                {item.extras.map((extra, index) => (
                                    <span
                                        key={index}
                                        className="d-flex justify-content-between align-items-center"
                                    >
                                        {extra.display_name}
                                        <div className="update-quantity d-flex align-items-center justify-content-center">
                                            <button
                                                className="btn btn-outline-danger btn-sm"
                                                onClick={() =>
                                                    handleItemExtras(
                                                        extra,
                                                        (extra?.newQuantity ??
                                                            extra?.quantity) - 1
                                                    )
                                                }
                                            >
                                                -
                                            </button>
                                            <input
                                                type="number"
                                                value={
                                                    extra?.newQuantity ??
                                                    extra?.quantity ??
                                                    0
                                                }
                                                onChange={(e) =>
                                                    handleItemExtras(
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
                                                    handleItemExtras(
                                                        extra,
                                                        (extra?.newQuantity ??
                                                            extra?.quantity) + 1
                                                    )
                                                }
                                            >
                                                +
                                            </button>
                                        </div>
                                    </span>
                                ))}
                                <span className="d-flex justify-content-center align-items-center mt-2">
                                    <button
                                        type="button"
                                        class="btn btn-info text-light w-100 py-1"
                                        onClick={handleOpenAddExtraModal}
                                    >
                                        Add extra
                                    </button>
                                </span>
                            </Accordion.Body>
                        </Accordion.Item>
                    </Accordion>
                ) : (
                    ""
                )}
            </div>
        </div>
    );
}

export default CartItem;
