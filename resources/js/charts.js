import Chart from 'chart.js/auto';

// Chart Variables
let revenueChartInstance, provinceInstance, cityInstance, genderInstance, operatorInstance;

// Chart Options for Line Chart
const lineChartOptions = (theme) => {
    const isDark = theme === 'dark';
    const gridColor = isDark ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
    const textColor = isDark ? '#adb5bd' : '#495057';

    return {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: textColor
                }
            }
        },
        scales: {
            y: {
                ticks: { color: textColor },
                grid: { color: gridColor }
            },
            x: {
                ticks: { color: textColor },
                grid: { color: gridColor }
            }
        }
    };
};

// Chart Options for Doughnut Charts
const doughnutChartOptions = (theme) => {
    const textColor = theme === 'dark' ? '#adb5bd' : '#495057';

    return {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    color: textColor
                }
            }
        }
    };
};

// Update Charts Theme
const updateChartsTheme = (theme) => {
    if (revenueChartInstance) {
        revenueChartInstance.options = lineChartOptions(theme);
        revenueChartInstance.update();
    }
    const doughnutOptions = doughnutChartOptions(theme);
    [provinceInstance, cityInstance, genderInstance, operatorInstance].forEach(chart => {
        if (chart) {
            chart.options = doughnutOptions;
            chart.update();
        }
    });
};

// Create Charts
const createCharts = (theme) => {
    // Revenue Chart (Line)
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    revenueChartInstance = new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر'],
            datasets: [{
                label: 'درآمد (میلیون تومان)',
                data: [12, 19, 3, 5, 2, 3, 9], // Mock data for testing
                borderColor: '#F7941D',
                backgroundColor: 'rgba(217, 119, 6, 0.1)',
                fill: true,
                tension: 0.4
            }]
        },
        options: lineChartOptions(theme)
    });

    // Chart 1: Customer Distribution (Doughnut)
    const provinceCtx = document.getElementById('provinceChart').getContext('2d');
    provinceInstance = new Chart(provinceCtx, {
        type: 'doughnut',
        data: {
            labels: ['تهران', 'اصفهان', 'فارس'],
            datasets: [{
                label: 'توزیع کاربران',
                data: [300, 50, 100], // Mock data for testing
                hoverOffset: 4
            }]
        },
        options: doughnutChartOptions(theme)
    });

    // Chart 2: Revenue Analysis (Doughnut)
    const cityCtx = document.getElementById('cityChart').getContext('2d');
    cityInstance = new Chart(cityCtx, {
        type: 'doughnut',
        data: {
            labels: ['تهران', 'تبریز', 'اصفهان'],
            datasets: [{
                label: 'توزیع کاربران',
                data: [120, 80, 30], // Mock data for testing
                hoverOffset: 4
            }]
        },
        options: doughnutChartOptions(theme)
    });

    // Chart 3: Ad Status (Doughnut)
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    genderInstance = new Chart(genderCtx, {
        type: 'doughnut',
        data: window.genderData || {
            labels: ['مرد', 'زن', 'نامعلوم'],
            datasets: [{
                label: 'توزیع جنسیت',
                data: [500, 200, 50], // Mock data for testing
                backgroundColor: ['#36A2EB', '#FF6384', '#BBBBBB'],
                hoverOffset: 4
            }]
        },
        options: doughnutChartOptions(theme)
    });

    // Chart 4: Support Tickets (Doughnut)
    const operatorCtx = document.getElementById('operatorChart').getContext('2d');
    operatorInstance = new Chart(operatorCtx, {
        type: 'doughnut',
        data: window.operatorData || {
            labels: ['همراه اول', 'ایرانسل', 'رایتل', 'سایر'],
            datasets: [{
                label: 'توزیع اپراتور',
                data: [25, 40, 10, 2], // Mock data for testing
                backgroundColor: ['#54c5d0', '#febe10', '#800080', '#BBBBBB'],
                hoverOffset: 4
            }]
        },
        options: doughnutChartOptions(theme)
    });
};

// برای آپدیت real-time، می‌تونی یک فانکشن آپدیت اضافه کنی
const updateChartsData = () => {
    if (revenueChartInstance) revenueChartInstance.data = window.revenueData;
    if (provinceInstance) provinceInstance.data = window.provinceData;
    if (cityInstance) cityInstance.data = window.cityData;
    if (genderInstance) genderInstance.data = window.genderData;
    if (operatorInstance) operatorInstance.data = window.operatorData;
    [revenueChartInstance, provinceInstance, cityInstance, genderInstance, operatorInstance].forEach(chart => chart?.update());
};

// Initialize Charts
const initCharts = () => {
    const savedTheme = localStorage.getItem('theme') || 'light';
    createCharts(savedTheme);
};

// Export functions for external use
export { createCharts, updateChartsTheme, initCharts };
