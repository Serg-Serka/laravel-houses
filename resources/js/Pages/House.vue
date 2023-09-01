<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from '@/Components/PrimaryButton.vue';
import InputError from "@/Components/InputError.vue";
import axios from "axios";
import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
import { reactive } from 'vue';

const store = reactive({
    houses: [],
    setHouses(data) {
        this.houses = data;
    },
    loading: true,
    setLoading(status) {
        this.loading = status;
    }
})

const form = useForm({
    name: '',
    bedrooms: '',
    bathrooms: '',
    storeys: '',
    garages: '',
    minPrice: '',
    maxPrice: '',
});

const headers = [
    {text: "Name", value: "name"},
    {text: "Price", value: "price"},
    {text: "Bedrooms", value: "bedrooms"},
    {text: "Bathrooms", value: "bathrooms"},
    {text: "Storeys", value: "storeys"},
    {text: "Garages", value: "garages"},
];

let search = () => {
    form.errors = [];
    store.setLoading(true);


    axios.post("/houses", {
        name: form.name,
        bedrooms: form.bedrooms,
        bathrooms: form.bathrooms,
        storeys: form.storeys,
        garages: form.garages,
        minPrice: form.minPrice,
        maxPrice: form.maxPrice,
    })
        .then(res => {
            if (res.data.success) {
                store.setHouses(res.data.houses);
            }
            store.setLoading(false);
        })
        .catch(err => {
            form.errors = err.response.data.errors;
            store.setLoading(false);
        })
};

</script>

<template>
    <Head title="Houses" />
    <div class="container houses-form-container">
        <form class="houses-form">
            <div>
                <InputLabel for="name">Name of house:</InputLabel>
                <input type="text" id="name" placeholder="Enter a name of house" v-model="form.name" />
            </div>

            <div>
                <div>
                    <InputLabel for="bedrooms">Choose a number of bedrooms:</InputLabel>
                    <TextInput type="number" min="0" id="bedrooms" v-model="form.bedrooms" />
                </div>
                <div>
                    <InputLabel for="bathrooms">Choose a number of bathrooms</InputLabel>
                    <TextInput type="number" min="0" id="bathrooms"  v-model="form.bathrooms" />
                </div>
                <div >
                    <InputLabel for="storeys">Choose a number of storeys:</InputLabel>
                    <TextInput type="number" min="0" id="storeys" v-model="form.storeys" />
                </div>
                <div>
                    <InputLabel for="garages">Choose a number of garages:</InputLabel>
                    <TextInput type="number" min="0" id="garages" v-model="form.garages"/>
                </div>
            </div>

            <div>
                <div>
                    <InputLabel for="minPrice">Choose minimal price:</InputLabel>
                    <TextInput type="number" min="100000" step="1000" id="minPrice" v-model="form.minPrice"/>
                    <InputError :message="form.errors.minPrice" class="mt-2" />
                </div>
                <div>
                    <InputLabel for="maxPrice">Choose maximal price:</InputLabel>
                    <TextInput type="number" min="100000" step="1000" id="maxPrice" v-model="form.maxPrice"/>
                    <InputError :message="form.errors.maxPrice" class="mt-2" />
                </div>
            </div>
            <PrimaryButton type="button" @click="search" class="mt-4">Search</PrimaryButton>
        </form>

        <br>
        <div id="result" v-if="!store.loading && store.houses.length > 0">
            <Vue3EasyDataTable
                :headers="headers"
                :items="store.houses"
                alternating
                border-cell
                class="houses-table"
            >
            </Vue3EasyDataTable>
        </div>

        <div v-if="!store.loading && store.houses.length === 0">
            <span>No results found by this request...</span>
        </div>

        <div v-if="store.loading" class="houses-loader">
            <img src="../../Spinner-1s-200px.gif" width="200" alt="loading...">
        </div>


    </div>

</template>

