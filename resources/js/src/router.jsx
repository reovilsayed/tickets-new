import { createBrowserRouter } from "react-router-dom";
import React, { Suspense } from "react";
import Loading from "./components/Loading";

export const navRoutes = [
    {
        path: "/pos",
        name: "Dashboard",
        icon: "fas fa-home",
        layout: React.lazy(() => import("./components/layouts/MainLayout")),
        element: React.lazy(() => import("./App")),
    },
    {
        path: "/pos/tickets",
        name: "Tickets",
        icon: "fas fa-ticket-alt",
        layout: React.lazy(() =>
            import("./components/layouts/DashboardLayout")
        ),
        element: React.lazy(() => import("./pages/Tickets/Tickets")),
    },
    {
        path: "/pos/extras",
        name: "Extras",
        icon: "fa fa-beer",
        layout: React.lazy(() =>
            import("./components/layouts/DashboardLayout")
        ),
        element: React.lazy(() => import("./pages/Extras/Extras")),
    },
    {
        path: "/pos/scanner",
        name: "Scan",
        icon: "fa fa-qrcode",
        layout: React.lazy(() =>
            import("./components/layouts/DashboardLayout")
        ),
        element: React.lazy(() => import("./pages/Scanner/Scanner")),
    },
];

export const router = createBrowserRouter([
    ...navRoutes.map((route) => {
        return {
            path: route.path,
            element: (
                <Suspense fallback={<Loading />}>
                    <route.layout>
                        <route.element />
                    </route.layout>
                </Suspense>
            ),
        };
    }),
]);
