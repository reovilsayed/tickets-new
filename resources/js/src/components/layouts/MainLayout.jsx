// import "../../App.css";
import React, { useState } from "react";
import NavList from "./NavList/NavList";
import LogoImage from "../../public/Essência-logo.png";

function MainLayout({ children }) {
    const handleLogout = (e) => {
        e.preventDefault();
        // Implement your logout logic here
        console.log("Logout clicked");
    };

    return (
        <>
            <div className="dashboard_header">
                <div className="fluid_container">
                    <div className="header_row">
                        <a href="#" className="logo">
                            <img
                                style={{
                                    height: "70px",
                                    width: "100px",
                                    borderRadius: "10px",
                                }}
                                src={LogoImage}
                                alt="Logo"
                            />
                        </a>
                    </div>
                </div>
            </div>

            <div className="dashboard_body">
                <div className="fluid_container">
                    <div className="dashboard_body_inner">
                        <div className={`navigation open`} id="navigation">
                            {/* You can replace <x-sidenav.navlist /> with actual nav list component */}
                            <NavList />
                        </div>

                        <div className="dashboard_content">
                            <div
                                className="dashboard_content_inner"
                                style={{ marginBottom: "50px" }}
                            >
                                {children}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <form
                action="/logout"
                method="post"
                id="logout-form"
                onSubmit={handleLogout}
            >
                {/* Add CSRF token handling logic */}
                <button type="submit">Logout</button>
            </form>

            <div className="menu_overlay" id="menu_overlay"></div>
        </>
    );
}

export default MainLayout;
