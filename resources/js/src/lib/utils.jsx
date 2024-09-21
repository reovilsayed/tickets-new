import defaultImage from "../public/images/no-image.jpg";

export const formatDate = (startDate, endDate) => {
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
