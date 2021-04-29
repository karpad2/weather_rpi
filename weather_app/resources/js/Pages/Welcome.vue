<template>
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
        <div v-if="canLogin" class="hidden fixed top-0 right-0 px-6 py-4 sm:block">            
        </div>

    <div style="height:600px;width: 600px;">
      <h1>Temperature chart</h1>
    <vue3-chart-js
        :id="lineChart.id"
        ref="chartRef"
        :type="lineChart.type"
        :data="lineChart.data"
        :options="lineChart.options"
    ></vue3-chart-js>
  </div>
            <button @click="updateChart">Update Chart</button>
        
        </div>
</template>
<script>
import { ref } from 'vue'
import Vue3ChartJs from '@j-t-mcc/vue3-chartjs'
import axios from 'axios';
export default {
  name: 'App',
  components: {
    Vue3ChartJs,
  },

  data:()=>
  {
    return
    {
    
    }
  },

  setup () {
    const chartRef = ref(null)
    let temp=[],hum=[],hour=[];
  const lineChart = {
      id: 'doughnut',
      type: 'line',
    options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Temperature & Humidity'
      }
    }},
    data: {
        labels: hour,
        //labels: Utils.day({count: 7}),
         datasets: [{
    label: 'Temperature',
    data: temp,
    fill: false,
    borderColor: 'rgb(255, 0, 0)',
    tension: 0.1
  },
  {
    label: 'Humidity',
    data: hum,
    fill: false,
    borderColor: 'rgb(0, 0, 255)',
    tension: 0.1
  },
  ]}
}
  const updateChart = () => {
    var temperatures=[];
     axios.get('/api/get').then(
      function (response)
      {
       temperatures=response.data;
       temperatures.map((item)=>
    {
      lineChart.data.datasets[0].data.push(item.temperature);
      lineChart.data.datasets[1].data.push(item.humidity);
      lineChart.data.labels.push(item.hours);
      console.log(item);
    });
    });
     chartRef.value.update()
    }    
    return {
      lineChart,
      chartRef,
      updateChart
    }

  },
  mounted()
  {
    this.updateChart();
  }
     
}


</script>

