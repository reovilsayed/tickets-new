import { createSlice } from "@reduxjs/toolkit";

const initialState = {
    open: false,
};

export const paymentModalSlice = createSlice({
    name: "paymentModal",
    initialState,
    reducers: {
        open: (state) => {
            state.open = true;
        },
        close: (state) => {
            state.open = false;
        },
    },
});

export const { open, close } = paymentModalSlice.actions;

export default paymentModalSlice.reducer;
