<div id="weekly-chart" style="height:250px;"></div>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const weeklyRevenue = @json($weeklyRevenue);

    const weeklyLabels = @json($weeklyLabels);

    const options = {

        chart: {
            type: 'area',
            height: 350
        },

        series: [{
            name: 'Revenue',
            data: weeklyRevenue
        }],

        xaxis: {
            categories: weeklyLabels
        }

    };

    const chart = new ApexCharts(
        document.querySelector("#weekly-chart"),
        options
    );

    chart.render();

});

</script>