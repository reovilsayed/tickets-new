import React, { useCallback, useMemo } from "react";
import { calculateExtrasFees } from "../../../../lib/utils";

function CartInfoItem({ item }) {
    const extrasFees = useMemo(
        () => calculateExtrasFees(item?.extras) ?? 0.0,
        item
    );
    const calculateSingleExtra = useCallback(
        (extra) => {
            return extra?.newQuantity && extra?.quantity
                ? (extra?.newQuantity - extra?.quantity) * extra?.price
                : extra?.newQuantity
                ? extra?.newQuantity * extra?.price
                : 0.0;
        },
        [item]
    );
    return (
        <>
            <tr className="table-info">
                <td>{item?.name}</td>
                <td>
                    {item?.price}
                    {" €"}
                </td>
                <td>{item?.quantity}</td>
                {item?.isTicket && (
                    <>
                        <td>
                            {item?.itemTotal}
                            {" €"}
                        </td>
                        <td>
                            {extrasFees}
                            {" €"}
                        </td>
                    </>
                )}
                <td className="text-end" colSpan={item?.isTicket ? 1 : 3}>
                    {item?.itemTotal}
                    {" €"}
                </td>
            </tr>
            {item?.isTicket &&
                item?.extras?.map((extra, index) => (
                    <tr key={index}>
                        <td>{extra?.name}</td>
                        <td>
                            {extra?.price}
                            {" €"}
                        </td>
                        <td>
                            {extra?.quantity ?? 0}{" "}
                            {(extra?.newQuantity ?? 0) -
                                (extra?.quantity ?? 0) >
                            0
                                ? `+ ${
                                      extra?.newQuantity -
                                      (extra?.quantity ?? 0)
                                  }`
                                : ""}
                        </td>
                        <td colSpan={3} className="text-end">
                            {calculateSingleExtra(extra)}
                            {" €"}
                        </td>
                    </tr>
                ))}
        </>
    );
}

export default CartInfoItem;
