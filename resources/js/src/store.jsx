import { configureStore } from "@reduxjs/toolkit";
import itemInfoModalReducer from "./lib/features/itemInfoModalSlice";
import searchQueryReducer from "./lib/features/searchQuerySlice";
import paymentModalReducer from "./lib/features/paymentModalSlice";
import addExtraModalReducer from "./lib/features/addExtraModalSlice";
import filterReducer from "./lib/features/filterSlice";

export const store = configureStore({
    reducer: {
        itemInfoModal: itemInfoModalReducer,
        addExtraModal: addExtraModalReducer,
        searchQuery: searchQueryReducer,
        paymentModal: paymentModalReducer,
        filter: filterReducer,
    },
});
