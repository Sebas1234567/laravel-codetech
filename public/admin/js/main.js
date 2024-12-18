/* global Chart, coreui */

/**
 * --------------------------------------------------------------------------
 * CoreUI Boostrap Admin Template (v4.3.0): main.js
 * License (https://coreui.io/pro/license)
 * --------------------------------------------------------------------------
 */

// Disable the on-canvas tooltip

Chart.defaults.pointHitDetectionRadius = 1;
Chart.defaults.plugins.tooltip.enabled = false;
Chart.defaults.plugins.tooltip.mode = 'index';
Chart.defaults.plugins.tooltip.position = 'nearest';
Chart.defaults.plugins.tooltip.external = coreui.ChartJS.customTooltips;
Chart.defaults.color = coreui.Utils.getStyle('--cui-body-color');

// console.log(Chart.defaults.color)

document.body.addEventListener('themeChange', () => {
  cardChart1.data.datasets[0].pointBackgroundColor = coreui.Utils.getStyle('--cui-primary');
  cardChart2.data.datasets[0].pointBackgroundColor = coreui.Utils.getStyle('--cui-info');
  mainChart.options.scales.x.ticks.color = coreui.Utils.getStyle('--cui-body-color');
  mainChart.options.scales.y.ticks.color = coreui.Utils.getStyle('--cui-body-color');
  cardChart1.update();
  cardChart2.update();
  mainChart.update();
});
const random = (min, max) =>
// eslint-disable-next-line no-mixed-operators
Math.floor(Math.random() * (max - min + 1) + min);
//# sourceMappingURL=main.js.map