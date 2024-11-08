import React, { useState } from "react";
import { NavLink, useLocation } from "react-router-dom";
import "./NavList.css";
import { navRoutes } from "../../../router";
import axios from "axios";

const NavList = () => {
    const { pathname } = useLocation();
    const handleLogout = async () => {
        const csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content");

        await axios.post(
            `${import.meta.env.VITE_APP_URL}/logout`,
            {},
            {
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
            }
        );

        window.location.href = "/";
    };
    return (
        <div className="nav_inner">
            <ul className="nav_list">
                {navRoutes.map((route, index) => {
                    return !route.hidden ? (
                        <NavItem
                            key={index}
                            name={route.name}
                            to={route.path}
                            icon={route.icon}
                            active={pathname === route.path}
                        />
                    ) : (
                        ""
                    );
                })}
                <li >
                    <a href={`${import.meta.env.VITE_APP_URL}/pos/reports`} target="__blank">
                        <i className="fas fa-file"></i>
                        <span>Reports</span>
                    </a>
                </li>
                <li onClick={handleLogout}>
                    <a className="logout-trigger">
                        <i className="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    );
};

const NavItem = ({ name, to, icon, active = false }) => {
    return (
        <li className={active ? "active" : ""}>
            <NavLink exact="true" to={to}>
                <i className={icon}></i>
                <span>{name}</span>
            </NavLink>
        </li>
    );
};

export default NavList;
