import React, { useEffect, useState } from "react";
import "./Scanner.css";
import axios from "axios";
import { useFetch } from "../../lib/hooks/useFetch";
import { Button, Form, InputGroup } from "react-bootstrap";
import QrScanner from "qr-scanner";
import { toast } from "react-toastify";
import { useCart } from "react-use-cart";
import { useDispatch } from "react-redux";
import { setCartOpen } from "../../lib/features/paymentModalSlice";

const Scanner = () => {
    const videoRef = React.useRef(null);
    const [scanner, setScanner] = useState(null);

    useEffect(() => {
        if (videoRef.current && !scanner) {
            const qrScanner = new QrScanner(
                videoRef.current,
                (result) => {
                    // console.log(result);
                    handleScan(result);
                },
                { highlightScanRegion: true, highlightCodeOutline: true }
            );
            setScanner(qrScanner);
        }
        return () => {
            if (scanner) {
                scanner.stop(); // Stop the scanner
                scanner.destroy(); // Destroy scanner instance
                setScanner(null); // Reset scanner to null
            }
        };
    }, [videoRef.current, scanner]);

    const handleStartScan = () => {
        if (scanner) {
            scanner.start();
            setStartScan(true);
        } else {
            console.error("Scanner is not initialized yet");
        }
    };

    const [startScan, setStartScan] = useState(false);
    const [scannedTicket, setScannedTicket] = useState({
        id: 635,
        owner: {
            name: "Carissa",
            email: "",
            vatNumber: "",
            address: "",
        },
        event_id: 63,
        event_name: "Essência do Vinho - Lisboa",
        even: {
            id: 63,
            thumbnail: "events/August2024/jVJ3G4ywG5O0LBTJwe5x.png",
            name: "Essência do Vinho - Lisboa",
            slug: "essencia-do-vinho-lisboa",
            organizer: "Essência Company",
            country: "Portugal",
            city: "Lisboa",
            location: "Centro de Congressos de Lisboa (Junqueira)",
            description:
                "<p>O Encontro da Revista de Vinhos surge em 2022 com um novo nome e passa a integrar o circuito da principal experi&ecirc;ncia do vinho em Portugal, que j&aacute; conta eventos no Porto e na Madeira.</p>\r\n<p>Consulte a programa&ccedil;&atilde;o da 25a edi&ccedil;&atilde;o em essenciadovinho.com e prepare a sua visita. Grandes nomes, novos valores, convidados internacionais, provas comentadas, conversas com sommeliers, a reuni&atilde;o de produtores de matriz alternativa no &ldquo;Mundo Natural&rdquo;...</p>\r\n<p>Para ser um grande sucesso s&oacute; falta mesmo a sua visita, de 9 a 11 de novembro no Centro de Congressos de Lisboa, na Junqueira.</p>\r\n<p>Estamos juntos!</p>",
            start_at: "2024-11-09T21:00:00.000000Z",
            end_at: "2024-11-12T00:00:00.000000Z",
            status: 1,
            featured: 1,
            terms: "<ul>\r\n<li>O bilhete de acesso &eacute; individual e corresponde a uma entrada.&nbsp;</li>\r\n<li>O bilhete de acesso comprado confere um copo oficial do evento.</li>\r\n<li>N&atilde;o se efetuam trocas e/ou devolu&ccedil;&otilde;es de bilhetes.</li>\r\n<li>N&atilde;o &eacute; permitida a entrada de pessoas acompanhadas de animais excepto nos casos previstos por lei.</li>\r\n<li>N&atilde;o &eacute; permitida a entrada de pessoas munidas de objetos perigosos.</li>\r\n<li>N&atilde;o &eacute; permitido o consumo de bebidas alco&oacute;licas por menores de 18 anos e a todos os que apresentarem sinais de embriaguez ou de aparente anomalia ps&iacute;quica.&nbsp;</li>\r\n<li>Na sua qualidade de organizadora do evento, a Ess&ecirc;ncia Company reserva-se o direito de recusar a entrada e/ou expulsar qualquer pessoa que apresente comportamento indevido e inapropriado, prejudicando o bom funcionamento do evento e/ou causando um risco &agrave; seguran&ccedil;a de outros participantes. Aqui se inclui, mas n&atilde;o se limita a, comportamento agressivo, uso de drogas ilegais ou porte de objetos perigosos.&nbsp;</li>\r\n<li>A organiza&ccedil;&atilde;o reserva-se no direito de alterar o programa sem aviso pr&eacute;vio.</li>\r\n<li>Exist&ecirc;ncia do livro de reclama&ccedil;&otilde;es &ndash; O Decreto-lei n&ordm; 156/2005, de 15 de Setembro, alterado pelos Decretos-Lei n&ordm; 371/2007 de 06 de Novembro n&ordm; 118/2009 de 19 de Maio</li>\r\n<li>Exist&ecirc;ncia de tabela de pre&ccedil;os.</li>\r\n</ul>",
            created_at: "2024-08-06T13:57:35.000000Z",
            updated_at: "2024-10-10T18:56:43.000000Z",
        },
        product_id: 784,
        product_name: "Prova Comentada 05 - Stag´s Leap",
        order_id: 291,
        user_id: null,
        ticket: "66f80ba226150",
        status: 0,
        dates: ["2024-11-09"],
        price: 35,
        created_at: "2024-10-14T07:38:59.000000Z",
        updated_at: "2024-10-14T08:15:09.000000Z",
        type: "paid",
        logs: [],
        active: 1,
        check_in_zone: null,
        check_out_zone: null,
        hasExtras: 0,
        extras: [],
    });

    const handleScan = async (data) => {
        if (!data?.data) return;

        try {
            const response = await axios.post(
                `${import.meta.env.VITE_APP_URL}/api/tickets/get`,
                { ticket: data?.data }
            );
            setScannedTicket(response.data);
        } catch (error) {
            toast("Error scanning ticket", error);
        }
    };

    const handleExtraChange = (targetExtra, quantity) => {
        const targetExtraQuantity = parseInt(targetExtra?.qty) ?? 0;
        quantity = parseInt(quantity);
        if (quantity < targetExtraQuantity) return;
        targetExtra = { ...targetExtra, newQty: quantity };

        var ticketExtras = scannedTicket.extras.map((item) => {
            if (item.id === targetExtra.id) {
                return targetExtra;
            }
            return item;
        });
        setScannedTicket((prev) => {
            return { ...prev, extras: [...ticketExtras] };
        });
    };
    const {
        data: extrasList,
        isError,
        isLoading,
        isSuccess,
        refetch,
    } = useFetch(
        ["scanner-extras", scannedTicket],
        `${import.meta.env.VITE_APP_URL}/api/event-extras/${
            scannedTicket?.event_id
        }`
    );

    const [showNewExtraFields, setShowNewExtraFields] = useState(false);
    const [selectedNewExtra, setSelectedNewExtra] = useState(null);
    const [selectedNewExtraQuantity, setSelectedNewExtraQuantity] = useState(1);

    const handleAddExtra = () => {
        if (!showNewExtraFields) {
            setShowNewExtraFields(true);
            return;
        }
        const targetExtra = {
            ...selectedNewExtra,
            qty: 0,
            newQty: selectedNewExtraQuantity,
        };
        var isUniqueItem = true;

        var ticketExtras = scannedTicket?.extras?.map((item) => {
            if (item.id === targetExtra.id) {
                isUniqueItem = false;
                return {
                    ...item,
                    newQty:
                        targetExtra.newQty + (item?.newQty ?? item?.qty ?? 0),
                };
            }
            return item;
        });
        if (isUniqueItem) {
            ticketExtras = [...ticketExtras, targetExtra];
        }
        setScannedTicket((prev) => {
            return { ...prev, extras: [...ticketExtras] };
        });
        setShowNewExtraFields(false);
        setSelectedNewExtra(null);
        setSelectedNewExtraQuantity(1);
    };

    const [changesProcessing, setChangesProcessing] = useState(false);

    const { addItem } = useCart();
    const dispatch = useDispatch();

    const submitChanges = async () => {
        var newAddedExtras = scannedTicket?.extras?.map((item) => {
            if (item?.newQty > 0)
                return { ...item, qty: item?.newQty - (item?.qty ?? 0) };
        });

        if (newAddedExtras?.length) {
            newAddedExtras.forEach((item) => {
                addItem(item, item?.qty);
            });
            dispatch(setCartOpen(true));
        }

        return;
        setChangesProcessing(true);
        const response = await axios.post(
            `${import.meta.env.VITE_APP_URL}/api/update-ticket`,
            { ticket: scannedTicket },
            {
                headers: {
                    "Content-Type": "application/json",
                    "X-Secret-Key": "pos_password",
                },
            }
        );
        if (response.status == 200) {
            setScannedTicket(null);
            setStartScan(false);

            toast("Ticket updated successfully!!");
            if (scanner) {
                scanner.stop();
                const newScanner = new QrScanner(
                    videoRef.current,
                    (result) => {
                        handleScan(result);
                    },
                    { highlightScanRegion: true, highlightCodeOutline: true }
                );
                setScanner(newScanner);
                newScanner.start();
            }
        }
        setChangesProcessing(false);
    };

    const activateTicket = async () => {
        setChangesProcessing(true);
        const response = await axios.post(
            `${import.meta.env.VITE_APP_URL}/api/tickets/activate`,
            { ticket: scannedTicket?.id },
            {
                headers: {
                    "Content-Type": "application/json",
                    "X-Secret-Key": "pos_password",
                },
            }
        );
        if (response.status == 200) {
            setScannedTicket(response?.data?.ticket);
            toast("Ticket activated successfully!!");
        }
        setChangesProcessing(false);
    };

    return (
        <section className="scanner-page">
            {scannedTicket ? (
                <div className="ticket-info">
                    <h3>Ticket Information</h3>
                    <div className="ticket-details">
                        <p>
                            <strong>Owner:</strong> {scannedTicket?.owner.name}
                        </p>
                        {scannedTicket?.owner.email && (
                            <p>
                                <strong>Email:</strong>{" "}
                                {scannedTicket?.owner.email}
                            </p>
                        )}
                        <p>
                            <strong>Event:</strong> {scannedTicket?.event_name}
                        </p>
                        <p>
                            <strong>Ticket:</strong>{" "}
                            {scannedTicket?.product_name}
                        </p>
                        <p>
                            <strong>Price:</strong> €{scannedTicket?.price}
                        </p>
                        <p>
                            <strong>Status:</strong>{" "}
                            {scannedTicket?.status === 0 ? "Not Used" : "Used"}
                        </p>
                        <p>
                            <strong>Dates:</strong>{" "}
                            {scannedTicket?.dates.join(", ")}
                        </p>
                        <p>
                            <strong>
                                {scannedTicket?.active === 0 && "Not "}Active
                                {scannedTicket?.active === 0 && (
                                    <span
                                        className="btn btn-success ms-3 py-1 px-2"
                                        onClick={activateTicket}
                                    >
                                        Activate
                                    </span>
                                )}
                            </strong>
                        </p>
                    </div>

                    {scannedTicket?.extras?.length > 0 ? (
                        <div className="extras">
                            <h4>Extras</h4>
                            <ul>
                                {scannedTicket?.extras.map((extra, index) => {
                                    const quantity = parseInt(
                                        extra?.newQty ?? extra?.qty ?? 0
                                    );
                                    const price = parseFloat(
                                        extra?.price ?? 0
                                    ).toFixed(2);
                                    return (
                                        <span
                                            key={index}
                                            className="d-flex justify-content-between align-items-center"
                                        >
                                            <span className="col-md-3 text-start">
                                                {extra?.display_name}
                                            </span>
                                            <div className="update-quantity d-flex align-items-center justify-content-center col-md-3">
                                                <button
                                                    className="btn btn-outline-danger btn-sm"
                                                    onClick={() =>
                                                        handleExtraChange(
                                                            extra,
                                                            quantity - 1
                                                        )
                                                    }
                                                >
                                                    -
                                                </button>
                                                <input
                                                    type="number"
                                                    value={quantity}
                                                    onChange={(e) =>
                                                        handleExtraChange(
                                                            extra,
                                                            e.target.value
                                                        )
                                                    }
                                                    className="form-control text-center mx-2 border-0"
                                                    style={{ width: "40px" }}
                                                />
                                                <button
                                                    className="btn btn-outline-dark btn-sm"
                                                    onClick={() =>
                                                        handleExtraChange(
                                                            extra,
                                                            quantity + 1
                                                        )
                                                    }
                                                >
                                                    +
                                                </button>
                                            </div>
                                            <span className="col-md-3 text-end">
                                                {"X "}
                                                {price}
                                                {"€ ="}
                                            </span>
                                            <span className="col-md-3 text-end">
                                                {price *
                                                    parseInt(
                                                        extra?.newQty
                                                            ? extra?.newQty -
                                                                  extra?.qty
                                                            : 0
                                                    )}
                                                €
                                            </span>
                                        </span>
                                    );
                                })}
                            </ul>
                        </div>
                    ) : null}
                    {showNewExtraFields && (
                        <div className="modal-body row">
                            <div className="col-md-12">
                                <div className="form-group">
                                    <label htmlFor="extraSelect">
                                        Select Extra
                                    </label>
                                    <select
                                        id="extraSelect"
                                        className="form-control mt-2"
                                        value={
                                            selectedNewExtra?.display_name || ""
                                        }
                                        onChange={(e) => {
                                            const selectedOption =
                                                extrasList?.data?.find(
                                                    (extra) =>
                                                        extra.display_name ===
                                                        e.target.value
                                                );
                                            setSelectedNewExtra(
                                                selectedOption || null
                                            );
                                        }}
                                    >
                                        <option value="">None</option>
                                        {extrasList?.data?.map(
                                            (extra, index) => (
                                                <option
                                                    key={index}
                                                    value={extra?.display_name}
                                                >
                                                    {extra?.display_name}
                                                </option>
                                            )
                                        )}
                                    </select>
                                </div>

                                {selectedNewExtra && (
                                    <>
                                        <div className="form-group mt-3 d-flex flex-column justify-content-center align-items-center">
                                            <label htmlFor="quantity">
                                                Quantity
                                            </label>
                                            <InputGroup className="w-50">
                                                <Button
                                                    variant="outline-secondary"
                                                    onClick={() =>
                                                        setSelectedNewExtraQuantity(
                                                            (prev) =>
                                                                prev - 1 > 0
                                                                    ? prev - 1
                                                                    : prev
                                                        )
                                                    }
                                                >
                                                    -
                                                </Button>
                                                <Form.Control
                                                    aria-label="Example text with two button addons"
                                                    className="text-center"
                                                    readOnly
                                                    value={
                                                        selectedNewExtraQuantity
                                                    }
                                                />
                                                <Button
                                                    variant="outline-danger"
                                                    onClick={() =>
                                                        setSelectedNewExtraQuantity(
                                                            (prev) => prev + 1
                                                        )
                                                    }
                                                >
                                                    +
                                                </Button>
                                            </InputGroup>
                                        </div>
                                        <label htmlFor="price">
                                            Price
                                            <br />
                                            {selectedNewExtra?.price *
                                                selectedNewExtraQuantity}
                                            €
                                        </label>
                                    </>
                                )}
                            </div>
                        </div>
                    )}
                    <span className="d-flex justify-content-center align-items-center mt-2">
                        <button
                            type="button"
                            class="btn btn-info text-light w-100 py-1"
                            onClick={handleAddExtra}
                        >
                            Add extra
                        </button>
                    </span>
                    <span className="d-flex justify-content-center align-items-center mt-2">
                        <button
                            type="button"
                            class="btn btn-success text-light w-100 py-1"
                            onClick={submitChanges}
                        >
                            {changesProcessing
                                ? "Processing..."
                                : "Save Changes"}
                        </button>
                    </span>
                </div>
            ) : !startScan ? (
                <div className="qr-box flex-column" onClick={handleStartScan}>
                    <img
                        className="qr-image"
                        src="/assets/qr-code.png"
                        alt="QR Code"
                    />
                    <h3>Tap to start scanning</h3>
                </div>
            ) : (
                ""
            )}
            {!scannedTicket && (
                <div
                    id="viewfinder"
                    className="qr-box"
                    style={!startScan ? { display: "none" } : {}}
                >
                    <video ref={videoRef}>
                        Your browser does not support video playback.
                    </video>
                </div>
            )}
        </section>
    );
};

export default Scanner;
