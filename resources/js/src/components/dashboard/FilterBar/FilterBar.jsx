import React, { useState } from "react";
import "./FilterBar.css";
import { useFetch } from "../../../lib/hooks/useFetch";
import { formatDate } from "../../../lib/utils";
import { useDispatch } from "react-redux";
import { changeDate, changeEvent } from "../../../lib/features/filterSlice";

function FilterBar() {
    const dispatch = useDispatch();
    const { data: filterEvents } = useFetch(["filter-events"], "/api/events");

    const [selectedEvent, setSelectedEvent] = useState(null);
    const handleEventSelect = (event) => {
        dispatch(changeEvent(event));
        dispatch(changeDate(""));
        setSelectedEvent(event);
        setSelectedDate("");
    };

    const [selectedDate, setSelectedDate] = useState(null);
    const handleDateSelect = (eventDate) => {
        dispatch(changeDate(eventDate));
        setSelectedDate(eventDate);
    };

    return (
        <div
            className={`form-control fixed row my-2 gx-2 shadow-sm left-0 right-0 padding-0 d-flex flex-row align-items-center`}
            tabIndex="-1"
            id="offcanvasBottom"
            aria-labelledby="offcanvasBottomLabel"
            onClick={(e) => e.stopPropagation()}
        >
            <div className="d-flex flex-row align-items-center col-md-6">
                <label for="eventsSelect">Events</label>
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
                        >
                            <option onClick={() => handleEventSelect(null)}>
                                None
                            </option>
                            {filterEvents?.data?.map((event, index) => (
                                <option
                                    key={index}
                                    onClick={() => handleEventSelect(event)}
                                >
                                    {event?.name ?? "N/A"}
                                </option>
                            ))}
                        </select>
                    </div>
                </div>
            </div>
            {selectedEvent !== null && (
                <div className="d-flex flex-row align-items-center col-md-6">
                    <label for="eventsSelect">Dates</label>
                    <div
                        className={`filter-select-group w-100 ${
                            selectedEvent !== null
                                ? "filter-fade-in"
                                : "filter-fade-out"
                        }`}
                    >
                        <div className="form-floating row row-cols-1 row-cols-md-1">
                            <select
                                className="form-select p-2"
                                style={{
                                    fontSize: "0.8rem",
                                    height: "fit-content",
                                }}
                                id="eventsSelect"
                                aria-label="Events"
                            >
                                <option onClick={() => handleDateSelect("")}>
                                    None
                                </option>
                                {selectedEvent?.dates?.map(
                                    (eventDate, index) => (
                                        <option
                                            key={index}
                                            onClick={() =>
                                                handleDateSelect(eventDate)
                                            }
                                        >
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
