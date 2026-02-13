
-- Table: Animals
CREATE TABLE Animals (
    animalid INT(255) PRIMARY KEY,
    name VARCHAR(100),
    imagename VARCHAR(100)
);

-- Table: Products
CREATE TABLE Products (
    prodid INT(255) PRIMARY KEY,
    animalid INT(255),
    name VARCHAR(100),
    company VARCHAR(100),
    qty INT(255),
    mrp INT(255),
    dateCreated DATETIME,
    imagename VARCHAR(100),
    FOREIGN KEY (animalid) REFERENCES Animals(animalid)
);

-- Table: UserDetails
CREATE TABLE UserDetails (
    userid INT(255) PRIMARY KEY,
    fname VARCHAR(100),
    lname VARCHAR(100),
    emailid VARCHAR(100)
);

-- Table: Address
CREATE TABLE Address (
    userid INT(100) PRIMARY KEY,
    fname VARCHAR(100),
    lname VARCHAR(100),
    country VARCHAR(100),
    street VARCHAR(500),
    apt VARCHAR(255),
    city VARCHAR(25),
    zipcode INT(10),
    phone VARCHAR(15),
    email VARCHAR(100),
    payment_method VARCHAR(25),
    FOREIGN KEY (userid) REFERENCES UserDetails(userid)
);

-- Table: Credentials
CREATE TABLE Credentials (
    userid INT(255),
    emailid VARCHAR(100),
    password VARCHAR(100),
    FOREIGN KEY (userid) REFERENCES UserDetails(userid)
);

-- Table: Users (for login/signup)
CREATE TABLE Users (
    username VARCHAR(25) PRIMARY KEY,
    firstName VARCHAR(50),
    lastName VARCHAR(50),
    email VARCHAR(200),
    password VARCHAR(32),
    signUpDate DATETIME,
    profilePic VARCHAR(500)
);

-- Table: Cart
CREATE TABLE Cart (
    userid INT(255),
    prodid INT(255),
    qty INT(255),
    mrp VARCHAR(255),
    FOREIGN KEY (userid) REFERENCES UserDetails(userid),
    FOREIGN KEY (prodid) REFERENCES Products(prodid)
);

-- Table: Orderlist
CREATE TABLE Orderlist (
    orderid INT(255) PRIMARY KEY,
    userid INT(255),
    user_email VARCHAR(255),
    prodid INT(255),
    prod_name VARCHAR(255),
    prod_company VARCHAR(255),
    qty INT(255),
    total_amt INT(255),
    status VARCHAR(255),
    FOREIGN KEY (userid) REFERENCES UserDetails(userid),
    FOREIGN KEY (prodid) REFERENCES Products(prodid)
);
