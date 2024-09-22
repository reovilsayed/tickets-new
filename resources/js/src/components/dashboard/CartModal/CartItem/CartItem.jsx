import React from "react";
import "./CartItem.css";
import { useCart } from "react-use-cart";
import { verifyImage } from "../../../../lib/utils";

function CartItem({ item }) {
    const { updateItemQuantity, removeItem } = useCart();
    const handleItemQuantity = (quantity) =>
        updateItemQuantity(item?.id, item?.quantity + quantity);
    const handleRemove = () => removeItem(item?.id);
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
                    <span>{item?.quantity || 1}</span>
                    {" X "}
                    <span>{item?.price || 0}</span>
                    {" = "}
                    <span>
                        {(item?.quantity || 1) * (item?.price || 0)}
                    </span>{" "}
                    Taka
                </p>
                <div className="cart-item-controls mt-2 d-flex gap-1">
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
                {item?.extras?.length ? (
                    <ul className="list-group my-2">
                        {item.extras.map((extra, index) => (
                            <li
                                key={index}
                                className="list-group-item d-flex justify-content-between align-items-center"
                            >
                                {extra.display_name}{" "}
                                <span className="badge badge-pill bg-primary">
                                    {extra.quantity}
                                </span>
                            </li>
                        ))}
                    </ul>
                ) : (
                    ""
                )}
            </div>
        </div>
    );
}

export default CartItem;
