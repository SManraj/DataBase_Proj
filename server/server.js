const express = require('express');
const cors = require('cors');
const mysql = require('mysql2');
const bodyParser = require('body-parser');
const path = require('path');

// Set up Express app
const app = express();
const port = 3000;

app.use(express.static(path.join(__dirname, 'public')));

// Middleware to allow cross-origin requests
app.use(bodyParser.json()); // For parsing application/json

// Modify the CORS middleware to specify allowed methods and headers
app.use(cors({
    origin: 'http://localhost:8000',  // Allow frontend to access from this URL
    methods: ['GET', 'POST', 'OPTIONS'], // Allow GET, POST, and OPTIONS methods
    allowedHeaders: ['Content-Type', 'Authorization'] // Allow necessary headers
}));

// Handle preflight OPTIONS requests
app.options('*', cors()); // Allows preflight requests for all routes



// MySQL connection setup
const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'password',
  database: 'library',
});

db.connect((err) => {
  if (err) {
    console.log('Error connecting to MySQL:', err);
    return;
  }
  console.log('Connected to MySQL database');
});

// Endpoint to verify user login
app.post('/login', (req, res) => {
  const { username, password } = req.body;

  const query = 'SELECT * FROM User WHERE Email = ? AND PhoneNum = ?';
  db.query(query, [username, password], (err, results) => {
    if (err) {
      res.status(500).send('Database error');
      return;
    }

    if (results.length > 0) {
      res.json({ success: true, user: results[0] });
    } else {
      res.status(401).json({ success: false, message: 'Invalid credentials' });
    }
  });
});

// Endpoint to verify employee login
app.post('/employee-login', (req, res) => {
  const { username, password } = req.body;

  const query = 'SELECT * FROM Employee WHERE Email = ? AND PhoneNum = ?';
  db.query(query, [username, password], (err, results) => {
    if (err) {
      res.status(500).send('Database error');
      return;
    }

    if (results.length > 0) {
      res.json({ success: true, employee: results[0] });
    } else {
      res.status(401).json({ success: false, message: 'Invalid credentials' });
    }
  });
});

// Endpoint to handle book search
app.get('/get-books', (req, res) => {
    const searchOption = req.query.option || 'BookID'; // Default search option is BookID
    const searchValue = req.query.value;

    if (!searchValue) {
        return res.status(400).send('Search value is required');
    }

    let query = `SELECT * FROM Book WHERE ${searchOption} LIKE ?`;

    db.query(query, [`%${searchValue}%`], (err, results) => {
        if (err) {
            return res.status(500).send('Error querying the database');
        }
        res.json(results); // Send results as JSON
    });
});


// Start server
app.listen(port, () => {
  console.log(`Server running on http://localhost:${port}`);
});
