import React, { useMemo } from "react";
function ScannedCartInfoItem({ item }) {
    const quantity = useMemo(
        () =>  (item?.newQty ?? 0) - (item?.qty ?? 0),
        [item?.newQty, item?.qty]
    );
    return (
        <>
            <tr className="table-info">
                <td>{item?.display_name ?? item?.name}</td>
                <td>
                    {item?.price}
                    {" €"}
                </td>
                <td>{quantity}</td>
                <td>
                    {item?.price * quantity}
                    {" €"}
                </td>
            </tr>
        </>
    );
}

export default ScannedCartInfoItem;
