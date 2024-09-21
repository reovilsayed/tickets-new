import { createSlice } from "@reduxjs/toolkit";

const initialState = {
    query: "",
};

export const searchQuerySlice = createSlice({
    name: "searchQuery",
    initialState,
    reducers: {
        changeQuery: (state, action) => {
            state.query = action.payload;
        },
        resetQuery: (state) => {
            state.query = "";
        },
    },
});

export const { changeQuery, resetQuery } = searchQuerySlice.actions;

export default searchQuerySlice.reducer;
