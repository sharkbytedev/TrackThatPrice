import { Chart, registerables } from 'chart.js';
import annotationPlugin from 'chartjs-plugin-annotation';
Chart.register(...registerables);
Chart.register(annotationPlugin);


const getIntervalData = (interval_str) => {
    let interval;
    switch (interval_str) {
        case 'daily':
            interval = 8.64e+7;
            break;
        case 'weekly':
            interval = 8.64e+7*7;
            break;
        case 'monthly':
            interval = 8.64e+7* 30.417;
            break;
    }
    let r_timestamps = [];
    let prices = [];
    raw_timestamps.forEach(timestamp => r_timestamps.push(Date.parse(timestamp)));
    let timestamps = [r_timestamps[0]];

    for (let i in r_timestamps) {
        if (timestamps[timestamps.length-1] - r_timestamps[i] >= interval) {
            timestamps.push(r_timestamps[i]);
            prices.push(raw_prices[i])
        }
    }
    return {
        timestamps: timestamps,
        prices: prices
    };
}


const processTimestamps = (r_timestamps, timeFormat='time') => {
    let timestamps = []
    r_timestamps.forEach(timestamp => {
        let d = new Date(timestamp);
        switch (timeFormat) {
            case 'time':
                timestamps.push(`${d.getHours()}:${d.getMinutes()}:${d.getSeconds()}`);
                break;
            case 'date':
                timestamps.push(`${d.getDate()}/${d.getMonth()+1}/${d.getFullYear()}`);
                break;
        }
    });
    return timestamps;
}

const updateChart = (timeInterval, backLimit=0, timeFormat="date") => {
    let data = getIntervalData(timeInterval);
    chart.data.labels = processTimestamps(data.timestamps.slice(0, backLimit), timeFormat);
    chart.data.datasets[0].data = data.prices.slice(0, backLimit);
    chart.update();
}


const config = {
    type: 'line',
    data: {
        labels: [],
        datasets: [{
            label: 'Price',
            data: []
        }],
        backgroundColor: 'rgb(255, 99, 132)',
    },
    options: {}
};

const chart = new Chart(
    document.getElementById('priceHistory'),
    config
);

updateChart("daily", 7);

document.getElementById("YTDButton").onclick = () => {
    updateChart("monthly", 12)
}

document.getElementById("monthButton").onclick = () => {
    updateChart("daily", 30)
}

document.getElementById("weekButton").onclick = () => {
    updateChart("daily", 7)
}