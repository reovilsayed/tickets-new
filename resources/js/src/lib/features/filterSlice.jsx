import { createSlice } from "@reduxjs/toolkit";

const initialState = {
    event: "",
    date: "",
};

export const filterSlice = createSlice({
    name: "filter",
    initialState,
    reducers: {
        changeEvent: (state, action) => {
            state.event = action.payload;
        },
        changeDate: (state, action) => {
            state.date = action.payload;
        },
    },
});

export const { changeEvent, changeDate } = filterSlice.actions;

export default filterSlice.reducer;
