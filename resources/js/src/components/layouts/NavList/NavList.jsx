import React, { useState } from "react";
import { NavLink, useLocation } from "react-router-dom";
import "./NavList.css";
import { navRoutes } from "../../../router";

const NavList = () => {
    const { pathname } = useLocation();
    return (
        <div className="nav_inner">
            <ul className="nav_list">
                {navRoutes.map((route, index) => (
                    <NavItem
                        key={index}
                        name={route.name}
                        to={route.path}
                        icon={route.icon}
                        active={pathname === route.path}
                    />
                ))}
                <li>
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
