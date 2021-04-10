import React, { useState } from "react";
import {Form, Col, Row, InputGroup, Alert, Button} from "react-bootstrap";
import axios from "axios";

export default function Carts() {
    const [totalPrice, setTotalPrice] = useState(0);
    const [coupon, setCoupon] = useState("");
    const [priceNow, setPriceNow] = useState(0);
    const [shows, setShows]= useState(false)
    const [showSuccess, setShowSuccess]= useState(false)
    const [messageError, setMessageError] = useState('')
    const [discount, setDiscount] = useState(0)
    const [newPrice, setNewPrice] = useState(0)
    const [inputList, setInputList] = useState([
        {
            name: "Bag",
            price: 20
        },
        {
            name: "Cloth 1",
            price: 10
        },
        {
            name: "Skirt",
            price: 40
        }
    ]);

    // handle input change
    const handleInputChange = (e, index) => {
        const { name, value } = e.target;
        const list = [...inputList];
        list[index][name] = value;
        setInputList(list);
    };

    // handle click event of the Remove button
    const handleRemoveClick = index => {
        const list = [...inputList];
        list.splice(index, 1);
        setInputList(list);
    };

    function handleInputChangeCoupon(e) {
        setCoupon(e.target.value);
    }

    // handle click event of the Add button
    const handleAddClick = () => {
        setInputList([
            ...inputList,
            {
                name: "product name",
                price: 0
            }
        ]);
    };

    console.log(
        inputList.map(item => item.price).reduce((prev, next) => prev + next)
    );

    const data = {
        coupon_code: coupon,
        items_no: inputList.length,
        cart_total_price: totalPrice
    };
    console.log(data)
    function validateCoupon() {
        axios.post("/api/validate_coupon",data)
            .then(function (response) {
                console.log(response);
                setShowSuccess(true)
                setPriceNow(response.data.data.amount_remain)
                setNewPrice(response.data.data.amount_remain)
                setDiscount(response.data.data.amount_discount)
            })
            .catch(function (error) {
                setPriceNow(0)
                setShows(true)
                setMessageError(error.response.data.message)
                console.log(error.response.data.message);
            });
    }
    
    function AlertError(props) {
        const [show, setShow]= useState(true)
        if (show) {
          return (
            <Alert variant="danger" onClose={() => setShow(false)} dismissible>
              <Alert.Heading>Oh snap! You got an error!</Alert.Heading>
              <p>
                {props.message}
              </p>
            </Alert>
          );
        }
    }

    function AlertSuccess(props) {
        const [showSuccesss, setShowSuccesss]= useState(true)
        if (showSuccesss) {
          return (
            <Alert variant="success" onClose={() => setShowSuccesss(false)} dismissible>
              <Alert.Heading>How's it going?!!</Alert.Heading>
              <p>
                You got discount of ${props.discount}
              </p>
              <p>
                Your new price is ${props.newPrice}
              </p>
            </Alert>
          );
        }
    }

    React.useEffect(() => {
        setTotalPrice(
            inputList
                .map(item => item.price)
                .reduce((prev, next) => prev + next)
        );
    }, [inputList]);
    return (
        <div>
        {shows && <AlertError message={messageError} />} 
        {showSuccess && <AlertSuccess discount={discount} newPrice={newPrice} />}
            {inputList.map((x, i) => {
                return (
                    <div>
                        <Row>
                            <Col>
                                <p>Name:</p>
                                <Form.Group controlId="formBasic">
                                    <Form.Control
                                        type="text"
                                        name="name"
                                        onChange={e => handleInputChange(e, i)}
                                        value={x.name}
                                    />
                                </Form.Group>
                            </Col>
                            <Col>
                                <p>Price:</p>
                                <InputGroup className="mb-2 mr-sm-2">
                                    <InputGroup.Prepend>
                                    <InputGroup.Text>$</InputGroup.Text>
                                    </InputGroup.Prepend>
                                    <Form.Control
                                        type="number"
                                        name="price"
                                        onChange={e => handleInputChange(e, i)}
                                        defaultValue={x.price}
                                    />                                </InputGroup>
                                
                            </Col>
                        </Row>

                        <div className="add">
                            {inputList.length !== 1 && (
                                <Button
                                    variant="danger"
                                    className="mr10"
                                    onClick={() => handleRemoveClick(i)}
                                >
                                    - Remove Carts Items
                                </Button>
                            )}
                            {inputList.length - 1 === i && (
                                <div>
                                    <br></br>
                                    <Button
                                        variant="primary"
                                        onClick={handleAddClick}
                                    >
                                        + Add Cart Items
                                    </Button>
                                </div>
                            )}
                        </div>
                    </div>
                );
            })}
            <h2>Total Price: ${totalPrice}</h2>
            <p>Aplly Conpon: </p>
            <Form.Group controlId="formBasic">
                <Form.Control
                    type="text"
                    name="coupon"
                    onChange={e => handleInputChangeCoupon(e)}
                    onMouseOut={() => validateCoupon()}
                    value={coupon}
                />
            </Form.Group>
            {/*</Container>*/}
            <h2>New Price: ${priceNow}</h2>
            <br></br>
        </div>
    );
}
