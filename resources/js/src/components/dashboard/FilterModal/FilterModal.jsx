import React, { useState } from "react";
import "./FilterModal.css";
import { useFetch } from "../../../lib/hooks/useFetch";
import { formatDate } from "../../../lib/utils";
import { useDispatch } from "react-redux";
import { changeDate, changeEvent } from "../../../lib/features/filterSlice";

function FilterModal({ show, onClose }) {
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

    return show ? (
        <>
            <div
                className="filter-modal-backdrop filter-fade-in"
                onClick={onClose}
            ></div>
            <div
                className={`filter-modal ${
                    show ? "filter-fade-in" : "filter-fade-out"
                }`}
                tabIndex="-1"
                id="offcanvasBottom"
                aria-labelledby="offcanvasBottomLabel"
                aria-hidden={!show}
                onClick={(e) => e.stopPropagation()}
            >
                <div className="offcanvas-header">
                    <h5 className="offcanvas-title" id="offcanvasBottomLabel">
                        Filter
                    </h5>
                    <button
                        type="button"
                        className="btn-close text-reset"
                        aria-label="Close"
                        onClick={onClose}
                    ></button>
                </div>
                <div className="offcanvas-body small overflow-x-hidden max-w-100 filter-select-group">
                    <div class="form-floating row row-cols-1 row-cols-md-1">
                        <select
                            class="form-select"
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
                        <label for="eventsSelect">
                            {selectedEvent ? selectedEvent.name : "Events"}
                        </label>
                    </div>
                </div>
                {selectedEvent !== null && (
                    <div
                        className={`offcanvas-body small overflow-x-hidden max-w-100 filter-select-group ${
                            selectedEvent !== null
                                ? "filter-fade-in"
                                : "filter-fade-out"
                        }`}
                    >
                        <div class="form-floating row row-cols-1 row-cols-md-1">
                            <select
                                class="form-select"
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
                            <label for="eventsSelect">
                                {selectedDate
                                    ? formatDate(selectedDate)
                                    : "Dates"}
                            </label>
                        </div>
                    </div>
                )}
            </div>
        </>
    ) : null;
}

export default FilterModal;
