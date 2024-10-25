import React, { useMemo, useState } from "react";
import NavList from "./NavList/NavList";
import InfoModal from "../dashboard/InfoModal/InfoModal";
import { useDispatch, useSelector } from "react-redux";
import CartButton from "./Buttons/CartButton";
import CartModal from "../dashboard/CartModal/CartModal";
import LogoImage from "../../public/Essência-logo.png";
import FilterBar from "../dashboard/FilterBar/FilterBar";
import AddExtraModal from "../dashboard/AddExtraModal/AddExtraModal";
import PaymentModal from "../dashboard/PaymentModal/PaymentModal";
import { setCartOpen } from "../../lib/features/paymentModalSlice";
import { useLocation } from "react-router-dom";

function DashboardLayout({ children }) {
    const [isMenuOpen, setIsMenuOpen] = useState(false);

    const handleHamburgerClick = () => {
        setIsMenuOpen(!isMenuOpen);
    };

    const handleLogout = (e) => {
        e.preventDefault();
        console.log("Logout clicked");
    };

    const dispatch = useDispatch();

    const cartOpen = useSelector((state) => state.paymentModal.cartOpen);
    // const [cartOpen, setCartOpen] = useState(cartModalOpen);

    const openCart = () => {
        dispatch(setCartOpen(true));
    };
    const closeCart = () => dispatch(setCartOpen(false));
    // useEffect(() => dispatch(setCartOpen(cartOpen)), [cartOpen]);

    const paymentModalOpen = useSelector((state) => state.paymentModal.open);

    const { pathname } = useLocation();

    const showFilter = useMemo(
        () => ["tickets", "extras"].includes(pathname.split("/")[2]),
        [pathname]
    );

    return (
        <>
            <div className="dashboard_header">
                <div className="fluid_container">
                    <div className="header_row">
                        <div
                            className="hamburger_menu"
                            id="hamburger_menu"
                            onClick={handleHamburgerClick}
                        >
                            {isMenuOpen ? (
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 329.26933 329"
                                    width="512"
                                    height="512"
                                >
                                    <g>
                                        <path
                                            d="m194.800781 164.769531 128.210938-128.214843c8.34375-8.339844 8.34375-21.824219 0-30.164063-8.339844-8.339844-21.824219-8.339844-30.164063 0l-128.214844 128.214844-128.210937-128.214844c-8.34375-8.339844-21.824219-8.339844-30.164063 0-8.34375 8.339844-8.34375 21.824219 0 30.164063l128.210938 128.214843-128.210938 128.214844c-8.34375 8.339844-8.34375 21.824219 0 30.164063 4.15625 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921875-2.089844 15.082031-6.25l128.210937-128.214844 128.214844 128.214844c4.160156 4.160156 9.621094 6.25 15.082032 6.25 5.460937 0 10.921874-2.089844 15.082031-6.25 8.34375-8.339844 8.34375-21.824219 0-30.164063zm0 0"
                                            fill="#000000"
                                        />
                                    </g>
                                </svg>
                            ) : (
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20"
                                    width="512"
                                    height="512"
                                >
                                    <g>
                                        <path
                                            clipRule="evenodd"
                                            d="m3 5c0-.26522.10536-.51957.29289-.70711.18754-.18753.44189-.29289.70711-.29289h12c.2652 0 .5196.10536.7071.29289.1875.18754.2929.44189.2929.70711s-.1054.51957-.2929.70711c-.1875.18753-.4419.29289-.7071.29289h-12c-.26522 0-.51957-.10536-.70711-.29289-.18753-.18754-.29289-.44189-.29289-.70711zm0 5c0-.26522.10536-.51957.29289-.70711.18754-.18753.44189-.29289.70711-.29289h6c.2652 0 .5196.10536.7071.29289.1875.18754.2929.44189.2929.70711 0 .2652-.1054.5196-.2929.7071s-.4419.2929-.7071.2929h-6c-.26522 0-.51957-.1054-.70711-.2929-.18753-.1875-.29289-.4419-.29289-.7071zm0 5c0-.2652.10536-.5196.29289-.7071.18754-.1875.44189-.2929.70711-.2929h12c.2652 0 .5196.1054.7071.2929s.2929.4419.2929.7071-.1054.5196-.2929.7071-.4419.2929-.7071.2929h-12c-.26522 0-.51957-.1054-.70711-.2929-.18753-.1875-.29289-.4419-.29289-.7071z"
                                            fill="#000000"
                                            fillRule="evenodd"
                                        />
                                    </g>
                                </svg>
                            )}
                        </div>
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
                        <div
                            className={`navigation ${isMenuOpen ? "open" : ""}`}
                            id="navigation"
                        >
                            <NavList />
                        </div>

                        <div className="dashboard_content">
                            <div
                                className="dashboard_content_inner"
                                style={{ marginBottom: "50px" }}
                            >
                                {showFilter && <FilterBar />}
                                {children}
                                <CartButton onClick={openCart} />
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
                <button type="submit">Logout</button>
            </form>

            <div className="menu_overlay" id="menu_overlay"></div>
            <InfoModal />
            <AddExtraModal />
            <CartModal open={cartOpen} onClose={closeCart} />
            <PaymentModal open={paymentModalOpen} />
        </>
    );
}

export default DashboardLayout;
