<template>
  <div class="map-container" ref="mapContainer"></div>
</template>

<script setup>
import { onMounted, ref } from 'vue';

const mapContainer = ref(null);
const apiKey = 'AIzaSyDOPwnhnuLNUlt33rCzH8t1kQZt5VZbVpM'; // Substitua com a sua chave de API

onMounted(() => {
  // Assegura que a API do Google Maps esteja carregada
  if (!window.google) {
    const script = document.createElement('script');
    script.src = `https://maps.googleapis.com/maps/api/js?key=${apiKey}&callback=initMap`;
    script.async = true;
    script.defer = true;
    window.initMap = initMap; // Callback de inicialização do mapa
    document.head.appendChild(script);
  } else {
    initMap();
  }
});

// Função para inicializar o mapa
function initMap() {
  const mapOptions = {
    center: { lat: -23.55052, lng: -46.633308 }, // Coordenadas de um exemplo central (São Paulo, Brasil)
    zoom: 12,
    // Aqui você pode especificar outras opções do mapa.
  };

  // Cria um novo objeto Map dentro do elemento de contêiner
  const map = new google.maps.Map(mapContainer.value, mapOptions);

  // Aqui você pode adicionar mais lógica para manipular o mapa, como adicionar marcadores, etc.
}
</script>

<style scoped>
.map-container {
  height: 500px; /* Defina a altura que você deseja para o seu mapa*/
}
</style>
