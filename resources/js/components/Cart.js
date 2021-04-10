import React, { useState } from "react";
import {Col, Row} from "react-bootstrap";
import Button from 'react-bootstrap/Button'
import Form from "react-bootstrap/Form";

export default function Carts() {
    const [totalPrice, setTotalPrice] = useState(0)
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
        },
        {
            name: "Chair",
            price: 12
        },
        {
            name: "Table",
            price: 9
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

    // handle click event of the Add button
    const handleAddClick = () => {
        setInputList([
            ...inputList,
            {
                name: "",
                price: 0
            }
        ]);
    };

    // const carttotal = inputList.sum('price'))
    // console.log(inputList.sum('price'))

    console.log(
        inputList.map(item => item.price).reduce((prev, next) => prev + next)
    );

    React.useEffect(() => {
       setTotalPrice(inputList
        .map(item => item.price)
        .reduce((prev, next) => prev + next))
    }, [inputList])
    return (
        <div>
            {/*<Container>*/}
            {/*<Row>*/}
            {/*<Col>NAME: Product 1</Col>*/}
            {/*<Col>PRICE: $500</Col>*/}
            {/*</Row>*/}
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
                        <Form.Group controlId="formBasic">
                            <Form.Control
                                type="number"
                                name="price"
                                onChange={e => handleInputChange(e, i)}
                                defaultValue={x.price}
                            />
                        </Form.Group>
                            </Col>
                        </Row>
                        
                       
                        <div className="add">
                            {inputList.length !== 1 && (
                                <Button variant="danger"
                                    className="mr10"
                                    onClick={() => handleRemoveClick(i)}
                                >
                                    - Remove Carts Items
                                </Button>
                            )}
                            {inputList.length - 1 === i && (
                                <div>
                                    <br></br>
                                <Button variant="primary"
                                 onClick={handleAddClick}>
                                    + Add Cart Items
                                </Button>
                                </div>
                            )}
                        </div>
                    </div>
                );
            })}
            <h2>
                Total Price: $
                {totalPrice}
            </h2>
            <p>Aplly Conpon: </p>
            <Form.Group controlId="formBasic">
                <Form.Control type="text" placeholder="Enter coupon code" />
            </Form.Group>
            {/*</Container>*/}
        </div>
    );
}
