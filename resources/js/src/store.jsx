import { configureStore } from "@reduxjs/toolkit";
import itemInfoModalReducer from "./lib/features/itemInfoModalSlice";
import searchQueryReducer from "./lib/features/searchQuerySlice";
import filterReducer from "./lib/features/filterSlice";

export const store = configureStore({
    reducer: {
        itemInfoModal: itemInfoModalReducer,
        searchQuery: searchQueryReducer,
        filter: filterReducer,
    },
});
