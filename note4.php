<html>
<head>
<title>INFO 3300 - Data-driven Web Applications</title>
<link href="https://fonts.googleapis.com/css?family=Alegreya|Alegreya+Sans" rel="stylesheet">
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/styles/default.min.css">
<script src="https://d3js.org/d3.v4.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.9.0/highlight.min.js"></script>
<style>
body { font-family: 'Alegreya Sans', Calibri, sans-serif; }
svg { border: solid #ccc 1px; }
</style>
</head>
<body>
<h3>Prompt for Wednesday, February 7</h3>

<div>
<ul>
  <li>Inspiration: <a href="http://www.informationisbeautiful.net/visualizations/top-500-passwords-visualized/">Passwords you shouldn't use</a></li>
  <li>Make sure today's data file is accessible: <a href="CountryProfile.tsv">country data</a></li>
</ul>
</div>

<div>
</div>

<!-- Here's an SVG element. Note that in this file it looks like the <div> above. -->
<svg height="400" width="400">
  <!-- Visual elements are represented by tags, which have attributes -->
</svg>

<script id="notes">

// var svg = d3.select("svg");
//
// // Create a text element to show country names
// svg.append("text")
// .attr("id", "CountryName")
// .attr("x", 0)
// .attr("y", 300)
// .style("font-size", "48pt");
//
// var countryData;
// var rawData, nestedData;
//
// function parseLine (line) {
//   return { Country: line["Country Name"], Variable: line["Series Name"], value: Number(line["2015 [YR2015]"]) };
// }
//
// // Some data from http://data.worldbank.org/data-catalog/country-profiles
//
// d3.tsv("CountryProfile.tsv", parseLine, function (error, data) {
//   rawData = data;
//   console.log("loaded data")
//
//   nestedData = d3.nest()
//   .key(function (d) { return d.Country; })
//   .entries(data);
//
//   countryData = nestedData.map(function (country) {
//     var result = { Country: country.key };
//
//     country.values.forEach(function (d) {
//       if (d.Variable == "Population, total") {
//         result.Population = d.value;
//       }
//       else if (d.Variable == "GDP (current US$)") {
//         result.GDP = d.value;
//       }
//       else if (d.Variable == "Surface area (sq. km)") {
//         result.Area = d.value;
//       }
//     });
//
//
//     if(result.Country == "Qatar"){
//       result.GDP/=1000000;
//     }
//
//     return result;
//   });
//
//   //countryData = countryData.filter(function (d) { return d.Population && d.GDP; });
//
//   var popExtent = d3.extent(countryData,
//     function (d) { return d.Population;}
//     );
//    console.log(popExtent);
//
//   var popScale = d3.scaleLinear()
//   .domain(popExtent)
//   .range([30,370]);
// var popAxis = d3.axisBottom(popScale);
// svg.append("g").attr("transform","translate(0,370)").call(popAxis);
//
//
//     var gdpExtent = d3.extent(countryData,
//     function (d) { return d.GDP;}
//     );
//   console.log(gdpExtent);
//
//   var gdpScale = d3.scaleLog()
//   .domain(gdpExtent)
//   .range([370,30]);
//   var gdpAxis = d3.axisLeft(gdpScale);
//   svg.append("g").attr("transform","translate(30,0)").call(gdpAxis);
//   areaExtent = d3.extent(countryData,function(d){return d.Area});
//   console.log(areaExtent);
//   var areaScale = d3.scaleSqrt().domain(areaExtent).range([1,30]);
// countryData = countryData.filter(function (d) { return d.Population && d.GDP; });
//
//
//
//   countryData.forEach(function (country) {
//     svg.append("circle")
//     .attr("cx", popScale(country.Population))
//     .attr("cy", gdpScale(country.GDP))
//     .attr("r", areaScale(country.Area))
//     .on("mouseover", function () {
//       svg.select("#CountryName").text(country.Country);
//     });
//   });
// });
//
//
// console.log("after callback")
//
//
var svg = d3.select("svg");

svg.append("text")
.attr("id", "CountryName")
.attr("x", 30)
.attr("y", 50)
.style("font-size", "36pt");

// Define variables outside the scope of the callback function.
var countryData;
var rawData, nestedData;

// This function will be applied to all rows. Select three columns, change names, and convert strings to numbers.
function parseLine (line) {
	return {
		Country: line["Country Name"],
		Variable: line["Series Name"],
		value: Number(line["2015 [YR2015]"])
	};
}

// Some data from http://data.worldbank.org/data-catalog/country-profiles

d3.tsv("CountryProfile.tsv", parseLine, function (error, data) {
	rawData = data;

	console.log("Code in the call-back function is only executed when the data file loads.");

	nestedData = d3.nest()
	.key(function (d) { return d.Country; })
	.entries(data);

	countryData = nestedData.map(function (country) {
		var result = { Country: country.key };

		country.values.forEach(function (d) {
			if (d.Variable == "Population, total") {
				result.Population = d.value;
			}
			else if (d.Variable == "GDP (current US$)") {
				result.GDP = d.value;
			}
			else if (d.Variable == "Surface area (sq. km)") {
				result.Area = d.value;
			}
			else if (d.Variable == "Internet users (per 100 people)") {
				result.Internet = d.value;
			}

		});

		// Fix this here, rather than in the data file.
		if (result.Country == "Qatar") {
			result.GDP /= 1000000;
		}

		return result;
	});

	var popExtent = d3.extent(countryData,
		function (d) { return d.Population; });
	console.log(popExtent);
	var popScale = d3.scaleLog()
	.domain(popExtent)
	.range([30, 370]);

	var popAxis = d3.axisBottom(popScale);
	svg.append("g").attr("transform", "translate(0, 370)").call(popAxis);

	var gdpExtent = d3.extent(countryData,
		function (d) { return d.GDP; });
	console.log(gdpExtent);
	var gdpScale = d3.scaleLog()
	.domain(gdpExtent)
	.range([370, 30]);

	var gdpAxis = d3.axisLeft(gdpScale);
	svg.append("g").attr("transform", "translate(30, 0)").call(gdpAxis);

	var areaExtent = d3.extent(countryData,
		function (d) { return d.Area; });
	console.log(areaExtent);
	var areaScale = d3.scaleSqrt()
	.domain(areaExtent)
	.range([1, 30]);

	var internetScale = d3.scaleLinear()
	.domain([0, 50, 100])
	.range(["#000000", "#ff0000", "#0000ff"]);

	countryData = countryData.filter(function (d) { return d.Population && d.GDP; });

	countryData.forEach(function (country) {
		svg.append("circle")
		.attr("cx", popScale(country.Population))
		.attr("cy", gdpScale(country.GDP))
		.attr("r", areaScale(country.Area))
		.style("opacity", 0.3)
		.style("fill", internetScale(country.Internet))
		.on("mouseover", function () {
			svg.select("#CountryName").text(country.Country);
		});
	});
});

console.log("Code after the d3.tsv() call is executed immediately.");


</script>

<!-- This block will be automatically filled with syntax-highlighted code from the script below -->
<pre><code id="display">
</code></pre>


<script>
document.getElementById("display").innerText = document.getElementById("notes").innerText;
hljs.initHighlightingOnLoad();
// var map = d3.map([{name: "foo"}, {name: "bar"}], function(d) { return d.name; });
// console.log(map);
</script>



</body>
</html>
