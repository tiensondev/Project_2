<div id="monthly-chart" style="height:250px;"></div>

<script>

document.addEventListener("DOMContentLoaded", function () {

    const monthlyRevenue = @json($monthlyRevenue);

    const monthlyLabels = @json($monthlyLabels);

    const options = {

        chart: {
            type: 'area',
            height: 350
        },

        series: [{
            name: 'Revenue',
            data: monthlyRevenue
        }],

        xaxis: {
            categories: monthlyLabels
        }

    };

    const chart = new ApexCharts(
        document.querySelector("#monthly-chart"),
        options
    );

    chart.render();

});

</script>