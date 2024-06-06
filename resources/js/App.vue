<template>
    <div :class="['app', theme]">
      <header class="header">
        <h1>LoRa Dashboard</h1>
        <button @click="toggleTheme" class="theme-switch">
          <span v-if="theme === 'light'">🌙 Night Mode</span>
          <span v-else>☀️ Day Mode</span>
        </button>
      </header>
      <main class="main">
        <div class="card-container">
          <div class="card frequency-card">
            <div class="card-header">
              <i class="bi bi-speedometer2"></i>
              <span>Frequency</span>
            </div>
            <div class="card-body">
              <p v-if="loading">Loading...</p>
              <p v-else>{{ frequency }} Hz</p>
            </div>
          </div>
          <div class="card voltage-card">
            <div class="card-header">
              <i class="bi bi-lightning-fill"></i>
              <span>Voltage</span>
            </div>
            <div class="card-body">
              <p v-if="loading">Loading...</p>
              <p v-else>{{ voltage }} kV</p>
            </div>
          </div>
        </div>
      </main>
      <footer class="footer">
        Kejar Tayang by Danu Muhammad Afarhan
      </footer>
    </div>
  </template>
  
  <script>
  import axios from 'axios';
  
  export default {
    name: 'App',
    data() {
      return {
        theme: 'light',
        frequency: null,
        voltage: null,
        loading: true
      };
    },
    mounted() {
      const savedTheme = localStorage.getItem('theme');
      if (savedTheme) {
        this.theme = savedTheme;
      }
      this.fetchData();
    },
    methods: {
      toggleTheme() {
        this.theme = this.theme === 'light' ? 'dark' : 'light';
        localStorage.setItem('theme', this.theme);
      },
      fetchData() {
        axios.get('https://iotdashboard.wg.ugm.ac.id/api/uplinks/chripstack')
          .then(response => {
            this.frequency = response.data.frequency;
            this.voltage = response.data.voltage;
            this.loading = false;
          })
          .catch(error => {
            console.error("There was an error fetching the data!", error);
            this.loading = false;
          });
      }
    }
  };
  </script>
  
  <style scoped>
  .app {
    text-align: center;
    transition: background-color 0.3s, color 0.3s;
  }
  .light {
    background-color: #fff;
    color: #000;
  }
  .dark {
    background-color: #333;
    color: #fff;
  }
  .header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    background-color: inherit;
  }
  .theme-switch {
    border: none;
    background: none;
    font-size: 1rem;
    cursor: pointer;
  }
  .main {
    padding: 2rem;
  }
  .card-container {
    display: flex;
    justify-content: center;
    gap: 2rem;
  }
  .card {
    padding: 1rem;
    border-radius: 0.5rem;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    transition: background-color 0.3s, color 0.3s;
  }
  .light .card {
    background-color: #fff;
    color: #000;
  }
  .dark .card {
    background-color: #444;
    color: #fff;
  }
  .card-header {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: bold;
  }
  .card-body {
    margin-top: 1rem;
    font-size: 1.5rem;
  }
  .footer {
    padding: 1rem;
    background-color: inherit;
    font-size: 0.875rem;
  }
  </style>
  