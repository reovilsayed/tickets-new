import { createSlice } from "@reduxjs/toolkit";

const initialState = {
    open: false,
    cartOpen: false,
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
        setCartOpen: (state, action) => {
            console.log(action.payload);
            
            state.cartOpen = action.payload;
        },
    },
});

export const { open, close, setCartOpen } = paymentModalSlice.actions;

export default paymentModalSlice.reducer;
