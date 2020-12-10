require('dotenv').config();

var echo = require('laravel-echo-server');
echo.run({
    "authHost": process.env.APP_URL,
    "authEndpoint": "/broadcasting/auth",
    "clients": [],
    "database": "redis",
    "databaseConfig": {
        "redis": {},
        "sqlite": {
            "databasePath": "/database/laravel-echo-server.sqlite"
        }
    },
    "devMode": true,
    "host": null,
    "port": process.env.MIX_SOCKET_PORT,
    "protocol": "http",
    "socketio": {},
    "secureOptions": 67108864,
    "sslCertPath": "",
    "sslKeyPath": "",
    "sslCertChainPath": "",
    "sslPassphrase": "",
    "subscribers": {
        "http": true,
        "redis": true
    },
    "apiOriginAllow": {
        "allowCors": true,
        "allowOrigin": "",
        "allowMethods": "",
        "allowHeaders": ""
    }
});
