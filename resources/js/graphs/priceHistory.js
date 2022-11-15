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
                timestamps.push(d.toLocaleString('en-us', {month: 'short', day: 'numeric', year: 'numeric'}));
                break;
            case 'day':
                timestamps.push(d.toLocaleString('en-us', {weekday: 'short', month: 'short', 'day': 'numeric'}));
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
            data: [],
            pointBackgroundColor: '#2877f7',
            pointBorderColor: '#4389fa',
            borderColor: '#2877f7',
            backgroundColor: '#2877f7'
        }],
        backgroundColor: 'rgb(255, 99, 132)',
    },
    options: {
        responsive: true,
        plugins: {
            annotation: {
                annotations: [
                    {
                        type: 'line',
                        yMin: 0,
                        yMax: 0,
                        borderColor: 'rgb(0, 255, 0)',
                        borderWidth: 2,
                        display: raw_target_data ? true : false
                    }
                ]
            }
        }
    }
};

const chart = new Chart(
    document.getElementById('priceHistory'),
    config
);

if (raw_target_data) {
    let timestamps = [];
    let target_date = Date.parse(raw_target_data.compare_time);
    raw_timestamps.forEach(t => timestamps.push(Date.parse(t)));
    let closestIndex = 0;
    for (let t in timestamps) {
        if (t === 0) continue;
        if (Math.abs(target_date - timestamps[t]) < Math.abs(target_date - timestamps[closestIndex])) {
            closestIndex = t;
        }
    }
    let compare_price = raw_prices[closestIndex];
    let line_height = null;
    switch (raw_target_data.type) {
        case 'flat':
            line_height = compare_price - raw_target_data.threshold;
            break;
        case 'percent':
            line_height = compare_price - ((compare_price * raw_target_data.threshold) / 100)
    }
    chart.options.plugins.annotation.annotations[0].yMin = line_height;
    chart.options.plugins.annotation.annotations[0].yMax = line_height;
    console.log(raw_target_data.type)
    chart.update();
}

updateChart("daily", 7);

document.getElementById("YTDButton").onclick = () => {
    updateChart("monthly", 12)
}

document.getElementById("monthButton").onclick = () => {
    updateChart("daily", 30)
}

document.getElementById("weekButton").onclick = () => {
    updateChart("daily", 7, 'day')
}