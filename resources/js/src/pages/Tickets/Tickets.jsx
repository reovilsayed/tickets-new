import React, { Fragment, useCallback, useEffect } from "react";
import InfiniteScroll from "react-infinite-scroller";
import { HashLoader, PulseLoader } from "react-spinners";
import TicketItem from "./TicketItem/TicketItem";
import { useInfiniteFetch } from "../../lib/hooks/useInfiniteFetch";
import { useSelector } from "react-redux";

function Tickets() {
    const searchQuery = useSelector((state) => state.searchQuery.query);
    const filterEvent = useSelector((state) => state.filter.event);
    const eventDate = useSelector((state) => state.filter.date);

    const {
        data,
        isError,
        isLoading,
        isSuccess,
        isFetching,
        hasNextPage,
        fetchNextPage,
        refetch,
    } = useInfiniteFetch(
        ["tickets", searchQuery, filterEvent, eventDate],
        `${import.meta.env.VITE_APP_URL}/api/tickets`,
        { query: searchQuery, event_id: filterEvent?.id, eventDate }
    );

    const handleScroll = useCallback(() => {
        const scrollTop = document.documentElement.scrollTop;
        const shouldFetchNextPage = scrollTop < 500 && scrollTop === 0;

        if (shouldFetchNextPage && hasNextPage && !isFetching) {
            fetchNextPage();
        }
    }, [fetchNextPage, hasNextPage, isFetching]);

    useEffect(() => {
        window.addEventListener("scroll", handleScroll);

        return () => {
            window.removeEventListener("scroll", handleScroll);
        };
    }, [handleScroll]);

    return (
        <div className="overflow-y-scroll overflow-x-none pt-3">
            {isLoading ? (
                <div
                    style={{
                        width: "100%",
                        height: "100vh",
                        display: "flex",
                        justifyContent: "center",
                        alignItems: "center",
                    }}
                >
                    <HashLoader color="#36d7b7" />
                </div>
            ) : (
                <InfiniteScroll
                    loadMore={fetchNextPage}
                    hasMore={hasNextPage}
                    loader={
                        <div
                            style={{
                                textAlign: "center",
                                paddingTop: "25px",
                            }}
                        >
                            <PulseLoader color="#36d7b7" />
                        </div>
                    }
                    useWindow={false}
                    style={{
                        overflowY: "scroll",
                        overflowX: "hidden",
                        maxHeight: "90vh",
                        padding: "20px 10px",
                    }}
                    onScroll={handleScroll}
                >
                    <div className="row g-3">
                        {isError ? (
                            <div
                                style={{
                                    textAlign: "center",
                                    color: "red",
                                }}
                            >
                                Something went wrong
                            </div>
                        ) : data?.pages?.length ? (
                            data.pages.map((page, index) => (
                                <Fragment key={index}>
                                    {page.data.map((ticket, ticketIndex) => (
                                        <TicketItem
                                            key={ticketIndex}
                                            ticket={ticket}
                                        />
                                    ))}
                                </Fragment>
                            ))
                        ) : (
                            <div style={{ textAlign: "center" }}>
                                No matching products found.
                            </div>
                        )}
                    </div>
                </InfiniteScroll>
            )}
        </div>
    );
}

export default Tickets;
