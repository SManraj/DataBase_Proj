const express = require("express");
const mysql = require("mysql");
const bodyParser = require("body-parser");
const cors = require("cors");
const bcrypt = require("bcryptjs");

const app = express();
const port = 3000;

// Middleware
app.use(cors());
app.use(bodyParser.json());

// Database Connection
const db = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "password", 
    database: "employee_db",
});

db.connect((err) => {
    if (err) {
        console.error("Error connecting to the database:", err);
        return;
    }
    console.log("Connected to MySQL database.");
});

// Login Endpoint
app.post("/login", (req, res) => {
    const { username, password } = req.body;

    const query = "SELECT * FROM users WHERE username = ?";
    db.query(query, [username], (err, results) => {
        if (err) {
            res.status(500).send("Server error");
            return;
        }

        if (results.length > 0) {
            const user = results[0];

            if (password === user.password) {
                res.json({ success: true, role: user.role });
            } else {
                res.status(401).send("Invalid credentials");
            }
        } else {
            res.status(401).send("Invalid credentials");
        }
    });
});

// Start Server
app.listen(port, () => {
    console.log(`Server running at http://localhost:${port}`);
});
