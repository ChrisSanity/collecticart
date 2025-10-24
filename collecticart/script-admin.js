// Sample Data (replace with dynamic data later if needed)
const data = [10, 20, 30, 40, 50];

// === Responsive Graph Functions ===

// Bar Graph
function createBarGraph() {
  const barDiv = document.getElementById("barGraph");
  const width = barDiv.clientWidth;
  const height = barDiv.clientHeight;

  // Clear previous graph
  d3.select("#barGraph").selectAll("*").remove();

  const barSvg = d3.select("#barGraph")
    .append("svg")
    .attr("width", width)
    .attr("height", height);

  const barWidth = width / data.length - 20;

  barSvg.selectAll("rect")
    .data(data)
    .enter()
    .append("rect")
    .attr("x", (d, i) => i * (width / data.length) + 10)
    .attr("y", d => height - d * 5)
    .attr("width", barWidth)
    .attr("height", d => d * 5)
    .attr("rx", 6) // rounded corners
    .attr("fill", "#ff6f61"); // coral
}

// Line Graph
function createLineGraph() {
  const lineDiv = document.getElementById("lineGraph");
  const width = lineDiv.clientWidth;
  const height = lineDiv.clientHeight;

  d3.select("#lineGraph").selectAll("*").remove();

  const lineSvg = d3.select("#lineGraph")
    .append("svg")
    .attr("width", width)
    .attr("height", height);

  const line = d3.line()
    .x((d, i) => i * (width / data.length))
    .y(d => height - d * 5);

  lineSvg.append("path")
    .datum(data)
    .attr("fill", "none")
    .attr("stroke", "#c56127") // orange accent
    .attr("stroke-width", 3)
    .attr("d", line);

  // Add circles at data points
  lineSvg.selectAll("circle")
    .data(data)
    .enter()
    .append("circle")
    .attr("cx", (d, i) => i * (width / data.length))
    .attr("cy", d => height - d * 5)
    .attr("r", 5)
    .attr("fill", "#ff6f61");
}

// Area Graph
function createAreaGraph() {
  const areaDiv = document.getElementById("areaGraph");
  const width = areaDiv.clientWidth;
  const height = areaDiv.clientHeight;

  d3.select("#areaGraph").selectAll("*").remove();

  const areaSvg = d3.select("#areaGraph")
    .append("svg")
    .attr("width", width)
    .attr("height", height);

  const area = d3.area()
    .x((d, i) => i * (width / data.length))
    .y0(height)
    .y1(d => height - d * 5);

  areaSvg.append("path")
    .datum(data)
    .attr("fill", "#ffb199") // soft coral fill
    .attr("stroke", "#ff6f61")
    .attr("stroke-width", 2)
    .attr("d", area);
}

// === Initialize Graphs ===
function renderGraphs() {
  createBarGraph();
  createLineGraph();
  createAreaGraph();
}

// Render on load
renderGraphs();

// Re-render on window resize (responsive)
window.addEventListener("resize", renderGraphs);
