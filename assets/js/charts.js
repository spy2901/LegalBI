// Initialize all charts after page load
document.addEventListener("DOMContentLoaded", function () {
  initCharts();
});

// BASE_URL prema tvom projektu
const BASE_URL = "http://localhost:8888/legalBI/";

// Generički loader za bilo koju kolonu iz baze
async function loadChartData(table, column) {
  const response = await fetch(`${BASE_URL}includes/chart_data.php?table=${table}&column=${column}`);
  const data = await response.json();

  if (data.error) {
    console.error(data.error);
    return { labels: [], values: [] };
  }

  return {
    labels: data.map((item) => item.label),
    values: data.map((item) => item.value),
  };
}

// Generički chart creator
async function createChart(canvasId, type, table, column, customOptions = {}, datasetLabel = "") {
  const canvas = document.getElementById(canvasId);
  
  // Check if canvas element exists
  if (!canvas) {
    console.warn(`Canvas element with id '${canvasId}' not found`);
    return;
  }

  const chartData = await loadChartData(table, column);
  const ctx = canvas.getContext("2d");

  // Dataset configuration based on chart type
  let datasetConfig = {
    label: datasetLabel,
    data: chartData.values,
    borderColor: "rgba(255, 255, 255, 0.8)",
    borderWidth: 1,
  };

  if (type === "line") {
    datasetConfig = {
      ...datasetConfig,
      borderColor: "rgba(75, 192, 192, 1)",
      backgroundColor: "rgba(75, 192, 192, 0.1)",
      fill: true,
      tension: 0.4,
      pointRadius: 5,
      pointBackgroundColor: "rgba(75, 192, 192, 1)",
      pointBorderColor: "rgba(255, 255, 255, 1)",
      pointBorderWidth: 2,
      pointHoverRadius: 7,
    };
  } else {
    datasetConfig = {
      ...datasetConfig,
      backgroundColor: chartData.labels.map(
        (_, i) => `hsl(${(i * 360) / chartData.labels.length}, 70%, 50%)`
      ),
    };
  }

  new Chart(ctx, {
    type: type,
    data: {
      labels: chartData.labels,
      datasets: [datasetConfig],
    },
    options: customOptions,
  });
}

// Init all charts
async function initCharts() {
  const chartOptions = {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
      legend: {
        display: true,
        position: "bottom",
      },
    },
  };

  // Cases by Legal Area (doughnut)
  await createChart("casesByArea", "doughnut", "predmeti", "tip_predmeta", chartOptions, "Cases by Area");

  // Cases by Lawyer (horizontal bar)
  await createChart(
    "casesByLawyer",
    "bar",
    "predmeti",
    "advokat", 
    {
      ...chartOptions,
      indexAxis: "y",
      plugins: { legend: { display: false } },
      scales: { x: { beginAtZero: true } },
    },
    "Cases Assigned"
  );
  
  await createChart(
    "casesByLocation",
    "bar",
    "predmeti",
    "lokacija", 
    {
      ...chartOptions,
      indexAxis: "y",
      plugins: { legend: { display: false } },
      scales: { x: { beginAtZero: true } },
    },
    "Cases by Location"
  );

  // New Cases Trend (Monthly) - Spline Chart
  await createChart(
    "newCasesTrend",
    "line",
    "predmeti",
    "monthly_trend",
    {
      ...chartOptions,
      scales: {
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: "Number of Cases"
          }
        },
        x: {
          title: {
            display: true,
            text: "Month"
          }
        }
      },
    },
    "New Cases Trend"
  );

}