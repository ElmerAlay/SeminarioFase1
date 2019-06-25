const app = require('express')();
const mysql = require('mysql');

const bodyParser = require('body-parser');

app.use(bodyParser.json({
    limit: '8mb'
}));

const PORT = process.env.PORT || 4000;
const HOST = process.env.HOST || '0.0.0.0';

const connection = mysql.createConnection({
    host: process.env.MYSQL_HOST || '172.17.0.2',
    user: process.env.MYSQL_USER || 'root',
    password: process.env.MYSQL_PASSWORD || '1234',
    database: process.env.MYSQL_DATABASE || 'seminario1'
});

connection.connect((err) => {
    if (err) {
        console.error('error al conectar con la base de datos: ', err);
    } else {
        console.log('conección a la base de datos exitosa');
        app.listen(PORT, HOST, (err) => {
            if (err) {
                console.error('Error al iniciar el servidor', err);
            } else {
                console.log('servidor escuchando en el puerto ' + PORT);
            }
        });
    }
});

app.get('/', (req, res) => {
    /*res.json({
        success: true,
        message: 'Hello world'
    });*/
    res.send("Seminario 1\nElmer Edgardo Alay Yupe\n201212945\n")
});

app.post('/agregar', (req, res) => {
    const product = req.body;
    const query = 'INSERT INTO productos values(?, ?)';

    connection.query(query, [product.idproducto, product.nombre], (err, results, fields) => {
        if (err) {
            console.error(err);
            res.json({
                success: false,
                message: 'No se pudo insertar el producto'
            });
        } else {
            /*res.json({
                success: true,
                message: 'Successfully added student'
            });*/
            res.send("Producto agregado correctamente");
        }
    });
});

app.get('/productos', (req, res) => {
    const query = 'SELECT * FROM productos';
    connection.query(query, (err, results, fields) => {
        if (err) {
            console.error(err);
            res.json({
                success: false,
                message: 'No se pueden mostrar los productos'
            });
        } else {
            /*res.json({
                success: true,
                result: results
            });*/
            res.send(results);
        }
    });
});
