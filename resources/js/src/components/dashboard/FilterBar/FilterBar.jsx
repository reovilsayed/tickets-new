import React, { useEffect, useState } from "react";
import "./FilterBar.css";
import { useFetch } from "../../../lib/hooks/useFetch";
import { formatDate } from "../../../lib/utils";
import { useDispatch, useSelector } from "react-redux";
import { changeDate, changeEvent } from "../../../lib/features/filterSlice";
import { useCart } from "react-use-cart";

function FilterBar() {
    const { emptyCart } = useCart();
    const dispatch = useDispatch();
    const { data: filterEvents } = useFetch(["filter-events"], "/api/events");

    const filterEvent = useSelector((state) => state.filter.event);
    const dateOfEvent = useSelector((state) => state.filter.date);

    const [selectedEvent, setSelectedEvent] = useState(filterEvent);
    const [selectedDate, setSelectedDate] = useState(dateOfEvent);

    const handleEventSelect = (event) => {
        var res = confirm("The cart will reset upon changing event");
        if (!res) return;
        emptyCart();
        const selectedEvent = filterEvents?.data?.find(
            (e) => e.id === parseInt(event.target.value, 10)
        );
        dispatch(changeEvent(selectedEvent));
        dispatch(changeDate(""));
        setSelectedEvent(selectedEvent);
        setSelectedDate("");
    };

    const handleDateSelect = (event) => {
        const selectedDate = event.target.value;
        dispatch(changeDate(selectedDate));
        setSelectedDate(selectedDate);
    };

    return (
        <div
            className="form-control fixed row my-2 gx-2 shadow-sm left-0 right-0 padding-0 d-flex flex-row align-items-center"
            tabIndex="-1"
            id="offcanvasBottom"
            aria-labelledby="offcanvasBottomLabel"
            onClick={(e) => e.stopPropagation()}
        >
            <div className="d-flex flex-row align-items-center col-md-6">
                <label htmlFor="eventsSelect">Events</label>
                <div className="filter-select-group w-100">
                    <div className="form-floating row row-cols-1 row-cols-md-1">
                        <select
                            className="form-select p-2"
                            style={{
                                fontSize: "0.8rem",
                                height: "fit-content",
                            }}
                            id="eventsSelect"
                            aria-label="Events"
                            value={selectedEvent?.id || ""}
                            onChange={handleEventSelect}
                        >
                            <option value="">None</option>
                            {filterEvents?.data?.map((event) => (
                                <option key={event.id} value={event.id}>
                                    {event?.name ?? "N/A"}
                                </option>
                            ))}
                        </select>
                    </div>
                </div>
            </div>
            {selectedEvent && (
                <div className="d-flex flex-row align-items-center col-md-6">
                    <label htmlFor="datesSelect">Dates</label>
                    <div className="filter-select-group w-100 filter-fade-in">
                        <div className="form-floating row row-cols-1 row-cols-md-1">
                            <select
                                className="form-select p-2"
                                style={{
                                    fontSize: "0.8rem",
                                    height: "fit-content",
                                }}
                                id="datesSelect"
                                aria-label="Dates"
                                value={selectedDate || ""}
                                onChange={handleDateSelect}
                            >
                                <option value="">All</option>
                                {selectedEvent?.dates?.map(
                                    (eventDate, index) => (
                                        <option key={index} value={eventDate}>
                                            {formatDate(eventDate) ?? "N/A"}
                                        </option>
                                    )
                                )}
                            </select>
                        </div>
                    </div>
                </div>
            )}
        </div>
    );
}

export default FilterBar;
