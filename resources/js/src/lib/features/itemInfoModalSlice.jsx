import { createSlice } from "@reduxjs/toolkit";

const initialState = {
    item: {},
    open: false,
};

export const itemInfoModalSlice = createSlice({
    name: "itemInfoModal",
    initialState,
    reducers: {
        setItem: (state, action) => {
            state.item = action.payload;
        },
        open: (state, action) => {
            state.item = action.payload;
            state.open = true;
        },
        close: (state) => {
            state.open = false;
        },
    },
});

export const { setItem, open, close } = itemInfoModalSlice.actions;

export default itemInfoModalSlice.reducer;
