import React, { useEffect, useState } from "react";
import { useSelector, useDispatch } from "react-redux";
import "./AddExtraModal.css";
import { Button, Form, InputGroup } from "react-bootstrap";
import { useFetch } from "../../../lib/hooks/useFetch";
import { close } from "../../../lib/features/addExtraModalSlice";
import { useCart } from "react-use-cart";

function AddExtraModal() {
    const dispatch = useDispatch();
    const item = useSelector((state) => state.addExtraModal.item);
    const open = useSelector((state) => state.addExtraModal.open);

    const { updateItem } = useCart();

    const [selectedExtra, setSelectedExtra] = useState(null);
    const [quantity, setQuantity] = useState(1);
    const handleQuantity = (newQuantity) => {
        setQuantity((prev) => (newQuantity > 0 ? newQuantity : prev));
    };

    const handleClose = () => {
        dispatch(close());
    };

    const handleAddExtra = () => {
        if (!item || !selectedExtra) return;
        var extras = [...item.extras];
        var extraIsUnique = true;
        extras = extras.map((extra) => {
            if (extra.id === selectedExtra.id) {
                extraIsUnique = false;
                return {
                    ...extra,
                    newQuantity: extra.quantity + quantity,
                };
            }
            return extra;
        });
        if (extraIsUnique) {
            extras = [...extras, { ...selectedExtra, newQuantity: quantity }];
        }
        updateItem(item?.id, {
            ...item,
            extras: [...extras],
        });
        setSelectedExtra(null);
        setQuantity(1);
        dispatch(close());
    };

    const {
        data: extrasList,
        isError,
        isLoading,
        isSuccess,
        refetch,
    } = useFetch(["extras"], `${import.meta.env.VITE_APP_URL}/api/extras`);

    useEffect(() => {
        const modalElement = document.getElementById("addExtraModal");

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

    const handleSelectExtra = (event) => {
        const selectedValue = extrasList?.data?.find(
            (e) => e.id === parseInt(event.target.value, 10)
        );
        setSelectedExtra(selectedValue);
    };

    return (
        <>
            {open && <div className="add-extra-modal-backdrop fade-in"></div>}
            <div
                className={`modal ${open ? "fade-in" : "fade-out"}`}
                id="addExtraModal"
                tabIndex="-1"
                aria-labelledby="addExtraModalLabel"
                aria-hidden={!open}
                onClick={handleClose}
            >
                <div
                    className="modal-dialog modal-center modal-lg"
                    onClick={(e) => e.stopPropagation()}
                >
                    <div className="modal-content">
                        <div className="modal-header">
                            <h5
                                className="modal-title text-center"
                                id="addExtraModalLabel"
                            >
                                Add Extra to {item?.name ?? "Ticket"}{" "}
                                {selectedExtra &&
                                    quantity > 0 &&
                                    `with an additional ${parseFloat(
                                        selectedExtra?.price * quantity
                                    ).toFixed(2)}`}
                            </h5>
                            <button
                                type="button"
                                className="btn-close"
                                aria-label="Close"
                                onClick={handleClose}
                            ></button>
                        </div>
                        <div className="modal-body row">
                            <div className="col-md-12">
                                <div className="form-group">
                                    <label htmlFor="extraSelect">
                                        Select Extra
                                    </label>
                                    <select
                                        id="extraSelect"
                                        className="form-control mt-2"
                                        value={
                                            selectedExtra?.display_name ??
                                            "Select an extra"
                                        }
                                        onChange={handleSelectExtra}
                                    >
                                        <option value={null}>None</option>
                                        {extrasList?.data?.map(
                                            (extra, index) => (
                                                <option
                                                    key={index}
                                                    value={extra?.id}
                                                >
                                                    {extra?.display_name}
                                                </option>
                                            )
                                        )}
                                    </select>
                                </div>

                                {selectedExtra ? (
                                    <div className="form-group mt-3 d-flex flex-column justify-content-center align-items-center">
                                        <label htmlFor="quantity">
                                            Quantity
                                        </label>
                                        <InputGroup className="mt-3 w-25">
                                            <Button
                                                variant="outline-secondary"
                                                onClick={() =>
                                                    handleQuantity(quantity - 1)
                                                }
                                            >
                                                -
                                            </Button>
                                            <Form.Control
                                                aria-label="Example text with two button addons"
                                                className="text-center"
                                                value={quantity}
                                                onChange={(event) =>
                                                    handleQuantity(
                                                        event.target.value
                                                    )
                                                }
                                            />
                                            <Button
                                                variant="outline-danger"
                                                onClick={() =>
                                                    handleQuantity(quantity + 1)
                                                }
                                            >
                                                +
                                            </Button>
                                        </InputGroup>
                                    </div>
                                ) : (
                                    ""
                                )}
                            </div>
                        </div>
                        <div className="modal-footer">
                            <button
                                type="button"
                                className="btn btn-secondary"
                                onClick={handleClose}
                            >
                                Close
                            </button>
                            <button
                                type="button"
                                className="btn btn-primary"
                                onClick={handleAddExtra}
                                disabled={!selectedExtra || quantity < 1}
                            >
                                Add Extra
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </>
    );
}

export default AddExtraModal;
