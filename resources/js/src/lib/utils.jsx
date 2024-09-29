import defaultImage from "../public/images/no-image.jpg";

export const formatDate = (date) => {
    if (!date) return null;

    const dateObj = new Date(date);

    const options = { day: "numeric", month: "short", year: "numeric" };
    return dateObj.toLocaleDateString("en-US", options);
};

export const formatDateRange = (startDate, endDate) => {
    const startDateObj = new Date(startDate);
    const endDateObj = new Date(endDate);

    const options = { day: "numeric", month: "short", year: "numeric" };
    return `${startDateObj.toLocaleDateString(
        "en-US",
        options
    )} - ${endDateObj.toLocaleDateString("en-US", options)}`;
};

export const formatPrice = (price) => parseFloat(price).toFixed(2);

export const verifyImage = (image) => image ?? defaultImage;

export const calculateExtrasFees = (items = []) => {
    return items.reduce((accumulator, currentValue) => {
        if (currentValue?.quantity && currentValue?.newQuantity) {
            if (currentValue?.newQuantity > currentValue?.quantity) {
                return (
                    accumulator +
                    (currentValue?.newQuantity - currentValue?.quantity) *
                        currentValue?.price
                );
            }
        } else if (currentValue?.newQuantity) {
            return (
                accumulator + currentValue?.newQuantity * currentValue?.price
            );
        }
        return accumulator;
    }, 0);
};

export const calculateExtrasFeesForTotalCart = (items = []) => {
    return items.reduce((accumulator, currentValue) => {
        if (!currentValue?.isTicket) return accumulator;
        return accumulator + calculateExtrasFees(currentValue?.extras);
    }, 0);
};
