
                      document.addEventListener('DOMContentLoaded', function() {
    fetch('/monthly-earnings')
        .then(response => response.json())
        .then(data => {
            // Create an array of months from 1 to 12
            const allMonths = Array.from({ length: 12 }, (_, i) => i + 1);

            // Extract the months and earnings from the fetched data
            const monthsWithData = data.map(item => item.month);
            const earnings = data.reduce((acc, item) => {
                acc[item.month] = item.total_earnings;
                return acc;
            }, {});

            // Initialize arrays to store the final months and earnings data
            const months = [];
            const finalEarnings = [];

            // Iterate through all months and assign earnings (or 0 if no earnings exist)
            allMonths.forEach(month => {
                months.push(month);
                finalEarnings.push(earnings[month] || 0);
            });

            const ctx = document.getElementById('monthlyEarningsChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: months,
                    datasets: [{
                        label: 'Monthly Earnings',
                        data: finalEarnings,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching monthly earnings:', error));
});
// 

document.addEventListener('DOMContentLoaded', function() {
    // Fetch daily orders and earnings
    fetch('/daily-orders-and-earnings')
        .then(response => response.json())
        .then(data => {
            const dates = data.map(item => item.date);
            const orders = data.map(item => item.total_orders);
            const earnings = data.map(item => item.total_earnings);

            const ctx = document.getElementById('dailyOrdersAndEarningsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: dates,
                    datasets: [{
                        label: 'Daily Total Orders',
                        data: orders,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    }, {
                        label: 'Daily Total Earnings',
                        data: earnings,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching daily orders and earnings:', error));
});

