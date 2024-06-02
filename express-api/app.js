const express = require('express');
const promMid = require('express-prometheus-middleware');

const app = express();

app.use(promMid({
    metricsPath: '/metrics',
    collectDefaultMetrics: true,
    requestDurationBuckets: [0.1, 0.5, 1, 1.5],
}));

app.get('/', (req, res) => {
    res.send('Hello World!');
});

app.listen(3000, () => {
    console.log('Express app listening on port 3000!');
});
