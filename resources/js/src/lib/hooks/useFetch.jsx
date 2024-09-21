import axios from "axios";
import { useEffect } from "react";
import { useQuery, useQueryClient } from "react-query";

export const useFetch = (key, url, params = {}, options = {}) => {
    const { prefetch, ...configOptions } = options;
    const queryClient = useQueryClient();

    const fetchData = async () => {
        const response = await axios.get(url, {
            params, // Add any additional parameters in the request
            headers: {
                "Content-Type": "application/json",
            },
        });
        return response.data; // Return the data from the response
    };

    const { data, isLoading, isError, isSuccess, error } = useQuery(
        key,
        fetchData,
        configOptions
    );

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
        refetch,
        setData,
    };
};
