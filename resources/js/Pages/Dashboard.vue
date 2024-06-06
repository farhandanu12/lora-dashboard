<template>
    <div :class="['app-container', { 'bg-dark text-white': isNightMode }]">
        <div class="container mt-5">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="text-center w-100">LoRa Dashboard</h1>
                <button @click="toggleMode" class="btn btn-secondary position-absolute top-0 end-0 mt-3 me-3">
                    <i :class="[isNightMode ? 'bi bi-sun-fill' : 'bi bi-moon-fill']"></i>
                    {{ isNightMode ? 'Day Mode' : 'Night Mode' }}
                </button>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-5 mb-4">
                    <div :class="['card text-center shadow-sm', { 'bg-secondary text-white': isNightMode }]">
                        <div :class="['card-header d-flex align-items-center justify-content-center', isNightMode ? 'bg-dark' : 'bg-primary text-white']">
                            <i class="bi bi-speedometer2 me-2"></i>
                            <h2 class="m-0">Frequency</h2>
                        </div>
                        <div class="card-body">
                            <span v-if="loading" class="spinner-border spinner-border-sm mb-2" :class="isNightMode ? 'text-light' : 'text-primary'" role="status" aria-hidden="true"></span>
                            <h3>{{ data.frequency }} Hz</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 mb-4">
                    <div :class="['card text-center shadow-sm', { 'bg-secondary text-white': isNightMode }]">
                        <div :class="['card-header d-flex align-items-center justify-content-center', isNightMode ? 'bg-dark' : 'bg-warning text-white']">
                            <i class="bi bi-lightning-charge me-2"></i>
                            <h2 class="m-0">Voltage</h2>
                        </div>
                        <div class="card-body">
                            <span v-if="loading" class="spinner-border spinner-border-sm mb-2" :class="isNightMode ? 'text-light' : 'text-warning'" role="status" aria-hidden="true"></span>
                            <h3>{{ data.voltage }} kV</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="text-center mt-5 py-3" :class="{ 'bg-dark text-white': isNightMode, 'bg-light text-dark': !isNightMode }">
            Kejar Tayang by Danu Muhammad Afarhan
        </footer>
    </div>
</template>

<script>
import { ref, onMounted, computed } from 'vue';
import axios from 'axios';

export default {
    setup() {
        const data = ref({});
        const loading = ref(true);
        const isNightMode = ref(JSON.parse(localStorage.getItem('isNightMode')) || false);

        onMounted(async () => {
            try {
                const response = await axios.get('/api/uplinks/chripstack');
                data.value = response.data;
            } catch (error) {
                console.error(error);
            } finally {
                loading.value = false;
            }
        });

        const toggleMode = () => {
            isNightMode.value = !isNightMode.value;
            localStorage.setItem('isNightMode', JSON.stringify(isNightMode.value));
        };

        const footerStyle = computed(() => ({
            textShadow: '0px 1px 2px rgba(0, 0, 0, 0.5)'
        }));

        return {
            data,
            loading,
            isNightMode,
            toggleMode,
            footerStyle
        };
    }
}
</script>

<style>
.app-container {
    min-height: 100vh;
    padding-top: 20px;
    padding-bottom: 20px;
}
.card-header {
    font-size: 1.5rem;
}
.card-body {
    font-size: 1.2rem;
}
.text-muted {
    font-size: 1.2rem;
}
.card {
    border-radius: 10px;
}
.shadow-sm {
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}
.bi {
    font-size: 1.5rem;
}
.bg-dark {
    background-color: #343a40 !important;
}
footer {
    background-color: inherit !important;
    color: inherit !important;
    text-shadow: 0px 1px 2px rgba(0, 0, 0, 0.5);
}
.position-absolute {
    position: absolute !important;
}
.top-0 {
    top: 0 !important;
}
.end-0 {
    right: 0 !important;
}
.mt-3 {
    margin-top: 1rem !important;
}
.me-3 {
    margin-right: 1rem !important;
}
</style>
