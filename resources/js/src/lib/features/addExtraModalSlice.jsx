import { createSlice } from "@reduxjs/toolkit";

const initialState = {
    item: {},
    open: false,
};

export const addExtraModalSlice = createSlice({
    name: "addExtraModal",
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
            state.item = {};
            state.open = false;
        },
    },
});

export const { setItem, open, close } = addExtraModalSlice.actions;

export default addExtraModalSlice.reducer;
