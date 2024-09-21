import axios from "axios";
import { useEffect } from "react";
import { useInfiniteQuery, useQueryClient } from "react-query";

export const useInfiniteFetch = (key, url, params = {}, options = {}) => {
    const { prefetch, pageSize = 10, ...configOptions } = options;
    const queryClient = useQueryClient();
    const fetchPosts = async ({ pageParam = 1 }) => {
        // Use the 'pageParam' to fetch the appropriate page from the server
        const response = await axios.get(
            `${url}?page=${pageParam}&per_page=${5}&query=${
                params?.query ?? ""
            }`,
            {
                headers: {
                    "Content-Type": "application/json",
                },
            }
        );
        return response.data; // Return only the data object from the response
    };

    const {
        data,
        isLoading,
        isError,
        isSuccess,
        error,
        hasNextPage,
        fetchNextPage,
        isFetching,
    } = useInfiniteQuery(key, fetchPosts, {
        ...configOptions,
        getNextPageParam: (lastPage) => {
            const currentPage = lastPage?.current_page;
            const lastPageNumber = lastPage?.last_page;

            // Return the next page number or null if it's the last page
            return currentPage < lastPageNumber ? currentPage + 1 : null;
        },
    });

    useEffect(() => {
        // Handle 401 Unauthorized error by clearing auth data
        if (error?.response?.status === 401) {
            localStorage.setItem("authData", null);
        }
    }, [isError, error]);

    // Refetch the data manually
    const refetch = (explicitKey) => {
        queryClient.invalidateQueries(explicitKey || key);
    };

    // Manually set data in the cache
    const setData = (callback) => {
        queryClient.setQueryData(key, (oldData) => callback(oldData));
    };

    return {
        data,
        isLoading,
        isError,
        isSuccess,
        hasNextPage,
        isFetching,
        fetchNextPage,
        refetch,
        setData,
    };
};
